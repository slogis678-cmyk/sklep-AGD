<?php
/**
 * Home page template part.
 */

// Hero categories query
$agd_cat   = get_term_by('slug', 'agd', 'product_cat');
$elec_cat  = get_term_by('slug', 'elektronika', 'product_cat');
$meble_cat = get_term_by('slug', 'meble', 'product_cat');
?>

<!-- ===== HERO SLIDESHOW ===== -->
<section class="ms-hero" aria-label="Baner główny">
    <div class="ms-container">
        <div class="ms-slideshow" data-autoplay="true" data-speed="5">
            <div class="ms-slide is-active">
                <div class="ms-slide__placeholder" style="background:linear-gradient(135deg,#1e3a8a,#1d4ed8)"></div>
                <div class="ms-slide__overlay" style="background:linear-gradient(to right,#1e3a8acc,#1d4ed899)"></div>
                <div class="ms-slide__content">
                    <span class="ms-slide__badge">Do -30%</span>
                    <h2 class="ms-slide__heading"><?php _e('Letnia Wyprzedaż AGD', 'megasklep'); ?></h2>
                    <p class="ms-slide__subheading"><?php _e('Oszczędź do 30% na sprzętach AGD — ograniczone ilości!', 'megasklep'); ?></p>
                    <a href="<?= $agd_cat ? get_term_link($agd_cat) : get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--white ms-slide__btn">
                        <?php _e('Sprawdź ofertę', 'megasklep'); ?> <?= megasklep_icon('arrow-right', 18) ?>
                    </a>
                </div>
            </div>
            <div class="ms-slide">
                <div class="ms-slide__placeholder" style="background:linear-gradient(135deg,#0f172a,#1e293b)"></div>
                <div class="ms-slide__overlay" style="background:linear-gradient(to right,#0f172acc,#1e293b99)"></div>
                <div class="ms-slide__content">
                    <span class="ms-slide__badge">Nowości 2025</span>
                    <h2 class="ms-slide__heading"><?php _e('Nowa Elektronika 2025', 'megasklep'); ?></h2>
                    <p class="ms-slide__subheading"><?php _e('Najnowsze laptopy, smartfony i telewizory', 'megasklep'); ?></p>
                    <a href="<?= $elec_cat ? get_term_link($elec_cat) : get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--white ms-slide__btn">
                        <?php _e('Zobacz nowości', 'megasklep'); ?> <?= megasklep_icon('arrow-right', 18) ?>
                    </a>
                </div>
            </div>
            <div class="ms-slide">
                <div class="ms-slide__placeholder" style="background:linear-gradient(135deg,#064e3b,#059669)"></div>
                <div class="ms-slide__overlay" style="background:linear-gradient(to right,#064e3bcc,#05996999)"></div>
                <div class="ms-slide__content">
                    <span class="ms-slide__badge">Dostawa 48h</span>
                    <h2 class="ms-slide__heading"><?php _e('Urządź Dom z Klasą', 'megasklep'); ?></h2>
                    <p class="ms-slide__subheading"><?php _e('Meble skandynawskie z dostawą w 48h', 'megasklep'); ?></p>
                    <a href="<?= $meble_cat ? get_term_link($meble_cat) : get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--white ms-slide__btn">
                        <?php _e('Wybierz meble', 'megasklep'); ?> <?= megasklep_icon('arrow-right', 18) ?>
                    </a>
                </div>
            </div>

            <button class="ms-slideshow__arrow ms-slideshow__arrow--prev" aria-label="Poprzedni"><?= megasklep_icon('arrow-right', 20) ?></button>
            <button class="ms-slideshow__arrow ms-slideshow__arrow--next" aria-label="Następny"><?= megasklep_icon('arrow-right', 20) ?></button>
            <div class="ms-slideshow__dots">
                <button class="ms-slideshow__dot is-active" data-index="0"></button>
                <button class="ms-slideshow__dot" data-index="1"></button>
                <button class="ms-slideshow__dot" data-index="2"></button>
            </div>
        </div>
    </div>
</section>

<!-- ===== FEATURES BAR ===== -->
<?= do_shortcode('[ms_features]'); ?>

