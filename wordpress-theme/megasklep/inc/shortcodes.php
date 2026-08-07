<?php
/**
 * Custom shortcodes.
 */
defined('ABSPATH') || exit;

// [ms_hero_banner heading="..." subheading="..." badge="..." link="..." btn="..."]
add_shortcode('ms_hero_banner', function($atts) {
    $a = shortcode_atts(['heading'=>'','subheading'=>'','badge'=>'','link'=>'#','btn'=>'Sprawdź ofertę','bg_color'=>'#1e3a8a'], $atts);
    ob_start(); ?>
    <section class="ms-hero-sc" style="background:<?= esc_attr($a['bg_color']) ?>">
        <div class="ms-container ms-hero-sc__inner">
            <?php if ($a['badge']) : ?><span class="ms-slide__badge"><?= esc_html($a['badge']) ?></span><?php endif; ?>
            <h2 class="ms-slide__heading"><?= esc_html($a['heading']) ?></h2>
            <p class="ms-slide__subheading"><?= esc_html($a['subheading']) ?></p>
            <a href="<?= esc_url($a['link']) ?>" class="ms-btn ms-btn--white"><?= esc_html($a['btn']) ?> →</a>
        </div>
    </section>
    <?php return ob_get_clean();
});

// [ms_features]
add_shortcode('ms_features', function() {
    $features = [
        ['icon' => 'truck',       'color' => 'blue',  'title' => 'Darmowa dostawa',      'desc' => 'Od 299 zł zamówienia'],
        ['icon' => 'rotate',      'color' => 'green', 'title' => 'Zwrot 30 dni',          'desc' => 'Bez podawania przyczyny'],
        ['icon' => 'credit-card', 'color' => 'amber', 'title' => 'Raty 0%',               'desc' => 'Nawet do 36 rat'],
        ['icon' => 'shield',      'color' => 'blue',  'title' => 'Oryginalne produkty',   'desc' => 'Gwarancja autentyczności'],
        ['icon' => 'headphones',  'color' => 'amber', 'title' => 'Wsparcie 24/7',         'desc' => 'Zawsze do dyspozycji'],
        ['icon' => 'star',        'color' => 'amber', 'title' => 'Program lojalnościowy', 'desc' => 'Zbieraj punkty'],
    ];
    ob_start(); ?>
    <section class="ms-features">
        <div class="ms-container">
            <div class="ms-features__grid">
                <?php foreach ($features as $f) : ?>
                    <div class="ms-feature-item">
                        <div class="ms-feature-item__icon ms-feature-item__icon--<?= $f['color'] ?>">
                            <?= megasklep_icon($f['icon'], 22) ?>
                        </div>
                        <div class="ms-feature-item__text">
                            <strong><?= esc_html($f['title']) ?></strong>
                            <span><?= esc_html($f['desc']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php return ob_get_clean();
});

/* Icon helper */
function megasklep_icon($name, $size = 20) {
    $icons = [
        'truck'       => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
        'rotate'      => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>',
        'credit-card' => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
        'shield'      => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'headphones'  => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"/><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>',
        'star'        => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'cart'        => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
        'heart'       => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'search'      => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        'user'        => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'menu'        => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
        'close'       => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'chevron-down'=> '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>',
        'arrow-right' => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'phone'       => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.5 19.79 19.79 0 0 1 1.57 4a2 2 0 0 1 1.95-2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.27a16 16 0 0 0 6.29 6.29l.87-.87a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'map-pin'     => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        'mail'        => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'eye'         => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
        'check'       => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>',
    ];
    return $icons[$name] ?? '';
}
