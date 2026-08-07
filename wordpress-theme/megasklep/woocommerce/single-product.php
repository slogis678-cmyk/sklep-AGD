<?php
/**
 * Single product template.
 */
defined('ABSPATH') || exit;
get_header();

while (have_posts()) : the_post();
    global $product;
    $product = wc_get_product(get_the_ID());

    $id            = $product->get_id();
    $title         = $product->get_name();
    $price_html    = $product->get_price_html();
    $description   = $product->get_description();
    $short_desc    = $product->get_short_description();
    $sku           = $product->get_sku();
    $stock         = $product->get_stock_status();
    $is_available  = $product->is_in_stock();
    $categories    = get_the_terms($id, 'product_cat');
    $tags          = get_the_terms($id, 'product_tag');
    $vendor        = $product->get_attribute('pa_marka') ?: '';
    $rating        = $product->get_average_rating();
    $review_count  = $product->get_review_count();
    $is_sale       = $product->is_on_sale();
    $badge         = megasklep_sale_badge($product);
    $img_id        = $product->get_image_id();
    $gallery_ids   = $product->get_gallery_image_ids();
    $all_imgs      = $img_id ? array_merge([$img_id], $gallery_ids) : $gallery_ids;

    $reg_price  = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main ms-woo-page">
<div class="ms-container ms-section">

    <?php woocommerce_breadcrumb(); ?>

    <div class="ms-product-page__inner">

        <!-- ===== GALLERY ===== -->
        <div class="ms-product-gallery">
            <div class="ms-product-gallery__main" id="ms-gallery-main">
                <?php if (!empty($all_imgs)) :
                    $main_img = wp_get_attachment_image_url($all_imgs[0], 'woocommerce_single');
                ?>
                    <img id="ms-gallery-img" src="<?= esc_url($main_img) ?>" alt="<?= esc_attr($title) ?>" loading="eager" width="800" height="800">
                <?php else : ?>
                    <?= wc_placeholder_img('woocommerce_single') ?>
                <?php endif; ?>
            </div>
            <?php if (count($all_imgs) > 1) : ?>
                <div class="ms-product-gallery__thumbs">
                    <?php foreach ($all_imgs as $i => $img_id_t) :
                        $thumb_url = wp_get_attachment_image_url($img_id_t, 'woocommerce_thumbnail');
                        $full_url  = wp_get_attachment_image_url($img_id_t, 'woocommerce_single');
                        $alt       = get_post_meta($img_id_t, '_wp_attachment_image_alt', true) ?: $title;
                    ?>
                        <button class="ms-gallery-thumb <?= $i === 0 ? 'is-active' : '' ?>"
                            data-src="<?= esc_url($full_url) ?>" data-alt="<?= esc_attr($alt) ?>" aria-label="Zdjęcie <?= $i + 1 ?>">
                            <img src="<?= esc_url($thumb_url) ?>" alt="<?= esc_attr($alt) ?>" loading="lazy" width="120" height="120">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ===== INFO ===== -->
        <div class="ms-product-info">
            <?php if ($vendor) : ?>
                <div class="ms-product-info__brand"><?= esc_html($vendor) ?></div>
            <?php endif; ?>

            <h1 class="ms-product-info__title"><?= esc_html($title) ?></h1>

            <!-- Rating -->
            <?php if ($rating > 0) : ?>
                <div class="ms-product-info__rating">
                    <div class="ms-stars">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="<?= $i <= round($rating) ? '#f59e0b' : '#e5e7eb' ?>" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <?php endfor; ?>
                    </div>
                    <a href="#ms-reviews" class="ms-product-info__reviews"><?= $review_count ?> <?php _e('opinii', 'megasklep'); ?></a>
                    <?php if ($sku) : ?>
                        <span style="color:#9ca3af;font-size:.75rem">SKU: <?= esc_html($sku) ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Price -->
            <div class="ms-product-info__price-wrap">
                <?php if ($is_sale && $reg_price) : ?>
                    <span class="ms-price ms-price--sale"><?= wc_price($sale_price) ?></span>
                    <span class="ms-price ms-price--compare"><?= wc_price($reg_price) ?></span>
                    <?= $badge ?>
                <?php else : ?>
                    <span class="ms-price"><?= $price_html ?></span>
                <?php endif; ?>
            </div>

            <!-- Short description -->
            <?php if ($short_desc) : ?>
                <div class="ms-product-info__short-desc rte"><?= wp_kses_post($short_desc) ?></div>
            <?php endif; ?>

            <!-- Add to cart form -->
            <?php woocommerce_template_single_add_to_cart(); ?>

            <!-- USPs -->
            <div class="ms-product-usps">
                <div class="ms-product-usp"><?= megasklep_icon('truck', 16) ?> <?php _e('Darmowa dostawa od 299 zł', 'megasklep'); ?></div>
                <div class="ms-product-usp"><?= megasklep_icon('rotate', 16) ?> <?php _e('Zwrot w ciągu 30 dni', 'megasklep'); ?></div>
                <div class="ms-product-usp"><?= megasklep_icon('credit-card', 16) ?> <?php _e('Raty 0% — nawet 36 rat', 'megasklep'); ?></div>
                <div class="ms-product-usp"><?= megasklep_icon('shield', 16) ?> <?php _e('Gwarancja producenta', 'megasklep'); ?></div>
            </div>

            <!-- Meta -->
            <div class="ms-product-meta">
                <?php if ($categories) : ?>
                    <div class="ms-product-meta__row">
                        <span><?php _e('Kategoria:', 'megasklep'); ?></span>
                        <?php foreach ($categories as $cat) : ?>
                            <a href="<?= get_term_link($cat) ?>"><?= esc_html($cat->name) ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="ms-product-meta__row">
                    <span><?php _e('Dostępność:', 'megasklep'); ?></span>
                    <span class="<?= $is_available ? 'ms-stock--yes' : 'ms-stock--no' ?>">
                        <?= $is_available ? __('Dostępny', 'megasklep') : __('Niedostępny', 'megasklep') ?>
                    </span>
                </div>
            </div>

            <!-- Social share -->
            <div class="ms-product-share">
                <span><?php _e('Udostępnij:', 'megasklep'); ?></span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(get_permalink()) ?>" target="_blank" rel="noopener" class="ms-social-btn" aria-label="Facebook">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== TABS ===== -->
    <div class="ms-product-tabs" id="ms-product-tabs">
        <div class="ms-tabs">
            <?php $active_tabs = []; ?>
            <?php if ($description) : $active_tabs[] = 'description'; ?>
                <button class="ms-tab-btn is-active" data-tab="ms-tab-desc"><?php _e('Opis', 'megasklep'); ?></button>
            <?php endif; ?>
            <?php
            $attrs = $product->get_attributes();
            if (!empty($attrs)) : $active_tabs[] = 'attributes'; ?>
                <button class="ms-tab-btn <?= empty($active_tabs) || reset($active_tabs) !== 'attributes' ? '' : 'is-active' ?>" data-tab="ms-tab-attrs"><?php _e('Specyfikacja', 'megasklep'); ?></button>
            <?php endif; ?>
            <?php if (comments_open()) : ?>
                <button class="ms-tab-btn" data-tab="ms-tab-reviews"><?php _e('Opinie', 'megasklep'); ?> (<?= $review_count ?>)</button>
            <?php endif; ?>
        </div>

        <div class="ms-tab-content">
            <?php if ($description) : ?>
                <div id="ms-tab-desc" class="ms-tab-panel is-active rte">
                    <?= wp_kses_post($description) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($attrs)) : ?>
                <div id="ms-tab-attrs" class="ms-tab-panel">
                    <table class="ms-specs-table">
                        <tbody>
                            <?php foreach ($attrs as $attr) :
                                $label  = wc_attribute_label($attr->get_name());
                                $values = $attr->is_taxonomy()
                                    ? array_map(fn($t) => $t->name, (array)get_the_terms($id, $attr->get_name()))
                                    : explode(' | ', $attr->get_options()[0] ?? '');
                            ?>
                                <tr>
                                    <th><?= esc_html($label) ?></th>
                                    <td><?= esc_html(implode(', ', array_filter($values))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (comments_open()) : ?>
                <div id="ms-tab-reviews" class="ms-tab-panel" id="ms-reviews">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== RELATED PRODUCTS ===== -->
    <?php
    $related_ids = wc_get_related_products($id, 4);
    if (!empty($related_ids)) :
        $related_products = array_map('wc_get_product', $related_ids);
    ?>
        <section class="ms-section" style="padding-top:0">
            <div class="ms-section__header">
                <h2 class="ms-section__title"><?php _e('Podobne produkty', 'megasklep'); ?></h2>
            </div>
            <div class="ms-product-grid">
                <?php foreach ($related_products as $product) :
                    if (!$product) continue;
                    get_template_part('template-parts/product/card');
                endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</div>
</main>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
