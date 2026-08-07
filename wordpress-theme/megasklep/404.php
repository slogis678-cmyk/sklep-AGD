<?php get_header(); ?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main">
<div class="ms-container ms-section">
    <div class="ms-empty-state">
        <div style="font-size:8rem;font-weight:800;color:#e5e7eb;font-family:'Sora',sans-serif;line-height:1">404</div>
        <h1><?php _e('Strona nie została znaleziona', 'megasklep'); ?></h1>
        <p><?php _e('Strona, której szukasz, mogła zostać przeniesiona lub nie istnieje.', 'megasklep'); ?></p>
        <a href="<?= home_url('/') ?>" class="ms-btn ms-btn--primary"><?php _e('Wróć do strony głównej', 'megasklep'); ?></a>
    </div>
</div>
</main>
</div>

<?php get_footer(); ?>
