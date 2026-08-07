import { useState, useMemo } from 'react';
import { SlidersHorizontal, ChevronDown, X } from 'lucide-react';
import { Product, products, categories } from '@/data/products';
import ProductCard from './ProductCard';

interface ProductGridProps {
  activeCategory: string | null;
  searchQuery: string;
  cartItems: { product: Product; qty: number }[];
  wishlist: string[];
  onAddToCart: (p: Product) => void;
  onWishlist: (p: Product) => void;
  onClearFilters: () => void;
}

type SortKey = 'default' | 'price_asc' | 'price_desc' | 'rating' | 'newest';

const sortOptions: { value: SortKey; label: string }[] = [
  { value: 'default', label: 'Domyślne' },
  { value: 'price_asc', label: 'Cena: od najniższej' },
  { value: 'price_desc', label: 'Cena: od najwyższej' },
  { value: 'rating', label: 'Najlepiej oceniane' },
  { value: 'newest', label: 'Nowości' },
];

export default function ProductGrid({
  activeCategory, searchQuery, cartItems, wishlist,
  onAddToCart, onWishlist, onClearFilters,
}: ProductGridProps) {
  const [sort, setSort] = useState<SortKey>('default');
  const [sortOpen, setSortOpen] = useState(false);
  const [activeSubcat, setActiveSubcat] = useState<string | null>(null);
  const [maxPrice, setMaxPrice] = useState<number>(10000);
  const [filtersOpen, setFiltersOpen] = useState(false);

  const category = categories.find(c => c.id === activeCategory);

  const filtered = useMemo(() => {
    let list = products;
    if (activeCategory) list = list.filter(p => p.category === activeCategory);
    if (activeSubcat) list = list.filter(p => p.subcategory === activeSubcat);
    if (searchQuery) {
      const q = searchQuery.toLowerCase();
      list = list.filter(p =>
        p.name.toLowerCase().includes(q) ||
        p.brand.toLowerCase().includes(q) ||
        p.description.toLowerCase().includes(q)
      );
    }
    list = list.filter(p => p.price <= maxPrice);

    switch (sort) {
      case 'price_asc': return [...list].sort((a, b) => a.price - b.price);
      case 'price_desc': return [...list].sort((a, b) => b.price - a.price);
      case 'rating': return [...list].sort((a, b) => b.rating - a.rating);
      case 'newest': return [...list].sort((a, b) => (b.isNew ? 1 : 0) - (a.isNew ? 1 : 0));
      default: return list;
    }
  }, [activeCategory, activeSubcat, searchQuery, sort, maxPrice]);

  const hasFilters = !!activeCategory || !!searchQuery || !!activeSubcat;

  return (
    <section id="products" className="py-8">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
          <h2 className="text-2xl font-bold text-gray-900">
            {searchQuery
              ? `Wyniki dla „${searchQuery}"`
              : category
              ? category.name
              : 'Polecane produkty'}
          </h2>
          <p className="text-sm text-gray-500 mt-0.5">
            {filtered.length} {filtered.length === 1 ? 'produkt' : filtered.length < 5 ? 'produkty' : 'produktów'}
          </p>
        </div>
        <div className="flex items-center gap-2">
          {hasFilters && (
            <button
              onClick={() => { onClearFilters(); setActiveSubcat(null); }}
              className="flex items-center gap-1.5 text-sm text-red-600 hover:text-red-700 font-medium px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 transition-colors"
            >
              <X size={14} /> Wyczyść filtry
            </button>
          )}
          <button
            onClick={() => setFiltersOpen(v => !v)}
            className="flex items-center gap-2 text-sm text-gray-600 border border-gray-200 hover:border-blue-300 px-4 py-2 rounded-xl transition-colors"
          >
            <SlidersHorizontal size={15} /> Filtry
          </button>
          {/* Sort */}
          <div className="relative">
            <button
              onClick={() => setSortOpen(v => !v)}
              className="flex items-center gap-2 text-sm text-gray-600 border border-gray-200 hover:border-blue-300 px-4 py-2 rounded-xl transition-colors"
            >
              Sortuj <ChevronDown size={14} className={`transition-transform ${sortOpen ? 'rotate-180' : ''}`} />
            </button>
            {sortOpen && (
              <div className="absolute right-0 mt-2 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl z-20 overflow-hidden">
                {sortOptions.map(o => (
                  <button
                    key={o.value}
                    onClick={() => { setSort(o.value); setSortOpen(false); }}
                    className={`block w-full text-left px-4 py-3 text-sm transition-colors ${
                      sort === o.value ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-50 text-gray-700'
                    }`}
                  >
                    {o.label}
                  </button>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>

      {/* Subcategory pills */}
      {category && (
        <div className="flex gap-2 flex-wrap mb-6">
          <button
            onClick={() => setActiveSubcat(null)}
            className={`px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 ${
              !activeSubcat ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
            }`}
          >
            Wszystkie
          </button>
          {category.subcategories.map(sub => (
            <button
              key={sub}
              onClick={() => setActiveSubcat(activeSubcat === sub ? null : sub)}
              className={`px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 ${
                activeSubcat === sub ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
              }`}
            >
              {sub}
            </button>
          ))}
        </div>
      )}

      {/* Price filter */}
      {filtersOpen && (
        <div className="mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-100">
          <label className="text-sm font-semibold text-gray-700 mb-2 block">
            Maksymalna cena: <span className="text-blue-600">{maxPrice.toLocaleString('pl-PL')} zł</span>
          </label>
          <input
            type="range"
            min={100}
            max={10000}
            step={100}
            value={maxPrice}
            onChange={e => setMaxPrice(Number(e.target.value))}
            className="w-full accent-blue-600"
          />
          <div className="flex justify-between text-xs text-gray-400 mt-1">
            <span>100 zł</span>
            <span>10 000 zł</span>
          </div>
        </div>
      )}

      {/* Grid */}
      {filtered.length > 0 ? (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          {filtered.map(product => (
            <ProductCard
              key={product.id}
              product={product}
              onAddToCart={onAddToCart}
              wishlisted={wishlist.includes(product.id)}
              onWishlist={onWishlist}
            />
          ))}
        </div>
      ) : (
        <div className="flex flex-col items-center justify-center py-20 text-center">
          <div className="text-6xl mb-4">🔍</div>
          <h3 className="text-xl font-semibold text-gray-700 mb-2">Brak wyników</h3>
          <p className="text-gray-500 mb-6">Nie znaleziono produktów spełniających kryteria wyszukiwania.</p>
          <button onClick={() => { onClearFilters(); setActiveSubcat(null); }} className="btn-primary">
            Pokaż wszystkie produkty
          </button>
        </div>
      )}
    </section>
  );
}
