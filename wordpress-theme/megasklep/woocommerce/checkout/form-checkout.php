<?php
/**
 * Checkout page template.
 */
defined('ABSPATH') || exit;
get_header();

if (!is_user_logged_in()) {
    woocommerce_output_all_notices();
}
?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main ms-woo-page">
<div class="ms-container ms-section">

<?php woocommerce_breadcrumb(); ?>

<h1 class="ms-checkout-title"><?php _e('Finalizacja zamówienia', 'megasklep'); ?></h1>

<?php woocommerce_output_all_notices(); ?>

<?php if (WC()->cart->is_empty()) : ?>
    <div class="ms-empty-state">
        <h2><?php _e('Twój koszyk jest pusty', 'megasklep'); ?></h2>
        <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--primary"><?php _e('Wróć do sklepu', 'megasklep'); ?></a>
    </div>
<?php else : ?>

<?php do_action('woocommerce_before_checkout_form', $checkout); ?>

<form name="checkout" method="post" class="ms-checkout-form woocommerce-checkout" action="<?= esc_url(wc_get_checkout_url()) ?>" enctype="multipart/form-data">

    <div class="ms-checkout-layout">

        <!-- LEFT: Fields -->
        <div class="ms-checkout-fields">

            <!-- Login notice -->
            <?php if (!is_user_logged_in() && 'yes' === get_option('woocommerce_enable_checkout_login_reminder')) : ?>
                <div class="ms-checkout-notice ms-checkout-notice--info">
                    <?php _e('Masz już konto?', 'megasklep'); ?>
                    <a href="#" class="ms-checkout-login-toggle"><?php _e('Zaloguj się', 'megasklep'); ?></a>
                </div>
            <?php endif; ?>

            <!-- Billing -->
            <div class="ms-checkout-section">
                <h2 class="ms-checkout-section__title"><?php _e('Dane do faktury / dostawy', 'megasklep'); ?></h2>
                <?php do_action('woocommerce_checkout_billing'); ?>
            </div>

            <!-- Ship to different address -->
            <?php if (WC()->cart->needs_shipping()) : ?>
                <div class="ms-checkout-section ms-checkout-ship">
                    <label class="ms-checkbox-label ms-checkout-ship__toggle" style="font-weight:600;font-size:.9rem">
                        <input id="ship-to-different-address-checkbox" class="input-checkbox ms-checkbox" type="checkbox" name="ship_to_different_address" value="1" <?php checked(WC()->checkout()->get_value('ship_to_different_address'), true); ?>>
                        <span><?php _e('Dostarcz pod inny adres?', 'megasklep'); ?></span>
                    </label>
                    <div class="ms-checkout-ship__fields">
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Order notes -->
            <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>
                <div class="ms-checkout-section">
                    <h3><?php _e('Dodatkowe informacje', 'megasklep'); ?></h3>
                    <textarea class="ms-checkout-textarea" name="order_comments" placeholder="<?php _e('Uwagi do zamówienia (opcjonalnie)', 'megasklep'); ?>" rows="4"></textarea>
                </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Order summary -->
        <div class="ms-checkout-summary">
            <h2 class="ms-checkout-section__title"><?php _e('Twoje zamówienie', 'megasklep'); ?></h2>

            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="ms-order-review woocommerce-checkout-review-order">
                <div class="ms-order-review__items">
                    <?php foreach (WC()->cart->get_cart() as $key => $item) :
                        $prod     = $item['data'];
                        $img_url  = wp_get_attachment_image_url($prod->get_image_id(), 'thumbnail') ?: wc_placeholder_img_src();
                    ?>
                        <div class="ms-order-review__item">
                            <div class="ms-order-review__item-img">
                                <img src="<?= esc_url($img_url) ?>" alt="<?= esc_attr($prod->get_name()) ?>" width="56" height="56" loading="lazy">
                                <span class="ms-order-review__qty"><?= $item['quantity'] ?></span>
                            </div>
                            <div class="ms-order-review__item-info">
                                <p><?= esc_html($prod->get_name()) ?></p>
                            </div>
                            <div class="ms-order-review__item-price"><?= wp_kses_post(WC()->cart->get_product_subtotal($prod, $item['quantity'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="ms-order-review__totals">
                    <div class="ms-cart-summary__row"><span><?php _e('Produkty:', 'megasklep'); ?></span><span><?= WC()->cart->get_cart_subtotal() ?></span></div>
                    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                        <div class="ms-cart-summary__row ms-cart-summary__row--discount">
                            <span><?php printf(__('Kupon: %s', 'megasklep'), esc_html($code)); ?></span>
                            <span>-<?= WC()->cart->get_coupon_discount_amount($code, WC()->cart->display_prices_including_tax()) ?> zł</span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (WC()->cart->needs_shipping()) : ?>
                        <div class="ms-cart-summary__row"><span><?php _e('Dostawa:', 'megasklep'); ?></span><span><?= WC()->cart->get_cart_shipping_total() ?></span></div>
                    <?php endif; ?>
                    <div class="ms-cart-summary__total"><span><?php _e('Łącznie:', 'megasklep'); ?></span><span><?= WC()->cart->get_total() ?></span></div>
                </div>

                <!-- Shipping methods -->
                <?php if (WC()->cart->needs_shipping()) : ?>
                    <div class="ms-checkout-shipping-methods">
                        <h3><?php _e('Metoda dostawy', 'megasklep'); ?></h3>
                        <?php woocommerce_checkout_shipping(); ?>
                    </div>
                <?php endif; ?>

                <!-- Payment methods -->
                <div class="ms-checkout-payment">
                    <h3><?php _e('Płatność', 'megasklep'); ?></h3>
                    <?php do_action('woocommerce_checkout_payment'); ?>
                </div>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>
        </div>
    </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

<?php endif; ?>
</div>
</main>
</div>

<?php get_footer(); ?>
