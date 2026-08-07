<?php
/**
 * Product card template part.
 * Requires $product global (WC_Product).
 */
if (!isset($product) || !$product) return;

$id           = $product->get_id();
$title        = $product->get_name();
$permalink    = get_permalink($id);
$price_html   = $product->get_price_html();
$on_sale      = $product->is_on_sale();
$is_available = $product->is_in_stock();
$img_id       = $product->get_image_id();
$img_url      = $img_id ? wp_get_attachment_image_url($img_id, 'woocommerce_thumbnail') : wc_placeholder_img_src('woocommerce_thumbnail');
$img_hover    = null;
$gallery_ids  = $product->get_gallery_image_ids();
if (!empty($gallery_ids)) {
    $img_hover = wp_get_attachment_image_url($gallery_ids[0], 'woocommerce_thumbnail');
}
$badge        = megasklep_sale_badge($product);
$is_new       = has_term('new', 'product_tag', $id) || has_term('nowość', 'product_tag', $id);
$is_best      = has_term('bestseller', 'product_tag', $id);
$vendor       = $product->get_attribute('pa_marka') ?: get_bloginfo('name');

// Rating
$rating      = $product->get_average_rating();
$review_count= $product->get_review_count();

// Variant id for add to cart
$variant_id  = ($product->get_type() === 'simple') ? $id : 0;
?>
<div class="ms-product-card" data-product-id="<?= $id ?>">
    <div class="ms-product-card__img-wrap">
        <a href="<?= esc_url($permalink) ?>" aria-label="<?= esc_attr($title) ?>">
            <img class="ms-product-card__img" src="<?= esc_url($img_url) ?>" alt="<?= esc_attr($title) ?>" loading="lazy" width="600" height="600">
            <?php if ($img_hover) : ?>
                <img class="ms-product-card__img ms-product-card__img--hover" src="<?= esc_url($img_hover) ?>" alt="<?= esc_attr($title) ?>" loading="lazy" width="600" height="600">
            <?php endif; ?>
        </a>

        <!-- Badges -->
        <div class="ms-product-card__badges">
            <?= $badge ?>
            <?php if ($is_new)  : ?><span class="ms-badge ms-badge--blue"><?php _e('Nowość', 'megasklep'); ?></span><?php endif; ?>
            <?php if ($is_best) : ?><span class="ms-badge ms-badge--green"><?php _e('Bestseller', 'megasklep'); ?></span><?php endif; ?>
        </div>

        <?php if (!$is_available) : ?>
            <div class="ms-product-card__sold-out"><span><?php _e('Niedostępny', 'megasklep'); ?></span></div>
        <?php endif; ?>

        <!-- Hover actions -->
        <div class="ms-product-card__overlay-actions">
            <button class="ms-overlay-btn ms-wishlist-btn" data-product-id="<?= $id ?>" aria-label="<?php _e('Dodaj do ulubionych', 'megasklep'); ?>">
                <?= megasklep_icon('heart', 16) ?>
            </button>
            <a href="<?= esc_url($permalink) ?>" class="ms-overlay-btn" aria-label="<?php _e('Szczegóły', 'megasklep'); ?>">
                <?= megasklep_icon('eye', 16) ?>
            </a>
        </div>
    </div>

    <div class="ms-product-card__body">
        <div class="ms-product-card__brand"><?= esc_html($vendor) ?></div>
        <a href="<?= esc_url($permalink) ?>" class="ms-product-card__title"><?= esc_html($title) ?></a>

        <?php if ($rating > 0) : ?>
            <div class="ms-product-card__rating">
                <div class="ms-stars ms-stars--sm">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="<?= $i <= round($rating) ? '#f59e0b' : '#e5e7eb' ?>" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <?php endfor; ?>
                </div>
                <span class="ms-product-card__review-count">(<?= $review_count ?>)</span>
            </div>
        <?php endif; ?>

        <div class="ms-product-card__price-row">
            <div class="ms-product-card__prices"><?= $price_html ?></div>
            <?php if ($is_available && $variant_id) : ?>
                <button class="ms-add-to-cart-btn" data-product-id="<?= $id ?>" data-variant-id="<?= $variant_id ?>"
                    data-nonce="<?= wp_create_nonce('add-to-cart') ?>" aria-label="<?php _e('Dodaj do koszyka', 'megasklep'); ?>">
                    <?= megasklep_icon('cart', 18) ?>
                </button>
            <?php else : ?>
                <a href="<?= esc_url($permalink) ?>" class="ms-add-to-cart-btn ms-add-to-cart-btn--link">
                    <?= megasklep_icon('eye', 18) ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
