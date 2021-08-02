<?php
/**
|--------------------------------------------------------------------------
| Remove user roles.
|--------------------------------------------------------------------------
|
| @param  string  $role
| @return void
|
| @link https://developer.wordpress.org/reference/functions/remove_role/
*/
remove_role('editor');
remove_role('author');
remove_role('subscriber');
remove_role('contributor');
remove_role('shop_manager');

/**
|--------------------------------------------------------------------------
| Add user roles.
|--------------------------------------------------------------------------
|
| Returns null if role already exists.
|
| @param  string  $role
| @param  string  $display_name
| @param  bool[]  $capabilities
| @return WP_Role|null
|
| @link https://developer.wordpress.org/reference/classes/wp_role/add_cap/
*/

add_role('verified_customer', 'Klient zweryfikowany', [
    'read' => true,
    'order_products' => true,
]);

/**
|--------------------------------------------------------------------------
| Modify user role capabilities.
|--------------------------------------------------------------------------
|
| @param  string  $role
| @return WP_Role
|
| @link https://developer.wordpress.org/reference/functions/get_role/
*/

get_role('administrator')->add_cap('order_products');

/**
|--------------------------------------------------------------------------
| Fires after WordPress has finished loading but before headers are sent.
|--------------------------------------------------------------------------
| 
| Most of the WordPress is loaded at this stage, and the user is
| authenticated. WP continues to load on the ‘init’ hook that follows
| (e.g. widgets), and many plugins instantiate themselves on it for all
| sorts of reasons (e.g. they need a user, a taxonomy, etc.).
|
| @return void
|
| @link https://developer.wordpress.org/reference/hooks/init/
*/

