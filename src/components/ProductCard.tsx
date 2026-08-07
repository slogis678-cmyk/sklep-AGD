import { Star, ShoppingCart, Heart, Eye } from 'lucide-react';
import { Product } from '@/data/products';

interface ProductCardProps {
  product: Product;
  onAddToCart: (product: Product) => void;
  wishlisted: boolean;
  onWishlist: (product: Product) => void;
}

const badgeClasses: Record<string, string> = {
  red: 'bg-red-100 text-red-700',
  blue: 'bg-blue-100 text-blue-700',
  green: 'bg-emerald-100 text-emerald-700',
  amber: 'bg-amber-100 text-amber-700',
};

export default function ProductCard({ product, onAddToCart, wishlisted, onWishlist }: ProductCardProps) {
  const discount = product.originalPrice
    ? Math.round((1 - product.price / product.originalPrice) * 100)
    : null;

  return (
    <div className="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
      {/* Image */}
      <div className="relative overflow-hidden bg-gray-50 h-48">
        <img
          src={product.image}
          alt={product.name}
          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
        {/* Badge */}
        {product.badge && (
          <span className={`absolute top-3 left-3 badge ${badgeClasses[product.badgeColor || 'blue']} font-bold z-10`}>
            {product.badge}
          </span>
        )}
        {/* Out of stock */}
        {!product.inStock && (
          <div className="absolute inset-0 bg-white/70 flex items-center justify-center">
            <span className="bg-gray-700 text-white text-sm font-semibold px-3 py-1 rounded-full">Niedostępny</span>
          </div>
        )}
        {/* Actions overlay */}
        <div className="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
          <button
            onClick={() => onWishlist(product)}
            className={`p-2 rounded-xl shadow-md transition-all duration-200 ${wishlisted ? 'bg-red-500 text-white' : 'bg-white text-gray-600 hover:text-red-500'}`}
          >
            <Heart size={16} fill={wishlisted ? 'currentColor' : 'none'} />
          </button>
          <button className="bg-white text-gray-600 hover:text-blue-600 p-2 rounded-xl shadow-md transition-all duration-200">
            <Eye size={16} />
          </button>
        </div>
      </div>

      {/* Info */}
      <div className="flex flex-col flex-1 p-4">
        <div className="text-xs text-blue-600 font-semibold mb-1">{product.brand}</div>
        <h3 className="text-sm font-semibold text-gray-800 line-clamp-2 mb-2 leading-snug flex-1">{product.name}</h3>
        
        {/* Rating */}
        <div className="flex items-center gap-1.5 mb-3">
          <div className="flex items-center gap-0.5">
            {Array.from({ length: 5 }).map((_, i) => (
              <Star
                key={i}
                size={12}
                className={i < Math.floor(product.rating) ? 'text-amber-400 fill-amber-400' : 'text-gray-200 fill-gray-200'}
              />
            ))}
          </div>
          <span className="text-xs text-gray-500">{product.rating} ({product.reviews})</span>
        </div>

        {/* Price */}
        <div className="flex items-end justify-between gap-2 mt-auto">
          <div>
            <div className="text-xl font-bold text-gray-900">
              {product.price.toLocaleString('pl-PL')} zł
            </div>
            {product.originalPrice && (
              <div className="flex items-center gap-1.5">
                <span className="text-xs text-gray-400 line-through">
                  {product.originalPrice.toLocaleString('pl-PL')} zł
                </span>
                {discount && (
                  <span className="text-xs text-red-600 font-semibold">-{discount}%</span>
                )}
              </div>
            )}
          </div>
          <button
            onClick={() => onAddToCart(product)}
            disabled={!product.inStock}
            className={`p-2.5 rounded-xl transition-all duration-200 ${
              product.inStock
                ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md active:scale-95'
                : 'bg-gray-100 text-gray-400 cursor-not-allowed'
            }`}
          >
            <ShoppingCart size={18} />
          </button>
        </div>
      </div>
    </div>
  );
}
