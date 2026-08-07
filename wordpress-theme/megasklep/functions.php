<?php
/**
 * MegaSklep — WordPress + WooCommerce Theme
 * functions.php
 */

defined('ABSPATH') || exit;

define('MEGASKLEP_VERSION', '1.0.0');
define('MEGASKLEP_DIR', get_template_directory());
define('MEGASKLEP_URI', get_template_directory_uri());

/* ============================================================
   THEME SETUP
============================================================ */
function megasklep_setup() {
    load_theme_textdomain('megasklep', MEGASKLEP_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('custom-logo', ['height' => 60, 'width' => 200, 'flex-width' => true]);
    add_theme_support('editor-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    register_nav_menus([
        'primary'  => __('Menu główne', 'megasklep'),
        'footer-1' => __('Stopka — Sklep', 'megasklep'),
        'footer-2' => __('Stopka — Pomoc', 'megasklep'),
        'footer-3' => __('Stopka — Firma', 'megasklep'),
    ]);
}
add_action('after_setup_theme', 'megasklep_setup');

/* ============================================================
   ENQUEUE ASSETS
============================================================ */
function megasklep_assets() {
    wp_enqueue_style('megasklep-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@400;600;700;800&display=swap',
        [], null);

    wp_enqueue_style('megasklep-style',
        MEGASKLEP_URI . '/assets/css/megasklep.css',
        ['megasklep-fonts'], MEGASKLEP_VERSION);

    wp_enqueue_script('megasklep-js',
        MEGASKLEP_URI . '/assets/js/megasklep.js',
        [], MEGASKLEP_VERSION, true);

    // Pass data to JS
    wp_localize_script('megasklep-js', 'megaSklepData', [
        'ajaxUrl'       => admin_url('admin-ajax.php'),
        'nonce'         => wp_create_nonce('megasklep_nonce'),
        'cartUrl'       => wc_get_cart_url(),
        'checkoutUrl'   => wc_get_checkout_url(),
        'currencySymbol'=> get_woocommerce_currency_symbol(),
        'freeShipping'  => get_option('megasklep_free_shipping', 299),
        'i18n'          => [
            'addedToCart'    => __('Dodano do koszyka', 'megasklep'),
            'removedFromCart'=> __('Usunięto z koszyka', 'megasklep'),
            'addedToWishlist'=> __('Dodano do ulubionych', 'megasklep'),
            'freeShipping'   => __('Masz darmową dostawę!', 'megasklep'),
            'freeShippingLeft'=> __('Do darmowej dostawy:', 'megasklep'),
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'megasklep_assets');

/* ============================================================
   WIDGET AREAS
============================================================ */
function megasklep_widgets() {
    $defaults = ['before_widget' => '<div class="widget %2$s">', 'after_widget' => '</div>',
                 'before_title'  => '<h4 class="widget-title">', 'after_title'  => '</h4>'];

    register_sidebar(array_merge($defaults, ['id' => 'shop-sidebar', 'name' => __('Pasek boczny sklepu', 'megasklep')]));
    register_sidebar(array_merge($defaults, ['id' => 'footer-1', 'name' => __('Stopka — kolumna 1', 'megasklep')]));
    register_sidebar(array_merge($defaults, ['id' => 'footer-2', 'name' => __('Stopka — kolumna 2', 'megasklep')]));
    register_sidebar(array_merge($defaults, ['id' => 'footer-3', 'name' => __('Stopka — kolumna 3', 'megasklep')]));
}
add_action('widgets_init', 'megasklep_widgets');

/* ============================================================
   WOOCOMMERCE SETUP
============================================================ */
// Remove default WooCommerce wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'megasklep_woo_wrapper_start', 10);
add_action('woocommerce_after_main_content',  'megasklep_woo_wrapper_end', 10);

function megasklep_woo_wrapper_start() { echo '<div class="ms-woo-main">'; }
function megasklep_woo_wrapper_end()   { echo '</div>'; }

// Products per row & per page
add_filter('loop_shop_columns', function() { return 4; });
add_filter('loop_shop_per_page', function() { return 24; });

// Remove default WooCommerce sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Product image columns
add_filter('woocommerce_product_thumbnails_columns', function() { return 4; });

// Breadcrumb defaults
add_filter('woocommerce_breadcrumb_defaults', function($args) {
    $args['delimiter'] = ' <span class="ms-breadcrumb-sep">/</span> ';
    $args['wrap_before'] = '<nav class="ms-breadcrumbs" aria-label="Breadcrumb">';
    $args['wrap_after']  = '</nav>';
    return $args;
});

// Mini cart fragment
add_filter('woocommerce_add_to_cart_fragments', 'megasklep_cart_fragments');
function megasklep_cart_fragments($fragments) {
    ob_start();
    ?>
    <span class="ms-cart-count" id="ms-cart-count"><?= WC()->cart->get_cart_contents_count() ?></span>
    <?php
    $fragments['#ms-cart-count'] = ob_get_clean();

    ob_start();
    megasklep_cart_drawer_html();
    $fragments['#ms-cart-drawer-inner'] = ob_get_clean();

    return $fragments;
}

function megasklep_cart_drawer_html() {
    $cart  = WC()->cart;
    $items = $cart->get_cart();
    $total = $cart->get_cart_total();
    $count = $cart->get_cart_contents_count();
    $free  = (float) get_option('megasklep_free_shipping', 299);
    $subtotal_raw = (float) $cart->get_subtotal();
    ?>
    <div id="ms-cart-drawer-inner">
        <?php if (empty($items)) : ?>
            <div class="ms-cart-drawer__empty">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <p class="ms-cart-drawer__empty-title"><?php _e('Koszyk jest pusty', 'megasklep'); ?></p>
                <p><?php _e('Dodaj produkty, aby kontynuować', 'megasklep'); ?></p>
                <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--primary"><?php _e('Przejdź do sklepu', 'megasklep'); ?></a>
            </div>
        <?php else : ?>
            <div class="ms-cart-drawer__items">
                <?php foreach ($items as $key => $item) :
                    $product = $item['data'];
                    $img_url = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail') ?: wc_placeholder_img_src();
                    $remove_url = wc_get_cart_remove_url($key);
                    ?>
                    <div class="ms-cart-drawer__item" data-key="<?= esc_attr($key) ?>">
                        <a href="<?= get_permalink($product->get_id()) ?>" class="ms-cart-drawer__item-img">
                            <img src="<?= esc_url($img_url) ?>" alt="<?= esc_attr($product->get_name()) ?>" width="72" height="72" loading="lazy">
                        </a>
                        <div class="ms-cart-drawer__item-info">
                            <div class="ms-cart-drawer__item-brand"><?= esc_html($product->get_attribute('pa_marka') ?: '') ?></div>
                            <a href="<?= get_permalink($product->get_id()) ?>" class="ms-cart-drawer__item-title"><?= esc_html($item['product_id'] ? get_the_title($item['product_id']) : $product->get_name()) ?></a>
                            <?php if (!empty($item['variation'])) : ?>
                                <div class="ms-cart-drawer__item-variant"><?= implode(', ', array_map(fn($k,$v) => ucfirst(str_replace(['attribute_pa_','attribute_'],'', $k)) . ': ' . $v, array_keys($item['variation']), $item['variation'])) ?></div>
                            <?php endif; ?>
                            <div class="ms-cart-drawer__item-row">
                                <span class="ms-cart-drawer__item-price"><?= wp_kses_post(WC()->cart->get_product_subtotal($product, $item['quantity'])) ?></span>
                                <div class="ms-qty-input ms-qty-input--sm">
                                    <button class="ms-qty-btn" data-cart-qty data-key="<?= esc_attr($key) ?>" data-delta="-1" aria-label="Zmniejsz"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg></button>
                                    <span class="ms-qty-num"><?= (int)$item['quantity'] ?></span>
                                    <button class="ms-qty-btn" data-cart-qty data-key="<?= esc_attr($key) ?>" data-delta="1" aria-label="Zwiększ"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></button>
                                </div>
                            </div>
                        </div>
                        <a href="<?= esc_url($remove_url) ?>" class="ms-cart-drawer__item-remove" data-cart-remove="<?= esc_attr($key) ?>" aria-label="Usuń">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="ms-cart-drawer__footer">
                <?php if ($subtotal_raw < $free) :
                    $left = $free - $subtotal_raw;
                    $pct  = min(100, round($subtotal_raw / $free * 100));
                ?>
                    <div class="ms-cart-drawer__shipping-notice">
                        <p class="ms-cart-drawer__shipping-text"><?php printf(__('Do darmowej dostawy: <strong>%s zł</strong>', 'megasklep'), number_format($left, 2, ',', ' ')); ?></p>
                        <div class="ms-progress-bar"><div class="ms-progress-bar__fill" style="width:<?= $pct ?>%"></div></div>
                    </div>
                <?php else : ?>
                    <p class="ms-cart-free-ship"><?php _e('✓ Masz darmową dostawę!', 'megasklep'); ?></p>
                <?php endif; ?>
                <div class="ms-cart-drawer__total-row">
                    <span><?php _e('Razem:', 'megasklep'); ?></span>
                    <span class="ms-cart-drawer__total"><?= wp_kses_post($total) ?></span>
                </div>
                <a href="<?= wc_get_checkout_url() ?>" class="ms-btn ms-btn--primary ms-btn--large ms-btn--full"><?php _e('Przejdź do kasy', 'megasklep'); ?> →</a>
                <a href="<?= wc_get_cart_url() ?>" class="ms-btn ms-btn--outline ms-btn--large ms-btn--full" style="margin-top:.5rem"><?php _e('Widok koszyka', 'megasklep'); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/* ============================================================
   AJAX — CART
============================================================ */
add_action('wp_ajax_megasklep_cart_qty',        'megasklep_ajax_cart_qty');
add_action('wp_ajax_nopriv_megasklep_cart_qty', 'megasklep_ajax_cart_qty');
function megasklep_ajax_cart_qty() {
    check_ajax_referer('megasklep_nonce', 'nonce');
    $key   = sanitize_text_field($_POST['cart_item_key'] ?? '');
    $qty   = max(0, (int)($_POST['quantity'] ?? 1));
    WC()->cart->set_quantity($key, $qty, true);
    WC()->cart->calculate_totals();
    wp_send_json_success(['count' => WC()->cart->get_cart_contents_count(), 'total' => strip_tags(WC()->cart->get_cart_total())]);
}

/* ============================================================
   WISHLIST (custom — localStorage fallback on front, DB if logged in)
============================================================ */
add_action('wp_ajax_megasklep_toggle_wishlist',        'megasklep_ajax_wishlist');
add_action('wp_ajax_nopriv_megasklep_toggle_wishlist', 'megasklep_ajax_wishlist');
function megasklep_ajax_wishlist() {
    check_ajax_referer('megasklep_nonce', 'nonce');
    $product_id = (int)($_POST['product_id'] ?? 0);
    if (!$product_id) wp_send_json_error();
    if (is_user_logged_in()) {
        $user_id  = get_current_user_id();
        $wishlist = get_user_meta($user_id, '_megasklep_wishlist', true) ?: [];
        $added    = !in_array($product_id, $wishlist);
        if ($added) { $wishlist[] = $product_id; }
        else        { $wishlist   = array_diff($wishlist, [$product_id]); }
        update_user_meta($user_id, '_megasklep_wishlist', array_values($wishlist));
        wp_send_json_success(['added' => $added, 'count' => count($wishlist)]);
    }
    // For guests — just acknowledge, JS handles localStorage
    wp_send_json_success(['added' => true]);
}

/* ============================================================
   THEME CUSTOMIZER
============================================================ */
add_action('customize_register', 'megasklep_customizer');
function megasklep_customizer($wp_customize) {
    $wp_customize->add_section('megasklep_general', ['title' => 'MegaSklep — Ogólne', 'priority' => 30]);

    $wp_customize->add_setting('megasklep_phone', ['default' => '800 123 456', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('megasklep_phone', ['label' => 'Telefon', 'section' => 'megasklep_general', 'type' => 'text']);

    $wp_customize->add_setting('megasklep_email', ['default' => 'kontakt@sklep.pl', 'sanitize_callback' => 'sanitize_email']);
    $wp_customize->add_control('megasklep_email', ['label' => 'E-mail', 'section' => 'megasklep_general', 'type' => 'email']);

    $wp_customize->add_setting('megasklep_free_shipping', ['default' => '299', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('megasklep_free_shipping', ['label' => 'Próg darmowej dostawy (PLN)', 'section' => 'megasklep_general', 'type' => 'number']);

    $wp_customize->add_setting('megasklep_tagline', ['default' => 'AGD · Elektronika · Meble', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('megasklep_tagline', ['label' => 'Podtytuł logo', 'section' => 'megasklep_general', 'type' => 'text']);

    $wp_customize->add_setting('megasklep_facebook', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('megasklep_facebook', ['label' => 'Facebook URL', 'section' => 'megasklep_general', 'type' => 'url']);

    $wp_customize->add_setting('megasklep_instagram', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('megasklep_instagram', ['label' => 'Instagram URL', 'section' => 'megasklep_general', 'type' => 'url']);

    $wp_customize->add_setting('megasklep_youtube', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('megasklep_youtube', ['label' => 'YouTube URL', 'section' => 'megasklep_general', 'type' => 'url']);
}

/* ============================================================
   HELPERS
============================================================ */
function megasklep_get_setting($key, $default = '') {
    return get_theme_mod($key, $default);
}

function megasklep_sale_badge($product) {
    if (!$product->is_on_sale()) return '';
    $reg  = (float)$product->get_regular_price();
    $sale = (float)$product->get_sale_price();
    $pct  = $reg > 0 ? round(($reg - $sale) / $reg * 100) : 0;
    return '<span class="ms-badge ms-badge--red">-' . $pct . '%</span>';
}

// Custom body classes
add_filter('body_class', function($classes) {
    if (is_shop() || is_product_category() || is_product_tag()) $classes[] = 'ms-is-shop';
    if (is_product()) $classes[] = 'ms-is-product';
    if (is_cart())    $classes[] = 'ms-is-cart';
    if (is_checkout())$classes[] = 'ms-is-checkout';
    return $classes;
});

// Include sub-files
require_once MEGASKLEP_DIR . '/inc/mega-menu.php';
require_once MEGASKLEP_DIR . '/inc/shortcodes.php';
