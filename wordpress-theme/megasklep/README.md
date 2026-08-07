# MegaSklep — Motyw WordPress + WooCommerce

Profesjonalny motyw e-commerce dla WordPress z pełną obsługą WooCommerce.

## Wymagania

- WordPress 6.0+
- PHP 8.0+
- WooCommerce 7.0+

## Instalacja

1. Wejdź w **WordPress Admin → Wygląd → Motywy → Dodaj nowy**
2. Kliknij **Prześlij motyw** i wybierz plik `megasklep-wordpress-theme.zip`
3. Aktywuj motyw

## Konfiguracja WooCommerce

Po aktywacji motywu przejdź przez kreator WooCommerce:

1. **WooCommerce → Ustawienia** — waluta, kraj, podatki
2. **WooCommerce → Produkty** — dodaj kategorie i produkty
3. **WooCommerce → Dostawy** — skonfiguruj metody dostawy
4. **WooCommerce → Płatności** — aktywuj metody płatności (Przelewy24, BLIK, PayPal)

## Konfiguracja motywu

### Wygląd → Dostosuj → MegaSklep — Ogólne
- Telefon kontaktowy
- Adres e-mail
- Próg darmowej dostawy (PLN)
- Linki do social media (Facebook, Instagram, YouTube)

### Wygląd → Menu
Utwórz następujące menu i przypisz do lokalizacji:
- **Menu główne** → „Menu główne (primary)"
- **Stopka — Sklep** → „Stopka — Sklep (footer-1)"
- **Stopka — Pomoc** → „Stopka — Pomoc (footer-2)"
- **Stopka — Firma** → „Stopka — Firma (footer-3)"

### Wygląd → Widżety
- **Stopka — kolumna 1/2/3** — opcjonalne widżety w stopce

## Kategorie WooCommerce
Aby wyświetlić karty kategorii na stronie głównej:
1. **Produkty → Kategorie** — dodaj kategorie (np. `agd`, `elektronika`, `meble`)
2. Dla każdej kategorii ustaw **miniaturkę kategorii**

## Struktura plików

```
megasklep/
├── functions.php          # Główny plik motywu
├── style.css              # Identyfikacja motywu
├── header.php             # Nagłówek + koszyk szufladowy
├── footer.php             # Stopka + newsletter
├── index.php              # Główny szablon
├── front-page.php         # Strona główna
├── single.php             # Pojedynczy post
├── page.php               # Strona statyczna
├── search.php             # Wyniki wyszukiwania
├── 404.php                # Błąd 404
├── inc/
│   ├── mega-menu.php      # Walker menu
│   └── shortcodes.php     # Shortcody + funkcja ikon
├── assets/
│   ├── css/megasklep.css  # Główny arkusz stylów
│   └── js/megasklep.js    # Główny JavaScript
├── template-parts/
│   ├── home.php           # Sekcje strony głównej
│   └── product/card.php   # Karta produktu
└── woocommerce/
    ├── archive-product.php    # Lista produktów (sklep, kategorie)
    ├── single-product.php     # Strona produktu
    ├── cart/cart.php          # Koszyk
    ├── checkout/
    │   ├── form-checkout.php  # Kasa
    │   └── thankyou.php       # Podziękowanie
    └── myaccount/
        └── my-account.php     # Moje konto
```

## Shortcody

```
[ms_hero_banner heading="..." subheading="..." badge="..." link="/shop" btn="Sprawdź" bg_color="#1e3a8a"]
[ms_features]
```

## Dostosowanie kolorów

Kolory główne w `assets/css/megasklep.css`:
- `#2563eb` — kolor główny (niebieski)
- `#1d4ed8` — hover
- `#dc2626` — promocje (czerwony)
- `#059669` — sukces (zielony)

## Wsparcie dla płatności

Motyw kompatybilny z:
- WooCommerce Payments
- Przelewy24
- PayU
- BLIK (przez PayU/P24)
- PayPal
- Stripe

## Changelog

### 1.0.0
- Pierwsza wersja
- Pełna obsługa WooCommerce
- Koszyk AJAX (szuflada)
- Slideshow na stronie głównej
- Responsywny design
- Obsługa liste życzeń
- Polskie tłumaczenia
