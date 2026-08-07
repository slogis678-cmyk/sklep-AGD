import { Facebook, Instagram, Youtube, Twitter, Mail, Phone, MapPin, ChevronRight } from 'lucide-react';

const links = {
  'Sklep': ['AGD', 'Elektronika', 'Meble', 'Outlet', 'Nowości', 'Bestsellery'],
  'Pomoc': ['FAQ', 'Dostawa i odbiór', 'Zwroty', 'Gwarancja', 'Serwis', 'Kontakt'],
  'Firma': ['O nas', 'Praca', 'Blog', 'Partnerzy', 'Prasa', 'CSR'],
};

export default function Footer() {
  return (
    <footer className="bg-gray-950 text-white mt-16">
      {/* Newsletter */}
      <div className="border-b border-gray-800">
        <div className="max-w-7xl mx-auto px-4 py-10">
          <div className="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
              <h3 className="text-xl font-bold mb-1">Zapisz się do newslettera</h3>
              <p className="text-gray-400 text-sm">Otrzymuj najnowsze oferty i promocje jako pierwszy.</p>
            </div>
            <form className="flex gap-2 w-full max-w-sm" onSubmit={e => e.preventDefault()}>
              <input
                type="email"
                placeholder="Twój adres email"
                className="flex-1 bg-gray-800 text-white placeholder-gray-500 border border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 transition-colors"
              />
              <button type="submit" className="btn-primary py-2.5 px-5 text-sm rounded-xl whitespace-nowrap">
                Zapisz się
              </button>
            </form>
          </div>
        </div>
      </div>

      {/* Main */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
          {/* Brand */}
          <div className="lg:col-span-2">
            <div className="flex items-center gap-2 mb-4">
              <div className="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                <span className="text-white font-bold text-xl" style={{ fontFamily: 'Sora, sans-serif' }}>M</span>
              </div>
              <div>
                <div className="font-bold text-lg" style={{ fontFamily: 'Sora, sans-serif' }}>MegaSklep</div>
                <div className="text-blue-400 text-[10px] font-semibold tracking-widest uppercase">AGD · Elektronika · Meble</div>
              </div>
            </div>
            <p className="text-gray-400 text-sm leading-relaxed mb-5 max-w-sm">
              Twój zaufany sklep internetowy z AGD, elektroniką i meblami. Ponad 4500 produktów, 
              darmowa dostawa od 299 zł i zwrot w ciągu 30 dni.
            </p>
            <div className="space-y-2 text-sm text-gray-400">
              <div className="flex items-center gap-2"><Phone size={14} className="text-blue-400" /> 800 123 456 (bezpłatna)</div>
              <div className="flex items-center gap-2"><Mail size={14} className="text-blue-400" /> kontakt@megasklep.pl</div>
              <div className="flex items-center gap-2"><MapPin size={14} className="text-blue-400" /> ul. Handlowa 15, 00-001 Warszawa</div>
            </div>
            <div className="flex gap-3 mt-5">
              {[Facebook, Instagram, Youtube, Twitter].map((Icon, i) => (
                <button key={i} className="w-9 h-9 bg-gray-800 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-colors duration-200">
                  <Icon size={16} className="text-gray-400 hover:text-white" />
                </button>
              ))}
            </div>
          </div>

          {/* Links */}
          {Object.entries(links).map(([title, items]) => (
            <div key={title}>
              <h4 className="font-semibold text-white mb-4">{title}</h4>
              <ul className="space-y-2">
                {items.map(item => (
                  <li key={item}>
                    <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-1 group">
                      <ChevronRight size={12} className="opacity-0 group-hover:opacity-100 transition-opacity text-blue-400" />
                      {item}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>

      {/* Bottom */}
      <div className="border-t border-gray-800">
        <div className="max-w-7xl mx-auto px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p className="text-gray-500 text-xs">© 2025 MegaSklep Sp. z o.o. Wszelkie prawa zastrzeżone.</p>
          <div className="flex items-center gap-4 text-xs text-gray-500">
            <a href="#" className="hover:text-white transition-colors">Polityka prywatności</a>
            <a href="#" className="hover:text-white transition-colors">Regulamin</a>
            <a href="#" className="hover:text-white transition-colors">Cookies</a>
          </div>
          <div className="flex items-center gap-2 text-gray-500 text-xs">
            <span>Przyjmujemy:</span>
            <span className="bg-gray-800 px-2 py-0.5 rounded text-xs">VISA</span>
            <span className="bg-gray-800 px-2 py-0.5 rounded text-xs">MC</span>
            <span className="bg-gray-800 px-2 py-0.5 rounded text-xs">BLIK</span>
            <span className="bg-gray-800 px-2 py-0.5 rounded text-xs">P24</span>
          </div>
        </div>
      </div>
    </footer>
  );
}
