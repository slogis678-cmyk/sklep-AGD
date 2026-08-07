<?php get_header(); ?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main">
<div class="ms-container ms-section">

<h1 class="ms-search-title">
    <?php if (have_posts()) :
        printf(__('Wyniki dla: „%s"', 'megasklep'), esc_html(get_search_query()));
    else :
        printf(__('Brak wyników dla: „%s"', 'megasklep'), esc_html(get_search_query()));
    endif; ?>
</h1>

<div class="ms-search-page__form">
    <div class="ms-search-wrap ms-search-wrap--lg">
        <form role="search" method="get" action="<?= esc_url(home_url('/')) ?>">
            <input type="hidden" name="post_type" value="product">
            <input type="search" name="s" value="<?= get_search_query() ?>" class="ms-search-input" placeholder="Szukaj produktów...">
            <button type="submit" class="ms-search-btn" aria-label="Szukaj"><?= megasklep_icon('search', 18) ?></button>
        </form>
    </div>
</div>

<?php if (have_posts()) : ?>
    <div class="ms-product-grid">
        <?php while (have_posts()) : the_post();
            global $product;
            if (get_post_type() === 'product') {
                $product = wc_get_product(get_the_ID());
                get_template_part('template-parts/product/card');
            }
        endwhile; ?>
    </div>
    <div class="ms-pagination"><?php the_posts_pagination(); ?></div>
<?php else : ?>
    <div class="ms-empty-state">
        <?= megasklep_icon('search', 48) ?>
        <p>Spróbuj innego zapytania lub przeglądaj <a href="<?= get_permalink(wc_get_page_id('shop')) ?>">wszystkie produkty</a>.</p>
    </div>
<?php endif; ?>

</div>
</main>
</div>

<?php get_footer(); ?>
