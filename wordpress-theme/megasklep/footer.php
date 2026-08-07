    </main><!-- #main -->
</div><!-- #page -->

<!-- ===== NEWSLETTER ===== -->
<section class="ms-newsletter">
    <div class="ms-container">
        <div class="ms-newsletter__inner">
            <div class="ms-newsletter__text">
                <h2 class="ms-newsletter__heading"><?php _e('Zapisz się do newslettera', 'megasklep'); ?></h2>
                <p class="ms-newsletter__sub"><?php _e('Otrzymuj najnowsze oferty i promocje jako pierwszy.', 'megasklep'); ?></p>
            </div>
            <?php if (function_exists('mc4wp_show_form')) :
                mc4wp_show_form();
            else : ?>
            <form class="ms-newsletter__form" id="ms-newsletter-form">
                <div class="ms-newsletter__input-wrap">
                    <input type="email" name="ms_email" required placeholder="<?php _e('Twój adres e-mail', 'megasklep'); ?>" class="ms-newsletter__input" aria-label="E-mail">
                    <button type="submit" class="ms-btn ms-btn--primary"><?php _e('Zapisz się', 'megasklep'); ?></button>
                </div>
                <p class="ms-newsletter__legal">
                    <?php _e('Zapisując się, akceptujesz', 'megasklep'); ?>
                    <a href="<?= esc_url(get_privacy_policy_url()) ?>"><?php _e('politykę prywatności', 'megasklep'); ?></a>.
                </p>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="ms-footer" role="contentinfo">
    <div class="ms-container">
        <div class="ms-footer__grid">

            <!-- Brand -->
            <div class="ms-footer__brand">
                <a href="<?= home_url('/') ?>" class="ms-header__logo ms-footer__logo" aria-label="<?php bloginfo('name'); ?>">
                    <?php if (has_custom_logo()) : the_custom_logo(); else : ?>
                        <div class="ms-logo-icon"><?= strtoupper(substr(get_bloginfo('name'), 0, 1)) ?></div>
                        <div class="ms-logo-text">
                            <span class="ms-logo-name"><?php bloginfo('name'); ?></span>
                            <span class="ms-logo-tagline"><?= esc_html(megasklep_get_setting('megasklep_tagline', 'AGD · Elektronika · Meble')) ?></span>
                        </div>
                    <?php endif; ?>
                </a>
                <p class="ms-footer__desc"><?php bloginfo('description'); ?></p>
                <div class="ms-footer__contact">
                    <?php $phone = megasklep_get_setting('megasklep_phone'); if ($phone) : ?>
                        <div><?= megasklep_icon('phone', 14) ?> <?= esc_html($phone) ?></div>
                    <?php endif; $email = megasklep_get_setting('megasklep_email'); if ($email) : ?>
                        <div><?= megasklep_icon('mail', 14) ?> <a href="mailto:<?= esc_attr($email) ?>"><?= esc_html($email) ?></a></div>
                    <?php endif; ?>
                </div>
                <div class="ms-footer__social">
                    <?php $fb = megasklep_get_setting('megasklep_facebook'); if ($fb) : ?><a href="<?= esc_url($fb) ?>" class="ms-social-btn" target="_blank" rel="noopener" aria-label="Facebook"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a><?php endif; ?>
                    <?php $ig = megasklep_get_setting('megasklep_instagram'); if ($ig) : ?><a href="<?= esc_url($ig) ?>" class="ms-social-btn" target="_blank" rel="noopener" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a><?php endif; ?>
                    <?php $yt = megasklep_get_setting('megasklep_youtube'); if ($yt) : ?><a href="<?= esc_url($yt) ?>" class="ms-social-btn" target="_blank" rel="noopener" aria-label="YouTube"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.4a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg></a><?php endif; ?>
                </div>
            </div>

            <!-- Footer menus -->
            <?php for ($i = 1; $i <= 3; $i++) :
                $labels = ['', __('Sklep', 'megasklep'), __('Pomoc', 'megasklep'), __('Firma', 'megasklep')]; ?>
                <div class="ms-footer__links">
                    <h4 class="ms-footer__links-title"><?= $labels[$i] ?></h4>
                    <?php wp_nav_menu(['theme_location' => 'footer-'.$i, 'menu_class' => '', 'container' => 'ul',
                        'fallback_cb' => function() { echo '<ul><li><a href="#">Link</a></li></ul>'; }]); ?>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Bottom bar -->
        <div class="ms-footer__bottom">
            <p class="ms-footer__copy">&copy; <?= date('Y') ?> <?php bloginfo('name'); ?>. <?php _e('Wszelkie prawa zastrzeżone.', 'megasklep'); ?></p>
            <div class="ms-footer__legal">
                <?php wp_nav_menu(['menu' => 'Footer Legal', 'container' => false, 'fallback_cb' => function() {
                    echo '<a href="/polityka-prywatnosci">' . __('Polityka prywatności', 'megasklep') . '</a>';
                    echo '<a href="/regulamin">' . __('Regulamin', 'megasklep') . '</a>';
                    echo '<a href="/cookies">Cookies</a>';
                }]); ?>
            </div>
            <div class="ms-footer__payments">
                <span><?php _e('Przyjmujemy:', 'megasklep'); ?></span>
                <span class="ms-payment-badge">VISA</span>
                <span class="ms-payment-badge">MC</span>
                <span class="ms-payment-badge">BLIK</span>
                <span class="ms-payment-badge">P24</span>
                <span class="ms-payment-badge">PayPal</span>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