add_action('init', function (): void {
    /**
     * An array of all registered taxonomies.
     * 
     * @var array
     */
    global $wp_taxonomies;

    /**
     * Remove WooCommerce's product tag taxonomy.
     * 
     * @param  mixed  $var
     * @return void
     */
    //unset($wp_taxonomies['product_tag']);

    /**
     * Register am "authorized_store" post type.
     * 
     * @param  string  $name
     * @param  array  $attributes
     * @return WP_Post_Type|WP_Error
     * 
     * @link https://developer.wordpress.org/reference/functions/register_post_type/
     */
    register_post_type('store', [
        'labels' => [
            'name' => 'Sklepy',
            'add_new' => 'Dodaj sklep',
            'new_item' => 'Nowy sklep',
            'edit_item' => 'Edytuj sklep',
            'view_item' => 'Zobacz sklep',
            'all_items' => 'Wszystkie sklepy',
            'not_found' => 'Nie znaleziono żadnych sklepów',
            'items_list' => 'Lista sklepów',
            'view_items' => 'Zobacz sklepy',
            'attributes' => 'Atrybuty sklepu',
            'search_items' => 'Znajdź sklepy',
            'add_new_item' => 'Dodaj nowy sklep',
            'item_updated' => 'Sklep zaktualizowany',
            'singular_name' => 'Sklep',
            'item_scheduled' => 'Sklep zaplanowany',
            'item_published' => 'Sklep został opublikowany',
            'insert_into_item' => 'Wstaw do sklepu',
            'filter_items_list' => 'Filtruj listę sklepów',
            'not_found_in_trash' => 'Nie znaleziono sklepów w koszu',
            'items_list_navigation' => 'Nawigacja listy sklepów',
            'uploaded_to_this_item' => 'Przesłano do tego sklepu',
            'item_reverted_to_draft' => 'Sklep przywrócony do wersji roboczej',
            'item_published_privately' => 'Sklep opublikowany jako prywatny',
        ],
        'show_ui' => true,
        'menu_icon' => 'dashicons-store',
        'description' => 'Autoryzowane sklepy',
        'menu_position' => 20,
    ]);

    /**
     * Register a "city" taxonomy for store post type.
     * 
     * @param  string  $name
     * @param  array|string  $post_types
     * @param  array  $attributes
     * @return WP_Taxonomy|WP_Error
     */
    register_taxonomy('city', 'store', [
        'labels' => [
            'name' => 'Miasta',
            'no_terms' => 'Brak miast',
            'edit_item' => 'Edytuj miasto',
            'view_item' => 'Zobacz miasto',
            'all_items' => 'Wszystkie miasta',
            'not_found' => 'Nie znaleziono miast',
            'update_item' => 'Zaktualizuj miasto',
            'search_items' => 'Znajdź miasta',
            'add_new_item' => 'Dodaj nowe miasto',
            'singular_name' => 'Miasto',
            'popular_items' => 'Popularne miasta',
            'new_item_name' => 'Nazwa nowego miasta',
            'back_to_items' => 'Powrót do listy sklepów',
            'add_or_remove_items' => 'Dodaj lub usuń miasta',
            'choose_from_most_used' => 'Wybierz z najczęściej przypisywanych miast',
            'separate_items_with_commas' => 'Oddziel miasta przecinkami',
        ],
        'query_var' => 'miasto',
        'meta_box_cb' => false,
        'show_in_nav_menus' => false,
    ]);

    /**
     * Register a "manufacturer" taxonomy for WooCommerce's product post type.
     * 
     * @param  string  $name
     * @param  array|string  $post_types
     * @param  array  $attributes
     * @return WP_Taxonomy|WP_Error
     */
    register_taxonomy('manufacturer', 'product', [
        'labels' => [
            'name' => 'Producenci',
            'no_terms' => 'Brak producentów',
            'archives' => 'Wszyscy producenci',
            'menu_name' => 'Producenci',
            'most_used' => 'Popularni producenci',
            'edit_item' => 'Edytuj producenta',
            'view_item' => 'Zobacz producenta',
            'all_items' => 'Wszyscy producenci',
            'not_found' => 'Nie znaleziono producentów',
            'item_link' => 'Link producenta produktu',
            'items_list' => 'Lista producentów',
            'update_item' => 'Aktualizuj producenta',
            'search_items' => 'Znajdź producenta',
            'add_new_item' => 'Dodaj nowego producenta',
            'singular_name' => 'Producent',
            'popular_items' => 'Popularni producenci',
            'new_item_name' => 'Nowa nazwa producenta',
            'back_to_items' => '&larr; Przejdź do producentów',
            'name_admin_bar' => 'Producent',
            'add_or_remove_items' => 'Dodaj lub usuń producentów',
            'items_list_navigation' => 'Nawigacja listy producentów',
            'item_link_description' => 'Link do producenta produktu.',
            'choose_from_most_used' => 'Wybierz z najczęściej używanych producentów',
            'separate_items_with_commas' => 'Oddziel producentów przecinkami',
        ],
        'public' => true,
        'query_var' => 'manufacturer',
        'rewrite' => [
            'slug' => 'producent',
            'ep_mask' => 0,
        ],
        'meta_box_cb' => false,
        'capabilities' => [
            'edit_terms' => 'edit_product_terms',
            'manage_terms' => 'manage_product_terms',
            'assign_terms' => 'assign_product_terms',
            'delete_terms' => 'delete_product_terms',
        ],
    ]);
});

/**
|--------------------------------------------------------------------------
| Fires after ACF is fully initialized.
|--------------------------------------------------------------------------
|
| This action is similar to the WordPress init action, and should be used
| to extend or register items such as Blocks, Forms and Options Pages.
|
| @return void
|
| @link https://www.advancedcustomfields.com/resources/acf-init/
*/

