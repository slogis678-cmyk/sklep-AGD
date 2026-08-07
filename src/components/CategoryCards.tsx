import { ArrowRight } from 'lucide-react';
import { categories } from '@/data/products';

interface CategoryCardsProps {
  onCategoryChange: (cat: string) => void;
}

export default function CategoryCards({ onCategoryChange }: CategoryCardsProps) {
  return (
    <section className="py-10">
      <div className="flex items-center justify-between mb-6">
        <div>
          <h2 className="text-2xl font-bold text-gray-900">Kategorie</h2>
          <p className="text-gray-500 text-sm mt-0.5">Przeglądaj naszą ofertę</p>
        </div>
      </div>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-5">
        {categories.map(cat => (
          <button
            key={cat.id}
            onClick={() => onCategoryChange(cat.id)}
            className="group relative overflow-hidden rounded-3xl h-48 text-left focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <img
              src={cat.image}
              alt={cat.name}
              className="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent" />
            <div className="relative h-full flex flex-col justify-end p-5">
              <div className="text-white/70 text-sm mb-1">{cat.productCount.toLocaleString('pl-PL')} produktów</div>
              <div className="flex items-center justify-between">
                <h3 className="text-white text-2xl font-bold">{cat.name}</h3>
                <div className="bg-white/20 backdrop-blur-sm group-hover:bg-white/40 p-2 rounded-full transition-all duration-200 border border-white/20">
                  <ArrowRight size={18} className="text-white group-hover:translate-x-0.5 transition-transform" />
                </div>
              </div>
              <div className="flex flex-wrap gap-1.5 mt-2">
                {cat.subcategories.slice(0, 3).map(sub => (
                  <span key={sub} className="text-xs bg-white/20 backdrop-blur-sm text-white px-2 py-0.5 rounded-full border border-white/10">
                    {sub}
                  </span>
                ))}
                {cat.subcategories.length > 3 && (
                  <span className="text-xs text-white/70">+{cat.subcategories.length - 3}</span>
                )}
              </div>
            </div>
          </button>
        ))}
      </div>
    </section>
  );
}
