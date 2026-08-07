<?php
/**
 * Thankyou page.
 */
defined('ABSPATH') || exit;
get_header();

$order = wc_get_order($order_id ?? 0);
?>

<div id="page" class="ms-page">
<main id="primary" class="ms-main ms-woo-page">
<div class="ms-container ms-section">

<?php if ($order) : ?>
    <div class="ms-thankyou">
        <div class="ms-thankyou__icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h1 class="ms-thankyou__title"><?php _e('Dziękujemy za zamówienie!', 'megasklep'); ?></h1>
        <p class="ms-thankyou__sub"><?php _e('Potwierdzenie zostało wysłane na Twój adres e-mail.', 'megasklep'); ?></p>

        <div class="ms-thankyou__details">
            <div class="ms-thankyou__detail-item">
                <span><?php _e('Numer zamówienia:', 'megasklep'); ?></span>
                <strong>#<?= $order->get_order_number() ?></strong>
            </div>
            <div class="ms-thankyou__detail-item">
                <span><?php _e('Data:', 'megasklep'); ?></span>
                <strong><?= wc_format_datetime($order->get_date_created()) ?></strong>
            </div>
            <div class="ms-thankyou__detail-item">
                <span><?php _e('E-mail:', 'megasklep'); ?></span>
                <strong><?= esc_html($order->get_billing_email()) ?></strong>
            </div>
            <div class="ms-thankyou__detail-item">
                <span><?php _e('Łącznie:', 'megasklep'); ?></span>
                <strong><?= wp_kses_post($order->get_formatted_order_total()) ?></strong>
            </div>
        </div>

        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

        <div class="ms-thankyou__actions">
            <a href="<?= wc_get_account_endpoint_url('orders') ?>" class="ms-btn ms-btn--outline"><?php _e('Moje zamówienia', 'megasklep'); ?></a>
            <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="ms-btn ms-btn--primary"><?php _e('Kontynuuj zakupy', 'megasklep'); ?></a>
        </div>
    </div>
<?php else : ?>
    <div class="ms-thankyou">
        <h1><?php _e('Dziękujemy za zamówienie!', 'megasklep'); ?></h1>
        <p><?php _e('Twoje zamówienie zostało złożone pomyślnie.', 'megasklep'); ?></p>
        <a href="<?= home_url('/') ?>" class="ms-btn ms-btn--primary"><?php _e('Wróć do sklepu', 'megasklep'); ?></a>
    </div>
<?php endif; ?>

</div>
</main>
</div>

<?php get_footer(); ?>
