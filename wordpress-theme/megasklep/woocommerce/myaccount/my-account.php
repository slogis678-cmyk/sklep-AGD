<?php
/**
 * My account page.
 */
defined('ABSPATH') || exit;
get_header();
?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main ms-woo-page">
<div class="ms-container ms-section">

<?php woocommerce_breadcrumb(); ?>

<div class="ms-myaccount">
    <?php if (is_user_logged_in()) :
        $user = wp_get_current_user();
    ?>
        <div class="ms-myaccount__header">
            <?= get_avatar($user->ID, 80, '', $user->display_name, ['class' => 'ms-myaccount__avatar']) ?>
            <div>
                <h1 class="ms-myaccount__name"><?php printf(__('Witaj, %s!', 'megasklep'), $user->display_name); ?></h1>
                <p class="ms-myaccount__email"><?= esc_html($user->user_email) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="ms-myaccount__layout">
        <!-- Sidebar nav -->
        <nav class="ms-myaccount__nav">
            <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                <a href="<?= esc_url(wc_get_account_endpoint_url($endpoint)) ?>"
                    class="ms-myaccount__nav-link <?= is_wc_endpoint_url($endpoint) || (wc_get_account_menu_item_classes($endpoint) && strpos(wc_get_account_menu_item_classes($endpoint), 'is-active') !== false) ? 'is-active' : '' ?>">
                    <?= esc_html($label) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Content -->
        <div class="ms-myaccount__content">
            <?php woocommerce_output_all_notices(); ?>
            <?php do_action('woocommerce_account_content'); ?>
        </div>
    </div>
</div>

</div>
</main>
</div>

<?php get_footer(); ?>
