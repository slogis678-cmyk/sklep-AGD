import { useState, useEffect } from 'react';
import { Search, ShoppingCart, User, Heart, Menu, X, ChevronDown, Phone, MapPin } from 'lucide-react';
import { categories } from '@/data/products';

interface HeaderProps {
  cartCount: number;
  wishlistCount: number;
  onCartOpen: () => void;
  onSearch: (q: string) => void;
  activeCategory: string | null;
  onCategoryChange: (cat: string | null) => void;
}

export default function Header({ cartCount, wishlistCount, onCartOpen, onSearch, activeCategory, onCategoryChange }: HeaderProps) {
  const [scrolled, setScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const [searchValue, setSearchValue] = useState('');
  const [searchFocused, setSearchFocused] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 10);
    window.addEventListener('scroll', onScroll);
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    onSearch(searchValue);
  };

  return (
    <>
      {/* Top bar */}
      <div className="bg-blue-700 text-white text-xs py-1.5 hidden md:block">
        <div className="max-w-7xl mx-auto px-4 flex items-center justify-between">
          <div className="flex items-center gap-6">
            <span className="flex items-center gap-1.5"><Phone size={12} /> 800 123 456 (bezpłatna)</span>
            <span className="flex items-center gap-1.5"><MapPin size={12} /> Salony w całej Polsce</span>
          </div>
          <div className="flex items-center gap-6 text-blue-100">
            <span>Darmowa dostawa od 299 zł</span>
            <span>Zwrot 30 dni</span>
            <span>Raty 0%</span>
          </div>
        </div>
      </div>

      {/* Main header */}
      <header className={`sticky top-0 z-50 bg-white transition-all duration-300 ${scrolled ? 'shadow-md' : 'shadow-sm'}`}>
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex items-center gap-4 h-16">
            {/* Logo */}
            <a
              href="#"
              className="flex items-center gap-2 shrink-0"
              onClick={() => { onCategoryChange(null); onSearch(''); setSearchValue(''); }}
            >
              <div className="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                <span className="text-white font-bold text-base" style={{ fontFamily: 'Sora, sans-serif' }}>M</span>
              </div>
              <div className="hidden sm:block">
                <div className="font-bold text-gray-900 text-lg leading-tight" style={{ fontFamily: 'Sora, sans-serif' }}>MegaSklep</div>
                <div className="text-blue-600 text-[10px] font-semibold tracking-widest uppercase leading-tight">AGD · Elektronika · Meble</div>
              </div>
            </a>

            {/* Search */}
            <form onSubmit={handleSearch} className="flex-1 max-w-xl mx-auto hidden md:flex">
              <div className={`relative w-full transition-all duration-200 ${searchFocused ? 'scale-[1.01]' : ''}`}>
                <input
                  type="text"
                  value={searchValue}
                  onChange={e => setSearchValue(e.target.value)}
                  onFocus={() => setSearchFocused(true)}
                  onBlur={() => setSearchFocused(false)}
                  placeholder="Szukaj produktów, marek, kategorii..."
                  className="w-full pl-5 pr-14 py-2.5 rounded-2xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none text-sm transition-colors duration-200 bg-gray-50 focus:bg-white"
                />
                <button
                  type="submit"
                  className="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-xl transition-colors duration-200"
                >
                  <Search size={16} />
                </button>
              </div>
            </form>

            {/* Actions */}
            <div className="flex items-center gap-1 ml-auto">
              <button className="relative p-2 hover:bg-gray-100 rounded-xl transition-colors group">
                <Heart size={22} className="text-gray-600 group-hover:text-red-500 transition-colors" />
                {wishlistCount > 0 && (
                  <span className="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                    {wishlistCount}
                  </span>
                )}
              </button>
              <button className="relative p-2 hover:bg-gray-100 rounded-xl transition-colors group" onClick={onCartOpen}>
                <ShoppingCart size={22} className="text-gray-600 group-hover:text-blue-600 transition-colors" />
                {cartCount > 0 && (
                  <span className="absolute -top-0.5 -right-0.5 bg-blue-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                    {cartCount}
                  </span>
                )}
              </button>
              <button className="hidden sm:flex p-2 hover:bg-gray-100 rounded-xl transition-colors group">
                <User size={22} className="text-gray-600 group-hover:text-blue-600 transition-colors" />
              </button>
              <button className="md:hidden p-2 hover:bg-gray-100 rounded-xl transition-colors" onClick={() => setMobileOpen(v => !v)}>
                {mobileOpen ? <X size={22} /> : <Menu size={22} />}
              </button>
            </div>
          </div>
        </div>

        {/* Nav */}
        <nav className="border-t border-gray-100 hidden md:block">
          <div className="max-w-7xl mx-auto px-4">
            <div className="flex items-center gap-1">
              {categories.map(cat => (
                <button
                  key={cat.id}
                  onClick={() => onCategoryChange(activeCategory === cat.id ? null : cat.id)}
                  className={`flex items-center gap-2 px-4 py-3 text-sm font-semibold transition-all duration-200 border-b-2 ${
                    activeCategory === cat.id
                      ? 'border-blue-600 text-blue-600 bg-blue-50'
                      : 'border-transparent text-gray-600 hover:text-blue-600 hover:bg-gray-50'
                  }`}
                >
                  {cat.name}
                  <ChevronDown size={14} className={`transition-transform duration-200 ${activeCategory === cat.id ? 'rotate-180' : ''}`} />
                  <span className="text-xs text-gray-400 font-normal">({cat.productCount.toLocaleString('pl-PL')})</span>
                </button>
              ))}
              <div className="ml-auto flex items-center gap-4 py-2 text-sm text-gray-500">
                <a href="#promotions" className="hover:text-red-600 font-medium transition-colors">🔥 Promocje</a>
                <a href="#" className="hover:text-blue-600 transition-colors">Raty 0%</a>
                <a href="#" className="hover:text-blue-600 transition-colors">Outlet</a>
              </div>
            </div>
          </div>
        </nav>

        {/* Mobile menu */}
        {mobileOpen && (
          <div className="md:hidden border-t border-gray-100 bg-white shadow-lg">
            <div className="p-4">
              <form onSubmit={handleSearch} className="mb-4">
                <div className="relative">
                  <input
                    type="text"
                    value={searchValue}
                    onChange={e => setSearchValue(e.target.value)}
                    placeholder="Szukaj produktów..."
                    className="w-full pl-4 pr-12 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:outline-none text-sm"
                  />
                  <button type="submit" className="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 text-white p-1.5 rounded-lg">
                    <Search size={14} />
                  </button>
                </div>
              </form>
              {categories.map(cat => (
                <button
                  key={cat.id}
                  onClick={() => { onCategoryChange(cat.id); setMobileOpen(false); }}
                  className="flex items-center justify-between w-full py-3 px-2 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-blue-600"
                >
                  <span>{cat.name}</span>
                  <span className="text-xs text-gray-400">{cat.productCount.toLocaleString('pl-PL')} produktów</span>
                </button>
              ))}
            </div>
          </div>
        )}
      </header>
    </>
  );
}
