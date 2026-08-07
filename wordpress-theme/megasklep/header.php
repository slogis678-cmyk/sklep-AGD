<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
    <script>document.documentElement.className=document.documentElement.className.replace('no-js','js');</script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="ms-skip-link"><?php _e('Przejdź do treści', 'megasklep'); ?></a>

<!-- ===== ANNOUNCEMENT BAR ===== -->
<div class="ms-announcement-bar">
    <div class="ms-container ms-announcement-bar__inner">
        <div class="ms-announcement-bar__left">
            <span><?= megasklep_icon('phone', 12) ?> <?= esc_html(megasklep_get_setting('megasklep_phone', '800 123 456')) ?> <em>(bezpłatna)</em></span>
            <span><?= megasklep_icon('map-pin', 12) ?> <?php _e('Salony w całej Polsce', 'megasklep'); ?></span>
        </div>
        <div class="ms-announcement-bar__right">
            <span><?php _e('Darmowa dostawa od 299 zł', 'megasklep'); ?></span>
            <span><?php _e('Zwrot 30 dni', 'megasklep'); ?></span>
            <span><?php _e('Raty 0%', 'megasklep'); ?></span>
        </div>
    </div>
</div>

<!-- ===== HEADER ===== -->
<header class="ms-header" id="ms-header">
    <div class="ms-container">
        <div class="ms-header__inner">

            <!-- Logo -->
            <a href="<?= home_url('/') ?>" class="ms-header__logo" aria-label="<?php bloginfo('name'); ?>">
                <?php if (has_custom_logo()) :
                    the_custom_logo();
                else : ?>
                    <div class="ms-logo-icon"><?= strtoupper(substr(get_bloginfo('name'), 0, 1)) ?></div>
                    <div class="ms-logo-text">
                        <span class="ms-logo-name"><?php bloginfo('name'); ?></span>
                        <span class="ms-logo-tagline"><?= esc_html(megasklep_get_setting('megasklep_tagline', 'AGD · Elektronika · Meble')) ?></span>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Search -->
            <form role="search" method="get" action="<?= esc_url(home_url('/')) ?>" class="ms-header__search">
                <div class="ms-search-wrap">
                    <input type="search" class="ms-search-input" placeholder="<?php _e('Szukaj produktów, marek, kategorii...', 'megasklep'); ?>"
                        value="<?= get_search_query() ?>" name="s" aria-label="<?php _e('Szukaj', 'megasklep'); ?>">
                    <input type="hidden" name="post_type" value="product">
                    <button type="submit" class="ms-search-btn" aria-label="<?php _e('Szukaj', 'megasklep'); ?>"><?= megasklep_icon('search', 16) ?></button>
                </div>
            </form>

            <!-- Actions -->
            <div class="ms-header__actions">
                <a href="<?= esc_url(home_url('/?s=&post_type=product')) ?>" class="ms-icon-btn ms-header__search-mobile" aria-label="<?php _e('Szukaj', 'megasklep'); ?>"><?= megasklep_icon('search', 22) ?></a>

                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?= esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) ?>" class="ms-icon-btn ms-header__account" aria-label="<?php _e('Konto', 'megasklep'); ?>"><?= megasklep_icon('user', 22) ?></a>

                    <button class="ms-icon-btn ms-cart-trigger" aria-label="<?php _e('Koszyk', 'megasklep'); ?>" id="ms-cart-trigger">
                        <?= megasklep_icon('cart', 22) ?>
                        <span id="ms-cart-count" class="ms-cart-count <?= WC()->cart->is_empty() ? 'ms-hidden' : '' ?>">
                            <?= WC()->cart->get_cart_contents_count() ?>
                        </span>
                    </button>
                <?php endif; ?>

                <button class="ms-icon-btn ms-hamburger" aria-label="<?php _e('Menu', 'megasklep'); ?>" id="ms-hamburger"><?= megasklep_icon('menu', 22) ?></button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="ms-header__nav" id="ms-nav" aria-label="<?php _e('Menu główne', 'megasklep'); ?>">
        <div class="ms-container">
            <div class="ms-nav__inner">
                <?php wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'ms-nav__list',
                    'container'      => false,
                    'walker'         => new Megasklep_Walker_Nav_Menu(),
                    'fallback_cb'    => function() {
                        echo '<ul class="ms-nav__list"><li class="ms-nav__item"><a href="' . get_permalink(wc_get_page_id('shop')) . '" class="ms-nav__link">Sklep</a></li></ul>';
                    },
                ]); ?>
                <div class="ms-nav__extras">
                    <?php $sale_page = get_page_by_path('promocje'); ?>
                    <a href="<?= $sale_page ? get_permalink($sale_page) : get_permalink(wc_get_page_id('shop')) . '?orderby=price' ?>" class="ms-nav__promo">🔥 <?php _e('Promocje', 'megasklep'); ?></a>
                    <a href="<?= get_permalink(wc_get_page_id('shop')) ?>"><?php _e('Raty 0%', 'megasklep'); ?></a>
                    <a href="<?= get_permalink(wc_get_page_id('shop')) ?>?orderby=popularity"><?php _e('Bestsellery', 'megasklep'); ?></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu -->
    <div class="ms-mobile-menu" id="ms-mobile-menu" aria-hidden="true">
        <div class="ms-mobile-menu__header">
            <span><?php _e('Menu', 'megasklep'); ?></span>
            <button class="ms-icon-btn" id="ms-menu-close" aria-label="<?php _e('Zamknij menu', 'megasklep'); ?>"><?= megasklep_icon('close', 22) ?></button>
        </div>
        <div class="ms-mobile-menu__search">
            <form role="search" method="get" action="<?= esc_url(home_url('/')) ?>">
                <input type="hidden" name="post_type" value="product">
                <div class="ms-search-wrap">
                    <input type="search" name="s" class="ms-search-input" placeholder="<?php _e('Szukaj produktów...', 'megasklep'); ?>" value="<?= get_search_query() ?>">
                    <button type="submit" class="ms-search-btn" aria-label="Szukaj"><?= megasklep_icon('search', 14) ?></button>
                </div>
            </form>
        </div>
        <?php wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'ms-mobile-menu__list',
            'container'      => false,
        ]); ?>
    </div>
</header>

<!-- ===== CART DRAWER ===== -->
<?php if (class_exists('WooCommerce')) : ?>
<div id="ms-cart-drawer" class="ms-cart-drawer" aria-hidden="true" role="dialog" aria-label="<?php _e('Koszyk', 'megasklep'); ?>">
    <div class="ms-cart-drawer__header">
        <div class="ms-cart-drawer__title">
            <?= megasklep_icon('cart', 22) ?>
            <span><?php _e('Koszyk', 'megasklep'); ?></span>
        </div>
        <button class="ms-icon-btn" id="ms-cart-close" aria-label="<?php _e('Zamknij koszyk', 'megasklep'); ?>"><?= megasklep_icon('close', 20) ?></button>
    </div>
    <div class="ms-cart-drawer__body">
        <?php megasklep_cart_drawer_html(); ?>
    </div>
</div>
<div id="ms-overlay" class="ms-overlay" aria-hidden="true"></div>
<?php endif; ?>

<div id="ms-toast" class="ms-toast" role="status" aria-live="polite"></div>

<div id="main-content"></div>
