<?php get_header(); ?>

<div id="page" class="ms-page">
<div id="content">
<main id="primary" class="ms-main">

<?php if (is_home() || is_front_page()) : ?>
    <?php get_template_part('template-parts/home'); ?>
<?php elseif (is_search()) : ?>
    <?php get_template_part('template-parts/search-results'); ?>
<?php elseif (have_posts()) : ?>
    <div class="ms-container ms-section">
        <div class="ms-posts-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article class="ms-post-card" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="ms-post-card__thumb">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    <?php endif; ?>
                    <div class="ms-post-card__body">
                        <div class="ms-post-card__meta"><?php the_date('d.m.Y') ?> · <?php the_author() ?></div>
                        <h2 class="ms-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="ms-post-card__excerpt"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="ms-btn ms-btn--outline ms-btn--sm"><?php _e('Czytaj więcej', 'megasklep'); ?> →</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(['mid_size' => 3, 'prev_text' => '← ' . __('Poprzednia', 'megasklep'), 'next_text' => __('Następna', 'megasklep') . ' →']); ?>
    </div>
<?php else : ?>
    <div class="ms-container ms-section"><div class="ms-empty-state"><h2><?php _e('Brak treści', 'megasklep'); ?></h2></div></div>
<?php endif; ?>

</main>
</div>
</div>

<?php get_footer(); ?>
