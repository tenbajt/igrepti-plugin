<?php
/**
|--------------------------------------------------------------------------
| Custom shipping method which extends "flat_rate".
|--------------------------------------------------------------------------
| @link https://woocommerce.github.io/code-reference/files/woocommerce-includes-shipping-flat-rate-class-wc-shipping-flat-rate.html
*/

class IG_Shipping_Class_Rate extends WC_Shipping_Flat_Rate
{
    /**
     * Create a new shipping method instance.
     * 
     * @param  int  $instance_id
     * @return void
     */
    public function __construct(int $instance_id = 0)
    {
        parent::__construct($instance_id);

        $this->method_title = 'Kurier';
        $this->method_description = 'Pozwala na ustawienie kosztów wysyłki dla poszczególnych klas wysyłkowych.';

        $this->parse_instance_form_fields($this->instance_form_fields);
    }

    /**
     * Parse the shipping method's settings form fields.
     * 
     * @param  array  $fields
     * @return void
     */
    public function parse_instance_form_fields(array &$fields = []): void
    {
        // Replace field's default attributes with custom ones.
        $fields = array_replace_recursive($fields, [
            'title' => [
                'order' => 1,
                'title' => 'Nazwa',
                'description' => 'Nazwa, którą widzi klient podczas składania zamówienia.',
            ],
            'tax_status' => [
                'order' => 2,
            ],
            'cost' => [
                'order' => 3,
                'description' => 'Koszt wysyłki zamówienia (bez podatku).',
            ],
            'free' => [
                'type' => 'text',
                'order' => 4,
                'title' => 'Darmowa wysyłka',
                'desc_tip' => true,
                'description' => 'Kwota zamówienia (bez podatku) po przekroczeniu której, klient nie ponosi kosztów wysyłki.',
            ],
        ]);
        
        // Add fields for each product's shipping class.
        foreach (WC()->shipping()->get_shipping_classes() as $key => $shipping_class) {
            if (! isset($shipping_class->term_id)) {
                continue;
            }

            // Replace field's default attributes for the shipping class.
            $fields = array_replace_recursive($fields, [
                "class_{$shipping_class->term_id}" => [
                    'type' => 'title',
                    'order' => ($key * 3) + 5,
                    'title' => $shipping_class->name,
                    'description' => sprintf('Koszt oraz darmową wysyłkę można opcjonalnie dodać w oparciu o <a href="%s">klasę wysyłkową produktu</a>.', admin_url('admin.php?page=wc-settings&tab=shipping&section=classes')),
                ],
                "class_cost_{$shipping_class->term_id}" => array_merge($fields['cost'], [
                    'order' => ($key * 3) + 6,
                ]),
                "class_free_{$shipping_class->term_id}" => array_merge($fields['free'], [
                    'order' => ($key * 3) + 7,
                ]),
            ]);
        }

        // Remove unused default fields.
        unset($fields['type'], $fields['class_costs'], $fields['no_class_cost']);

        // Sort the fields by our custom order.
        uasort($fields, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
    }

    /**
     * Calculate the shipping method's cost.
     * 
     * @param  array  $package
     * @return void
     * 
     * @link https://woocommerce.github.io/code-reference/classes/WC-Shipping-Flat-Rate.html#method_calculate_shipping
     */
    public function calculate_shipping($package = [])
    {
        $rate = [
            'id' => $this->get_rate_id(),
            'cost' => $this->get_option('cost', ''),
            'free' => $this->get_option('free', ''),
			'label' => $this->title,
			'package' => $package,
        ];

        if (! empty(WC()->shipping()->get_shipping_classes())) {
            $shipping_class = null;

            foreach ($package['contents'] as $cart_item) {
                switch ($cart_item['data']->get_shipping_class()) {
                    case 'pallet':
                        $shipping_class = 'pallet';
                        break 2;
                    case 'half-pallet':
                        if ($cart_item['quantity'] > 1 || $shipping_class === 'half-pallet') {
                            $shipping_class = 'pallet';
                            break 2;
                        } else {
                            $shipping_class = 'half-pallet';
                            break;
                        }
                }
            }

            $shipping_class = get_term_by('slug', $shipping_class, 'product_shipping_class');

            if ($shipping_class && $shipping_class->term_id) {
                $cost = $this->get_option("class_cost_{$shipping_class->term_id}", '');

                if (! empty($cost)) {
                    $rate['cost'] = $cost;
                    $rate['free'] = $this->get_option("class_free_{$shipping_class->term_id}", '');
                }
            }
        }

        if (empty($rate['cost'])) return;

        if (! empty($rate['free']) && $package['contents_cost'] > $rate['free']) {
            $rate['cost'] = 0;
        }

        $this->add_rate($rate);
    }
}