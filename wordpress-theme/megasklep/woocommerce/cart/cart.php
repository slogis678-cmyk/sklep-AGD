<?php
/**
 * Cart page template.
 */
defined('ABSPATH') || exit;
get_header();
?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main ms-woo-page">
<div class="ms-container ms-section">

<?php woocommerce_breadcrumb(); ?>
<h1 class="ms-cart-page__title">
    <?php _e('Koszyk', 'megasklep'); ?>
    <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
        <span class="ms-cart-page__count">(<?= WC()->cart->get_cart_contents_count() ?>)</span>
    <?php endif; ?>
</h1>

<?php if (WC()->cart->is_empty()) : ?>
    <div class="ms-empty-state">
        <?= megasklep_icon('cart', 64) ?>
        <h2><?php _e('Twój koszyk jest pusty', 'megasklep'); ?></h2>
        <p><?php _e('Dodaj produkty, aby kontynuować zakupy.', 'megasklep'); ?></p>
        <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--primary"><?php _e('Przejdź do sklepu', 'megasklep'); ?></a>
    </div>
<?php else : ?>
    <div class="ms-cart-page__layout">

        <!-- Items -->
        <div class="ms-cart-items">
            <form class="woocommerce-cart-form" action="<?= esc_url(wc_get_cart_url()) ?>" method="post">
                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                    $product  = $cart_item['data'];
                    $img_url  = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail') ?: wc_placeholder_img_src();
                    $vendor   = $product->get_attribute('pa_marka') ?: '';
                ?>
                    <div class="ms-cart-item">
                        <a href="<?= get_permalink($product->get_id()) ?>" class="ms-cart-item__img">
                            <img src="<?= esc_url($img_url) ?>" alt="<?= esc_attr($product->get_name()) ?>" width="88" height="88" loading="lazy">
                        </a>
                        <div class="ms-cart-item__info">
                            <?php if ($vendor) : ?><div class="ms-cart-item__vendor"><?= esc_html($vendor) ?></div><?php endif; ?>
                            <a href="<?= get_permalink($product->get_id()) ?>" class="ms-cart-item__title"><?= esc_html($product->get_name()) ?></a>
                            <?php if (!empty($cart_item['variation'])) :
                                foreach ($cart_item['variation'] as $key => $val) : ?>
                                    <div class="ms-cart-item__variant"><?= ucfirst(str_replace(['attribute_pa_','attribute_'],'', $key)) ?>: <?= esc_html($val) ?></div>
                            <?php endforeach; endif; ?>
                            <div class="ms-cart-item__controls">
                                <div class="ms-qty-input">
                                    <button type="button" class="ms-qty-btn" onclick="this.nextElementSibling.stepDown();this.nextElementSibling.dispatchEvent(new Event('change'))" aria-label="Zmniejsz"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg></button>
                                    <input type="number" class="ms-qty-num" name="cart[<?= esc_attr($cart_item_key) ?>][qty]" value="<?= $cart_item['quantity'] ?>" min="0" max="<?= $product->get_max_purchase_quantity() ?>" step="1" size="4">
                                    <button type="button" class="ms-qty-btn" onclick="this.previousElementSibling.stepUp();this.previousElementSibling.dispatchEvent(new Event('change'))" aria-label="Zwiększ"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></button>
                                </div>
                                <a href="<?= esc_url(wc_get_cart_remove_url($cart_item_key)) ?>" class="ms-cart-item__remove" aria-label="Usuń">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="ms-cart-item__price"><?= wp_kses_post(WC()->cart->get_product_subtotal($product, $cart_item['quantity'])) ?></div>
                    </div>
                <?php endforeach; ?>

                <!-- Coupon -->
                <div class="ms-cart-coupon">
                    <div class="ms-cart-coupon__wrap">
                        <input type="text" name="coupon_code" class="ms-search-input" placeholder="<?php _e('Kod rabatowy', 'megasklep'); ?>" value="<?= esc_attr(isset($_POST['coupon_code']) ? sanitize_text_field($_POST['coupon_code']) : '') ?>">
                        <button type="submit" name="apply_coupon" value="<?php _e('Zastosuj', 'megasklep'); ?>" class="ms-btn ms-btn--outline"><?php _e('Zastosuj', 'megasklep'); ?></button>
                    </div>
                    <button type="submit" name="update_cart" value="<?php _e('Aktualizuj koszyk', 'megasklep'); ?>" class="ms-btn ms-btn--outline ms-btn--sm">
                        <?php _e('Aktualizuj koszyk', 'megasklep'); ?>
                    </button>
                </div>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </form>

            <!-- Woocommerce notices -->
            <?php woocommerce_output_all_notices(); ?>
        </div>

        <!-- Summary -->
        <div class="ms-cart-summary">
            <h2 class="ms-cart-summary__title"><?php _e('Podsumowanie', 'megasklep'); ?></h2>
            <?php woocommerce_cart_totals(); ?>
            <?php
            $free = (float)get_option('megasklep_free_shipping', 299);
            $sub  = (float)WC()->cart->get_subtotal();
            if ($sub < $free) :
                $left = $free - $sub;
                $pct  = min(100, round($sub / $free * 100));
            ?>
                <div class="ms-cart-delivery-progress">
                    <p><?php printf(__('Do darmowej dostawy: <strong>%s zł</strong>', 'megasklep'), number_format($left, 2, ',', ' ')); ?></p>
                    <div class="ms-progress-bar"><div class="ms-progress-bar__fill" style="width:<?= $pct ?>%"></div></div>
                </div>
            <?php else : ?>
                <p class="ms-cart-free-ship"><?php _e('✓ Masz darmową dostawę!', 'megasklep'); ?></p>
            <?php endif; ?>
            <div class="ms-cart-payment-icons">
                <span class="ms-payment-badge">VISA</span>
                <span class="ms-payment-badge">MC</span>
                <span class="ms-payment-badge">BLIK</span>
                <span class="ms-payment-badge">P24</span>
                <span class="ms-payment-badge">PayPal</span>
            </div>
        </div>
    </div>
<?php endif; ?>

</div>
</main>
</div>

<?php get_footer(); ?>