add_action('acf/init', function (): void {
    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_1',
        'location' => [
            [
                [
                    'param' => 'nav_menu_item',
                    'value' => 'location/footer_1',
                    'operator' => '=='
                ],
            ],
        ],
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_1',
        'name' => 'file',
        'type' => 'file',
        'label' => 'Plik',
        'parent' => 'group_1',
        'mime_types' => 'pdf',
        'return_format' => 'url',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_2',
        'title' => 'Katalogi produktów',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'value' => 'page-templates/home.php',
                    'operator' => '=='
                ],
            ],
        ],
        'hide_on_screen' => [
            'slug',
            'author',
            'comments',
            'revisions',
            'discussion',
            'the_content',
            'featured_image',
        ],
        'label_placement' => 'left',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_2',
        'name' => 'product_catalogs',
        'type' => 'repeater',
        'layout' => 'row',
        'parent' => 'group_2',
        'collapsed' => 'field_3',
        'button_label' => 'Dodaj katalog',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_3',
        'name' => 'cover',
        'type' => 'image',
        'label' => 'Okładka',
        'parent' => 'field_2',
        'mime_types' => 'jpg, jpeg, png, svg',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_4',
        'name' => 'lead',
        'type' => 'textarea',
        'label' => 'Wprowadzenie',
        'height' => 3,
        'parent' => 'field_2',
        'new_lines' => 'br',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_6',
        'name' => 'file',
        'type' => 'file',
        'label' => 'Plik',
        'parent' => 'field_2',
        'mime_types' => 'pdf',
        'return_format' => 'url',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_3',
        'title' => 'Wprowadzenie',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'value' => 'page-templates/stores.php',
                    'operator' => '=='
                ],
            ],
        ],
        'hide_on_screen' => [
            'slug',
            'author',
            'comments',
            'revisions',
            'discussion',
            'the_content',
            'featured_image',
        ],
        'label_placement' => 'left',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_7',
        'name' => 'masthead',
        'type' => 'group',
        'layout' => 'row',
        'parent' => 'group_3',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_8',
        'rows' => 4,
        'name' => 'lead',
        'type' => 'textarea',
        'label' => 'Treść',
        'parent' => 'field_7',
        'new_lines' => 'br',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_10',
        'name' => 'file',
        'type' => 'file',
        'label' => 'Plik',
        'parent' => 'field_7',
        'mime_types' => 'pdf',
        'return_format' => 'url',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_11',
        'name' => 'image',
        'type' => 'image',
        'label' => 'Zdjęcie',
        'parent' => 'field_7',
        'mime_types' => 'jpg, jpeg, png, svg',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_4',
        'title' => 'Adres',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'value' => 'store',
                    'operator' => '==',
                ],
            ],
        ],
        'hide_on_screen' => [
            'slug',
            'author',
            'comments',
            'revisions',
            'discussion',
            'the_content',
            'featured_image',
        ],
        'label_placement' => 'left',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_12',
        'name' => 'address',
        'type' => 'group',
        'layout' => 'row',
        'parent' => 'group_4',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_13',
        'name' => 'street',
        'type' => 'text',
        'label' => 'Ulica',
        'parent' => 'field_12',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_14',
        'name' => 'city',
        'type' => 'taxonomy',
        'label' => 'Miasto',
        'parent' => 'field_12',
        'taxonomy' => 'city',
        'allow_null' => true,
        'load_terms' => true,
        'save_terms' => true,
        'field_type' => 'select',
        'return_format' => 'object',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_15',
        'name' => 'postcode',
        'type' => 'text',
        'label' => 'Kod pocztowy',
        'parent' => 'field_12',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_16',
        'name' => 'map',
        'type' => 'url',
        'label' => 'Link do mapy',
        'parent' => 'field_12',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_5',
        'title' => 'Godziny otwarcia',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'value' => 'store',
                    'operator' => '==',
                ],
            ],
        ],
        'hide_on_screen' => [
            'slug',
            'author',
            'comments',
            'revisions',
            'discussion',
            'the_content',
            'featured_image',
        ],
        'label_placement' => 'left',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_17',
        'name' => 'open',
        'type' => 'group',
        'layout' => 'row',
        'parent' => 'group_5',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_18',
        'name' => 'business',
        'type' => 'text',
        'label' => 'Poniedziałek - Piątek',
        'parent' => 'field_17',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_19',
        'name' => 'saturday',
        'type' => 'text',
        'label' => 'Sobota',
        'parent' => 'field_17',
        'placeholder' => 'Nie wypełniaj, jeśli nieczynne',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_20',
        'name' => 'sunday',
        'type' => 'text',
        'label' => 'Niedziela',
        'parent' => 'field_17',
        'placeholder' => 'Nie wypełniaj, jeśli nieczynne',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_6',
        'title' => 'Dane kontaktowe',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'value' => 'store',
                    'operator' => '==',
                ],
            ],
        ],
        'hide_on_screen' => [
            'slug',
            'author',
            'comments',
            'revisions',
            'discussion',
            'the_content',
            'featured_image',
        ],
        'label_placement' => 'left',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_21',
        'name' => 'contact',
        'type' => 'group',
        'layout' => 'row',
        'parent' => 'group_6',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_22',
        'name' => 'phone',
        'type' => 'text',
        'label' => 'Telefon',
        'parent' => 'field_21',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_23',
        'name' => 'email',
        'type' => 'email',
        'label' => 'E-mail',
        'parent' => 'field_21',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_24',
        'name' => 'website',
        'type' => 'url',
        'label' => 'Strona internetowa',
        'parent' => 'field_21',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_7',
        'title' => 'Producent',
        'position' => 'side',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'value' => 'product',
                    'operator' => '==',
                ],
            ],
        ],
        'hide_on_screen' => [
            'slug',
            'author',
            'comments',
            'revisions',
            'discussion',
        ],
        'label_placement' => 'left',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_25',
        'name' => 'manufacturer',
        'type' => 'taxonomy',
        'parent' => 'group_7',
        'taxonomy' => 'manufacturer',
        'allow_null' => true,
        'load_terms' => true,
        'save_terms' => true,
        'field_type' => 'select',
        'return_format' => 'object',
    ]);

    /**
     * Add a field group to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field_group([
        'key' => 'group_8',
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'value' => 'manufacturer',
                    'operator' => '==',
                ],
            ],
        ],
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_26',
        'name' => 'logo_profile',
        'type' => 'image',
        'label' => 'Logo (profilowe)',
        'parent' => 'group_8',
        'mime_types' => 'jpg, jpeg, png, svg',
    ]);

    /**
     * Add a field to the local cache.
     * 
     * @param  array  $attributes
     * @return void
     * 
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
     */
    acf_add_local_field([
        'key' => 'field_27',
        'name' => 'logo',
        'type' => 'image',
        'label' => 'Logo',
        'parent' => 'group_8',
        'mime_types' => 'jpg, jpeg, png, svg',
    ]);
});

