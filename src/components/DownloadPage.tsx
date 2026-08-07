import { Download, CheckCircle, Package, FileCode, Paintbrush, ShoppingCart, Globe } from 'lucide-react';

interface ThemeCardProps {
  platform: string;
  icon: React.ReactNode;
  color: string;
  filename: string;
  features: string[];
  instructions: string;
}

function ThemeCard({ platform, icon, color, filename, features, instructions }: ThemeCardProps) {
  return (
    <div className="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden flex flex-col">
      <div className={`${color} p-6 flex items-center gap-3`}>
        <div className="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-white">
          {icon}
        </div>
        <div>
          <p className="text-white/70 text-xs font-semibold uppercase tracking-wider">Motyw</p>
          <h2 className="text-white font-bold text-xl" style={{ fontFamily: 'Sora, sans-serif' }}>
            {platform}
          </h2>
        </div>
      </div>

      <div className="p-6 flex flex-col flex-1">
        <ul className="space-y-2.5 mb-6 flex-1">
          {features.map((f) => (
            <li key={f} className="flex items-start gap-2.5 text-sm text-gray-700">
              <CheckCircle size={16} className="text-emerald-500 shrink-0 mt-0.5" />
              {f}
            </li>
          ))}
        </ul>

        <a
          href={`/${filename}`}
          download={filename}
          className="inline-flex items-center justify-center gap-2 bg-gray-900 hover:bg-gray-800 text-white font-semibold px-6 py-3.5 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md active:scale-95 text-sm mb-4"
        >
          <Download size={18} />
          Pobierz plik ZIP
        </a>

        <p className="text-xs text-gray-400 text-center">{instructions}</p>
      </div>
    </div>
  );
}

export default function DownloadPage() {
  const themes = [
    {
      platform: 'WordPress + WooCommerce',
      icon: <Globe size={24} />,
      color: 'bg-gradient-to-br from-blue-600 to-blue-800',
      filename: 'megasklep-wordpress-theme.zip',
      features: [
        'functions.php, header, footer, page, single, 404',
        'WooCommerce: sklep, produkt, koszyk, kasa, konto',
        'Szuflada koszyka AJAX + fragmenty WC',
        'Slideshow, licznik, banner kategorii',
        'Filtry produktów, sortowanie, paginacja',
        'Lista życzeń (localStorage + baza danych)',
        'Konfigurowalny przez Customizer WordPress',
        'Gotowe shortcody + 20+ ikon SVG',
        'Responsywny, mobile-first',
        'Polskie tłumaczenia (text domain)',
      ],
      instructions: 'WordPress Admin → Wygląd → Motywy → Prześlij motyw → Aktywuj',
    },
    {
      platform: 'Shopify (Online Store 2.0)',
      icon: <ShoppingCart size={24} />,
      color: 'bg-gradient-to-br from-emerald-600 to-emerald-800',
      filename: 'megasklep-shopify-theme.zip',
      features: [
        '26 plików Liquid — layout, sekcje, snippety',
        'Szuflada koszyka AJAX z paskiem dostawy',
        'Slideshow z edytorem sekcji',
        'Karty kategorii i pasek korzyści',
        'Licznik oferty dnia',
        'Pełna strona produktu z galeria i wariantami',
        'Kolekcja z filtrami i sortowaniem',
        'Strony: koszyk, checkout redirect, konto, 404',
        'Newsletter, stopka z social media',
        'Ustawienia w edytorze Shopify (Settings Schema)',
      ],
      instructions: 'Shopify Admin → Sklep online → Motywy → Dodaj motyw → Wgraj plik ZIP',
    },
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-4xl mx-auto px-4 py-16">
        <div className="text-center mb-12">
          <div className="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
            <Package size={32} className="text-blue-600" />
          </div>
          <h1 className="text-3xl font-bold text-gray-900 mb-2" style={{ fontFamily: 'Sora, sans-serif' }}>
            MegaSklep — Motywy e-commerce
          </h1>
          <p className="text-gray-500">
            Kompletne, produkcyjne motywy gotowe do wgrania na Twoją platformę.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {themes.map((t) => (
            <ThemeCard key={t.platform} {...t} />
          ))}
        </div>

        <div className="mt-12 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <h3 className="font-bold text-gray-900 mb-3 flex items-center gap-2">
            <FileCode size={18} className="text-blue-600" />
            Co zawiera motyw WordPress + WooCommerce?
          </h3>
          <div className="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm text-gray-600">
            {[
              'functions.php', 'header.php + footer.php', 'front-page.php + index.php',
              'single.php + page.php', 'search.php + 404.php', 'archive-product.php',
              'single-product.php', 'cart/cart.php', 'checkout/form-checkout.php',
              'checkout/thankyou.php', 'myaccount/my-account.php', 'template-parts/home.php',
              'template-parts/product/card.php', 'inc/mega-menu.php', 'inc/shortcodes.php',
              'assets/css/megasklep.css (~1700 linii)', 'assets/js/megasklep.js (~500 linii)', 'README.md',
            ].map((f) => (
              <div key={f} className="flex items-center gap-1.5 text-xs">
                <Paintbrush size={11} className="text-gray-400 shrink-0" />
                {f}
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
