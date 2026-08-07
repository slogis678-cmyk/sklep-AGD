import { useState, useEffect } from 'react';
import { ChevronLeft, ChevronRight, ArrowRight } from 'lucide-react';
import { featuredBanners } from '@/data/products';

interface HeroBannerProps {
  onCategoryChange: (cat: string) => void;
}

export default function HeroBanner({ onCategoryChange }: HeroBannerProps) {
  const [active, setActive] = useState(0);

  useEffect(() => {
    const t = setInterval(() => setActive(i => (i + 1) % featuredBanners.length), 5000);
    return () => clearInterval(t);
  }, []);

  const prev = () => setActive(i => (i - 1 + featuredBanners.length) % featuredBanners.length);
  const next = () => setActive(i => (i + 1) % featuredBanners.length);

  const banner = featuredBanners[active];

  return (
    <div className="relative overflow-hidden rounded-3xl bg-gray-900 h-[420px] md:h-[500px]">
      {/* Images */}
      {featuredBanners.map((b, i) => (
        <div
          key={b.id}
          className={`absolute inset-0 transition-opacity duration-700 ${i === active ? 'opacity-100' : 'opacity-0'}`}
        >
          <img
            src={b.image}
            alt={b.title}
            className="w-full h-full object-cover"
          />
          <div className={`absolute inset-0 bg-gradient-to-r ${b.color} opacity-75`} />
        </div>
      ))}

      {/* Content */}
      <div className="relative z-10 h-full flex flex-col justify-center px-8 md:px-16 max-w-2xl">
        <span className="inline-block mb-4 px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full border border-white/30">
          {banner.badge}
        </span>
        <h1 className="text-3xl md:text-5xl font-bold text-white mb-3 leading-tight">
          {banner.title}
        </h1>
        <p className="text-white/80 text-lg mb-8 font-medium">
          {banner.subtitle}
        </p>
        <button
          onClick={() => onCategoryChange(banner.category)}
          className="inline-flex items-center gap-2 bg-white text-gray-900 font-semibold px-7 py-3.5 rounded-2xl hover:bg-gray-100 transition-all duration-200 shadow-xl w-fit group"
        >
          {banner.cta}
          <ArrowRight size={18} className="group-hover:translate-x-1 transition-transform duration-200" />
        </button>
      </div>

      {/* Controls */}
      <button
        onClick={prev}
        className="absolute left-4 top-1/2 -translate-y-1/2 z-10 bg-white/20 backdrop-blur-sm hover:bg-white/40 text-white p-2.5 rounded-full transition-all duration-200 border border-white/20"
      >
        <ChevronLeft size={20} />
      </button>
      <button
        onClick={next}
        className="absolute right-4 top-1/2 -translate-y-1/2 z-10 bg-white/20 backdrop-blur-sm hover:bg-white/40 text-white p-2.5 rounded-full transition-all duration-200 border border-white/20"
      >
        <ChevronRight size={20} />
      </button>

      {/* Dots */}
      <div className="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2">
        {featuredBanners.map((_, i) => (
          <button
            key={i}
            onClick={() => setActive(i)}
            className={`transition-all duration-300 rounded-full ${i === active ? 'bg-white w-6 h-2' : 'bg-white/50 w-2 h-2'}`}
          />
        ))}
      </div>
    </div>
  );
}
