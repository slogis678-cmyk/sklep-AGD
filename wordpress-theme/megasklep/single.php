<?php get_header(); ?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main">
<div class="ms-container ms-section">

<?php while (have_posts()) : the_post(); ?>

    <nav class="ms-breadcrumbs">
        <a href="<?= home_url('/') ?>">Strona główna</a>
        <span>/</span>
        <a href="<?= get_permalink(get_option('page_for_posts')) ?>">Blog</a>
        <span>/</span>
        <span aria-current="page"><?php the_title(); ?></span>
    </nav>

    <article id="post-<?php the_ID(); ?>" <?php post_class('ms-single-post'); ?>>
        <header class="ms-single-post__header">
            <div class="ms-single-post__meta"><?php the_time('d.m.Y') ?> &middot; <?php the_author() ?></div>
            <h1 class="ms-single-post__title"><?php the_title(); ?></h1>
            <?php if (has_post_thumbnail()) : ?>
                <div class="ms-single-post__thumb"><?php the_post_thumbnail('large'); ?></div>
            <?php endif; ?>
        </header>
        <div class="ms-single-post__content rte"><?php the_content(); ?></div>
    </article>

<?php endwhile; ?>

</div>
</main>
</div>

<?php get_footer(); ?>