<!-- ===== CATEGORY CARDS ===== -->
<?php
$cats = get_terms(['taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'number' => 3]);
if (!empty($cats) && !is_wp_error($cats)) : ?>
<section class="ms-section">
    <div class="ms-container">
        <div class="ms-section__header">
            <div>
                <h2 class="ms-section__title"><?php _e('Kategorie', 'megasklep'); ?></h2>
                <p class="ms-section__subtitle"><?php _e('Przeglądaj naszą ofertę', 'megasklep'); ?></p>
            </div>
        </div>
        <div class="ms-categories-grid">
            <?php foreach ($cats as $cat) :
                $thumb_id  = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $img_url   = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : '';
                $count     = $cat->count;
                $children  = get_terms(['taxonomy' => 'product_cat', 'parent' => $cat->term_id, 'hide_empty' => true, 'number' => 4]);
            ?>
            <a href="<?= get_term_link($cat) ?>" class="ms-category-card">
                <div class="ms-category-card__img">
                    <?php if ($img_url) : ?>
                        <img src="<?= esc_url($img_url) ?>" alt="<?= esc_attr($cat->name) ?>" loading="lazy">
                    <?php else : ?>
                        <div class="ms-category-card__placeholder" style="background:linear-gradient(135deg,#1e3a8a,#3b82f6)"></div>
                    <?php endif; ?>
                    <div class="ms-category-card__overlay"></div>
                </div>
                <div class="ms-category-card__content">
                    <div class="ms-category-card__count"><?= number_format($count) ?> produktów</div>
                    <div class="ms-category-card__footer">
                        <h3 class="ms-category-card__title"><?= esc_html($cat->name) ?></h3>
                        <div class="ms-category-card__arrow"><?= megasklep_icon('arrow-right', 18) ?></div>
                    </div>
                    <?php if (!empty($children) && !is_wp_error($children)) : ?>
                        <div class="ms-category-card__tags">
                            <?php foreach ($children as $child) : ?>
                                <span class="ms-tag"><?= esc_html($child->name) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== PROMO TIMER ===== -->
<section class="ms-promo-timer">
    <div class="ms-container">
        <div class="ms-promo-timer__inner">
            <div class="ms-promo-timer__left">
                <div class="ms-promo-timer__icon"><?= megasklep_icon('check', 28) ?></div>
                <div>
                    <p class="ms-promo-timer__label"><?php _e('Oferta dnia kończy się za:', 'megasklep'); ?></p>
                    <h3 class="ms-promo-timer__heading"><?php _e('Błyskawiczna Promocja', 'megasklep'); ?></h3>
                </div>
            </div>
            <div class="ms-countdown" id="ms-countdown">
                <div class="ms-countdown__block"><span class="ms-countdown__num" id="ms-cd-h">05</span><span class="ms-countdown__unit">godzin</span></div>
                <span class="ms-countdown__sep">:</span>
                <div class="ms-countdown__block"><span class="ms-countdown__num" id="ms-cd-m">42</span><span class="ms-countdown__unit">minut</span></div>
                <span class="ms-countdown__sep">:</span>
                <div class="ms-countdown__block"><span class="ms-countdown__num" id="ms-cd-s">17</span><span class="ms-countdown__unit">sekund</span></div>
            </div>
            <div class="ms-promo-timer__right">
                <p class="ms-promo-timer__save"><?php _e('Oszczędź do', 'megasklep'); ?> <strong>40%</strong></p>
                <a href="<?= get_permalink(wc_get_page_id('shop')) ?>?orderby=price" class="ms-btn ms-btn--white">
                    <?php _e('Sprawdź oferty', 'megasklep'); ?> <?= megasklep_icon('arrow-right', 16) ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== FEATURED PRODUCTS ===== -->
<?php
$featured = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'tax_query'      => [['taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured']],
    'post_status'    => 'publish',
]);
if (!$featured->have_posts()) {
    $featured = new WP_Query(['post_type' => 'product', 'posts_per_page' => 8, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC']);
}
?>
<section class="ms-section">
    <div class="ms-container">
        <div class="ms-section__header">
            <div>
                <h2 class="ms-section__title"><?php _e('Polecane produkty', 'megasklep'); ?></h2>
                <p class="ms-section__subtitle"><?php _e('Wybrane przez naszych ekspertów', 'megasklep'); ?></p>
            </div>
            <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--outline ms-btn--sm">
                <?php _e('Zobacz wszystkie', 'megasklep'); ?> <?= megasklep_icon('arrow-right', 14) ?>
            </a>
        </div>
        <div class="ms-product-grid">
            <?php while ($featured->have_posts()) : $featured->the_post();
                global $product;
                $product = wc_get_product(get_the_ID());
                get_template_part('template-parts/product/card');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<!-- ===== BESTSELLERS ===== -->
<?php
$bestsellers = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'meta_key'       => 'total_sales',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'post_status'    => 'publish',
]);
if ($bestsellers->have_posts()) : ?>
<section class="ms-section" style="padding-top:0">
    <div class="ms-container">
        <div class="ms-section__header">
            <div>
                <h2 class="ms-section__title"><?php _e('Bestsellery', 'megasklep'); ?></h2>
            </div>
            <a href="<?= get_permalink(wc_get_page_id('shop')) ?>?orderby=popularity" class="ms-btn ms-btn--outline ms-btn--sm">
                <?php _e('Zobacz wszystkie', 'megasklep'); ?> →
            </a>
        </div>
        <div class="ms-product-grid">
            <?php while ($bestsellers->have_posts()) : $bestsellers->the_post();
                global $product;
                $product = wc_get_product(get_the_ID());
                get_template_part('template-parts/product/card');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
