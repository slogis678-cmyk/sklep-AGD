<?php get_header(); ?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main">
<div class="ms-container ms-section">

<?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('ms-page-article'); ?>>
        <h1 class="ms-page-article__title"><?php the_title(); ?></h1>
        <div class="ms-page-article__content rte">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>

</div>
</main>
</div>

<?php get_footer(); ?>
