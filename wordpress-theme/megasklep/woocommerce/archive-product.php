<?php
/**
 * WooCommerce archive (shop, category, tag).
 */
defined('ABSPATH') || exit;
get_header();
?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main ms-woo-page">
<div class="ms-container ms-section">

    <!-- Breadcrumbs -->
    <?php woocommerce_breadcrumb(); ?>

    <!-- Category image & description -->
    <?php if (is_product_category()) :
        $cat        = get_queried_object();
        $thumb_id   = get_term_meta($cat->term_id, 'thumbnail_id', true);
        $thumb_url  = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : '';
    ?>
        <div class="ms-archive-hero" <?= $thumb_url ? 'style="background-image:url(' . esc_url($thumb_url) . ')"' : '' ?>>
            <div class="ms-archive-hero__overlay"></div>
            <div class="ms-archive-hero__content">
                <h1><?= esc_html($cat->name) ?></h1>
                <?php if ($cat->description) : ?><p><?= esc_html($cat->description) ?></p><?php endif; ?>
            </div>
        </div>
    <?php elseif (is_shop()) : ?>
        <div class="ms-archive-shop-header">
            <h1 class="ms-section__title"><?php woocommerce_page_title(); ?></h1>
        </div>
    <?php endif; ?>

    <div class="ms-collection-layout">

        <!-- ===== SIDEBAR / FILTERS ===== -->
        <aside class="ms-filters ms-woo-filters" id="ms-filters">
            <div class="ms-filters__header">
                <h2><?php _e('Filtry', 'megasklep'); ?></h2>
                <button class="ms-icon-btn ms-filters__close" id="ms-filters-close" aria-label="Zamknij">
                    <?= megasklep_icon('close', 18) ?>
                </button>
            </div>

            <!-- Price filter -->
            <?php
            $min_price = (float)(isset($_GET['min_price']) ? $_GET['min_price'] : 0);
            $max_price = (float)(isset($_GET['max_price']) ? $_GET['max_price'] : 99999);
            ?>
            <div class="ms-filter-group">
                <button class="ms-filter-group__toggle"><?php _e('Cena', 'megasklep'); ?> <?= megasklep_icon('chevron-down', 14) ?></button>
                <div class="ms-filter-group__body">
                    <form method="get" class="ms-price-filter-form">
                        <?php foreach ($_GET as $key => $val) :
                            if (!in_array($key, ['min_price','max_price','paged'])) : ?>
                                <input type="hidden" name="<?= esc_attr($key) ?>" value="<?= esc_attr($val) ?>">
                        <?php endif; endforeach; ?>
                        <div class="ms-price-filter__inputs">
                            <div><label><?php _e('Od', 'megasklep'); ?></label><input type="number" name="min_price" class="ms-price-input" value="<?= $min_price ?: '' ?>" placeholder="0" min="0"></div>
                            <div><label><?php _e('Do', 'megasklep'); ?></label><input type="number" name="max_price" class="ms-price-input" value="<?= $max_price < 99999 ? $max_price : '' ?>" placeholder="9999" min="0"></div>
                        </div>
                        <button type="submit" class="ms-btn ms-btn--primary ms-btn--sm" style="width:100%;margin-top:.75rem"><?php _e('Zastosuj', 'megasklep'); ?></button>
                    </form>
                </div>
            </div>

            <!-- Category filter -->
            <div class="ms-filter-group">
                <button class="ms-filter-group__toggle"><?php _e('Kategorie', 'megasklep'); ?> <?= megasklep_icon('chevron-down', 14) ?></button>
                <div class="ms-filter-group__body">
                    <?php
                    $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0]);
                    if (!empty($terms) && !is_wp_error($terms)) : ?>
                        <ul class="ms-filter-list">
                            <?php foreach ($terms as $term) :
                                $active = is_product_category($term->slug);
                            ?>
                                <li>
                                    <a href="<?= get_term_link($term) ?>" class="ms-checkbox-label <?= $active ? 'is-active' : '' ?>">
                                        <span><?= esc_html($term->name) ?></span>
                                        <span class="ms-filter-count">(<?= $term->count ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Attribute filters -->
            <?php
            $attributes = wc_get_attribute_taxonomies();
            foreach ($attributes as $attr) :
                $tax = 'pa_' . $attr->attribute_name;
                $terms = get_terms(['taxonomy' => $tax, 'hide_empty' => true]);
                if (empty($terms) || is_wp_error($terms)) continue;
            ?>
                <div class="ms-filter-group">
                    <button class="ms-filter-group__toggle"><?= esc_html($attr->attribute_label) ?> <?= megasklep_icon('chevron-down', 14) ?></button>
                    <div class="ms-filter-group__body">
                        <ul class="ms-filter-list">
                            <?php foreach ($terms as $term) :
                                $active = isset($_GET['filter_' . $attr->attribute_name]) && in_array($term->slug, explode(',', $_GET['filter_' . $attr->attribute_name]));
                            ?>
                                <li>
                                    <label class="ms-checkbox-label <?= $active ? 'is-active' : '' ?>">
                                        <input type="checkbox" class="ms-checkbox ms-attr-filter" data-attr="<?= esc_attr($attr->attribute_name) ?>" value="<?= esc_attr($term->slug) ?>" <?= $active ? 'checked' : '' ?>>
                                        <span><?= esc_html($term->name) ?></span>
                                        <span class="ms-filter-count">(<?= $term->count ?>)</span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- On sale filter -->
            <div class="ms-filter-group">
                <label class="ms-checkbox-label" style="padding:.75rem 0;font-weight:600">
                    <input type="checkbox" class="ms-checkbox ms-sale-filter" <?= isset($_GET['on_sale']) ? 'checked' : '' ?>>
                    <span><?php _e('Tylko promocje', 'megasklep'); ?></span>
                </label>
            </div>

            <?php if (!empty($_GET)) : ?>
                <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--outline ms-btn--sm" style="width:100%;justify-content:center;margin-top:.5rem">
                    <?php _e('Wyczyść filtry', 'megasklep'); ?>
                </a>
            <?php endif; ?>
        </aside>

        <!-- ===== PRODUCTS ===== -->
        <div class="ms-collection-products">
            <!-- Toolbar -->
            <div class="ms-collection-page__header">
                <div>
                    <span class="ms-collection-page__count">
                        <?php
                        global $wp_query;
                        printf(_n('%s produkt', '%s produktów', $wp_query->found_posts, 'megasklep'), number_format_i18n($wp_query->found_posts));
                        ?>
                    </span>
                </div>
                <div style="display:flex;gap:.75rem;align-items:center">
                    <button class="ms-btn ms-btn--outline ms-btn--sm ms-filters-toggle" id="ms-filters-toggle" aria-label="Filtry">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                        <?php _e('Filtry', 'megasklep'); ?>
                    </button>
                    <div class="ms-sort-wrap">
                        <label for="ms-sort" class="ms-sort-label"><?php _e('Sortuj:', 'megasklep'); ?></label>
                        <div class="ms-select-wrap">
                            <?php woocommerce_catalog_ordering(); ?>
                            <?= megasklep_icon('chevron-down', 14) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (woocommerce_product_loop()) : ?>
                <div class="ms-product-grid">
                    <?php while (have_posts()) : the_post();
                        global $product;
                        $product = wc_get_product(get_the_ID());
                        get_template_part('template-parts/product/card');
                    endwhile; ?>
                </div>

                <div class="ms-pagination">
                    <?php
                    woocommerce_pagination();
                    ?>
                </div>
            <?php else : ?>
                <div class="ms-empty-state">
                    <?= megasklep_icon('search', 48) ?>
                    <h2><?php _e('Brak produktów', 'megasklep'); ?></h2>
                    <p><?php _e('Spróbuj innych filtrów.', 'megasklep'); ?></p>
                    <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--primary"><?php _e('Pokaż wszystkie', 'megasklep'); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</main>
</div>

<?php get_footer(); ?>