/**
|--------------------------------------------------------------------------
| Fires after WooCommerce's product SKU field gets outputted.
|--------------------------------------------------------------------------
|
| @return void
|
| @link https://woocommerce.github.io/code-reference/files/woocommerce-includes-admin-meta-boxes-views-html-product-data-inventory.html
*/
add_action('woocommerce_product_options_sku', function (): void {
    /**
     * Output a text input form field.
     * 
     * @param  array  $attributes
     * @return void
     */
    woocommerce_wp_text_input([
        'id' => '_ean',
        'type' => 'text',
        'label' => "EAN",
        'custom_attributes' => [
            'pattern' => "[0-9]{1,13}",
            'maxlength' => '13',
        ],
    ]);
});

/**
|--------------------------------------------------------------------------
| Fires after WooCommerce's product pricing fields gets outputted.
|--------------------------------------------------------------------------
|
| @return void
|
| @link https://woocommerce.github.io/code-reference/files/woocommerce-includes-admin-meta-boxes-views-html-product-data-general.html
*/
add_action('woocommerce_product_options_pricing', function (): void {
    /**
     * Return the WooCommerce's currency symbol.
     * 
     * @return string
     */
    $currency_symbol = get_woocommerce_currency_symbol();

    /**
     * Output a text input form field.
     * 
     * @param  array  $attributes
     * @return void
     */
    woocommerce_wp_text_input([
        'id' => '_suggested_detail_price',
        'label' => "Sugerowana cena detaliczna ($currency_symbol)",
        'data_type' => 'price',
    ]);
});

/**
|--------------------------------------------------------------------------
| Fires before WooCommerce's product is saved to the database.
|--------------------------------------------------------------------------
|
| @param  WC_Product  $product
| @return void
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Meta-Box-Product-Data.html#method_save
*/
add_action('woocommerce_admin_process_product_object', function (WC_Product $product): void {
    if (isset($_POST['_ean'])) {
        /**
         * Update meta data attribute for the given key.
         * 
         * @param  string  $key
         * @param  mixed  $value
         * @return void
         */
        $product->update_meta_data('_ean', wc_clean($_POST['_ean']));
    }

    if (isset($_POST['_suggested_detail_price'])) {
        /**
         * Update meta data attribute for the given key.
         * 
         * @param  string  $key
         * @param  mixed  $value
         * @return void
         */
        $product->update_meta_data('_suggested_detail_price', wc_clean($_POST['_suggested_detail_price']));
    }
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's general settings fields.
|--------------------------------------------------------------------------
|
| @param  array  $fields
| @return array
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Settings-General.html#method_get_settings
*/

add_filter('woocommerce_general_settings', function (array $fields = []): array {
    // Modify "woocommerce_store_address" field's title.
    $fields[1]['title'] = 'Ulica';

    // Remove "woocommerce_store_address_2" field.
    unset($fields[2]);

    // Add custom fields to the beginning of the settings.
    array_unshift($fields,
        [
            'type' => 'title',
            'name' => 'Dane kontaktowe sklepu',
        ],
        [
            'id' => 'igrepti_store_contact_phone',
            'type' => 'tel',
            'name' => 'Telefon',
        ],
        [
            'id' => 'igrepti_store_contact_email',
            'type' => 'email',
            'name' => 'E-mail',
        ],
        [
            'type' => 'sectionend',
        ],
        [
            'type' => 'title',
            'name' => 'Godziny pracy sklepu',
        ],
        [
            'id' => 'igrepti_store_open_business_days',
            'type' => 'text',
            'name' => 'Poniedziałek - Piątek',
        ],
        [
            'id' => 'igrepti_store_open_saturday',
            'type' => 'text',
            'name' => 'Sobota',
            'placeholder' => 'Zostaw puste jeśli nieczynne'
        ],
        [
            'id' => 'igrepti_store_open_sunday',
            'type' => 'text',
            'name' => 'Niedziela',
            'placeholder' => 'Zostaw puste jeśli nieczynne'
        ],
        [
            'type' => 'sectionend',
        ]
    );

    return $fields;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's shipping methods.
|--------------------------------------------------------------------------
|
| @param  array  $methods
| @return array
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Settings-General.html#method_get_settings
*/

add_filter('woocommerce_shipping_methods', function (array $methods = []): array {
    // Remove shipping methods.
    unset($methods['free_shipping']);

    // Replace "flat_rate" method with custom one.
    $methods['flat_rate'] = 'IG_Shipping_Class_Rate';

    // Include the custom "class_rate" shipping method class file.
    require_once __DIR__.'/includes/shipping/class-ig-shipping-class-rate.php';

    return $methods;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's account & privacy settings fields.
|--------------------------------------------------------------------------
|
| @param  array  $fields
| @return array
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Settings-Accounts.html#method_get_settings
*/

add_filter('woocommerce_account_settings', function (array $fields = []): array {
    // Copy "registration_privacy_policy" field to "contact_privacy_policy" with few modifications.
    array_splice($fields, 12, 0, [
        array_merge($fields[12], [
            'id' => 'igrepti_contact_privacy_policy_text',
            'title' => 'Polityka prywatności kontaktu',
            'default' => 'Zgadzam się na przetwarzanie moich danych osobowych w celu odpowiedzi na moją wiadomość, drogą telefoniczną lub poprzez e‑mail oraz dla innych celów o których mówi nasza [privacy_policy].',
            'desc_tip' => 'Opcjonalnie dodaj informacje na temat polityki prywatności sklepu, aby wyświetlić go w formularzu kontaktowym.',
        ]),
    ]);

    array_splice($fields, 1, 0, [[
        'id' => 'igrepti_unverified_customer_message_text',
        'css' => 'min-width: 50%; height: 75px',
        'type' => 'textarea',
        'title' => 'Instrukcja dla nowego klienta',
        'desc_tip' => 'Dodaj wiadomość dla klienta, który nie został jeszcze poddany weryfikacji.',
    ]]);

    return $fields;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's registration form required fields.
|--------------------------------------------------------------------------
|
| @param  array  $fields
| @return array
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Form-Handler.html#method_save_account_details
*/

add_filter('woocommerce_save_account_details_required_fields', function (array $fields = []): array {
    // Remove required fields.
    unset($fields['account_first_name'], $fields['account_last_name'], $fields['account_display_name']);

    return $fields;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's admin profile fields.
|--------------------------------------------------------------------------
|
| @param  array  $fields
| @return array
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Admin-Profile.html#method_get_customer_meta_fields
*/

add_filter('woocommerce_customer_meta_fields' , function (array $fields = []): array {
    // Remove unused fields.
    unset(
        $fields['billing']['fields']['billing_first_name'],
        $fields['billing']['fields']['billing_last_name'],
        $fields['billing']['fields']['billing_address_2'],
        $fields['billing']['fields']['billing_state'],
        $fields['billing']['fields']['billing_country'],
        $fields['billing']['fields']['billing_email'],
        $fields['shipping']['fields']['shipping_first_name'],
        $fields['shipping']['fields']['shipping_last_name'],
        $fields['shipping']['fields']['shipping_company'],
        $fields['shipping']['fields']['shipping_address_2'],
        $fields['shipping']['fields']['shipping_state'],
        $fields['shipping']['fields']['shipping_country']
    );

    // Replace field's default attributes with custom ones.
    $fields = array_replace_recursive($fields, [
        'billing' => [
            'fields' => [
                'billing_address_1' => [
                    'label' => 'Ulica',
                ],
            ],
        ],
        'shipping' => [
            'fields' => [
                'shipping_address_1' => [
                    'label' => 'Ulica',
                ],
            ],
        ],
    ]);

    // Insert "billing_nip" fields right after "billing_company".
    $billing_address_1_key = array_search('billing_address_1', array_keys($fields['billing']['fields']));

    $fields['billing']['fields'] = array_merge( 
        array_slice($fields['billing']['fields'], 0, $billing_address_1_key),
        [
            'billing_nip' => [
                'label' 	  => 'NIP',
                'description' => '',
            ],
        ],
        array_slice($fields['billing']['fields'], $billing_address_1_key)
    );
    
    return $fields;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's checkout fields.
|--------------------------------------------------------------------------
|
| @param  array  $fields
| @return array
| 
| @link https://woocommerce.github.io/code-reference/classes/WC-Checkout.html#method_get_checkout_fields
*/

add_filter('woocommerce_checkout_fields', function (array $fields = []): array {
    unset(
        $fields['billing']['billing_city']['required'],
        $fields['billing']['billing_email']['required'],
        $fields['billing']['billing_phone']['required'],
        $fields['billing']['billing_country']['required'],
        $fields['billing']['billing_postcode']['required'],
        $fields['billing']['billing_postcode']['validate'],
        $fields['billing']['billing_address_1']['required'],
        $fields['shipping']['shipping_country']['required'],
    );
    return $fields;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's products order options in admin panel.
|--------------------------------------------------------------------------
|
| @param  array  $options
| @return array
| 
| @link
*/

add_filter('woocommerce_default_catalog_orderby_options', function (array $options = []): array {
    unset($options['popularity'], $options['rating'], $options['date']);

    $options['name'] = 'Nazwa (A do Z)';
    $options['name-desc'] = 'Nazwa (Z do A)';

    return $options;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's products order options on the front-end.
|--------------------------------------------------------------------------
|
| @param  array  $options
| @return array
| 
| @link
*/

add_filter('woocommerce_catalog_orderby', function (array $options = []): array {
    unset($options['popularity'], $options['rating'], $options['date']);

    if (current_user_can('order_products')) {
        $options['price'] = 'Cena: od najniższej';
        $options['price-desc'] = 'Cena: od najwyższej';
    } else {
        unset($options['price'], $options['price-desc']);
    }

    $options['name'] = 'Nazwa: A do Z';
    $options['name-desc'] = 'Nazwa: Z do A';

    return $options;
});

/**
|--------------------------------------------------------------------------
| Filters WooCommerce's products order parameters.
|--------------------------------------------------------------------------
|
| @param  array  $parameters
| @return array
| 
| @link
*/

add_filter('woocommerce_get_catalog_ordering_args', function (array $parameters = []) {
    if ($parameters['orderby'] == 'name') {
        $parameters['orderby'] = 'title';
    }

    return $parameters;
});

/**
|--------------------------------------------------------------------------
| Process contact form.
|--------------------------------------------------------------------------
|
| @return bool|null
*/

add_filter('igrepti_process_contact_form', function() {
    if (isset($_POST['contact_form_submit'])) {

        $to = get_option('igrepti_store_contact_email');
        
        if (! empty($to)) {
            $from = wc_clean($_POST['email']);
            $header = [
                "From: <{$from}>",
            ];
            $message = wc_clean($_POST['message']);
            $subject = '['.get_bloginfo('name').'] Nowa wiadomość';

            return wp_mail($to, $subject, $message, $headers);
        }
    }

    return null;
});

/**
|--------------------------------------------------------------------------
| Fires before determining which template to load.
|--------------------------------------------------------------------------
|
| This action hook executes just before WordPress determines which template
| page to load. It is a good hook to use if you need to do a redirect with
| full knowledge of the content that has been queried.
|
| @return void
|
| @link https://developer.wordpress.org/reference/hooks/template_redirect/
*/

add_action('template_redirect', function (): void {
    global $wp;

    // There is no request for back-in-stock subscription so we bail early.
    if (! isset($_POST['subscribe_back_in_stock']) && ! isset($_POST['unsubscribe_back_in_stock'])) {
        return;
    }

    $user_id = get_current_user_id();
    $product_id = wc_clean($_POST['subscribe_back_in_stock'])?: wc_clean($_POST['unsubscribe_back_in_stock']);
    $subscribers = get_post_meta($product_id, 'back_in_stock_subscribers', true);

    if (! is_array($subscribers)) {
        $subscribers = [];
    }

    if (isset($_POST['subscribe_back_in_stock']) && ! in_array($user_id, $subscribers)) {
        $subscribers[] = $user_id;
    } else if (isset($_POST['unsubscribe_back_in_stock']) && in_array($user_id, $subscribers)) {
        unset($subscribers[array_search($user_id, $subscribers)]);
    }

    update_post_meta($product_id, 'back_in_stock_subscribers', $subscribers);

    nocache_headers();

    wp_safe_redirect(home_url($wp->request));
});

/**
|--------------------------------------------------------------------------
| Fires WooCommerce's product has been updated.
|--------------------------------------------------------------------------
|
| @param  WC_Product  $product
| @return void
|
| @link https://woocommerce.wp-a2z.org/oik_api/wc_meta_box_product_datasave/
*/

add_action('woocommerce_admin_process_product_object', function (WC_Product $product): void {
    // Quantity hasn't changed so we bail early.
    if (0 >= $product->get_stock_quantity()) {
        return;
    }

    // Retrive the subscribers from given product's meta.
    $subscribers = get_post_meta($product->get_id(), 'back_in_stock_subscribers', true);

    // No one has subscribed to this product's availability.
    if (empty($subscribers)) {
        return;
    }

    // Clear the subscribes from the given product's meta.
    update_post_meta( $product_id, 'igrepti_notification_enabled_user_ids', []);

    $from = new stdClass;
    $from->url = home_url();
    $from->name = get_bloginfo('name');
    $from->email = get_option('igrepti_store_email');

    $header = [
        "From: {$from->name} <{$from->email}>",
    ];

    $subject = "{$product->get_name()} już można zamawiać!";

    $content = "
        Szanowni Państwo,<br>
        <br>
        Informujemy, że <a href='{$product->get_permalink()}'>{$product->get_name()}</a>, którym są Państwo zainteresowani już można zamawiać.<br>
        <br>
        Zamówienia można składać w naszej hurtowni on-line <a href='{$from->url}'>{$from->name}.</a><br>
        <br>
        Zapraszamy do zakupu,<br>
        Hurtownia IGRepti";
    
    foreach ($user_ids as $user_id) {
        $user_data = get_userdata($user_id);
        if (! empty($user_data)) {
            wp_mail($user_data->user_email, $subject, $content, $header);
        }
    }
});


