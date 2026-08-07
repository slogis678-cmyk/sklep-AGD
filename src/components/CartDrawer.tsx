import { X, ShoppingCart, Trash2, Plus, Minus, ArrowRight } from 'lucide-react';
import { Product } from '@/data/products';

interface CartItem {
  product: Product;
  qty: number;
}

interface CartDrawerProps {
  open: boolean;
  onClose: () => void;
  items: CartItem[];
  onRemove: (id: string) => void;
  onQtyChange: (id: string, delta: number) => void;
}

export default function CartDrawer({ open, onClose, items, onRemove, onQtyChange }: CartDrawerProps) {
  const total = items.reduce((sum, { product, qty }) => sum + product.price * qty, 0);
  const count = items.reduce((sum, { qty }) => sum + qty, 0);

  return (
    <>
      {/* Backdrop */}
      <div
        className={`fixed inset-0 bg-black/40 backdrop-blur-sm z-50 transition-opacity duration-300 ${open ? 'opacity-100' : 'opacity-0 pointer-events-none'}`}
        onClick={onClose}
      />
      {/* Drawer */}
      <div className={`fixed right-0 top-0 bottom-0 w-full max-w-md bg-white z-50 shadow-2xl flex flex-col transition-transform duration-300 ${open ? 'translate-x-0' : 'translate-x-full'}`}>
        {/* Header */}
        <div className="flex items-center justify-between p-5 border-b border-gray-100">
          <div className="flex items-center gap-2">
            <ShoppingCart size={22} className="text-blue-600" />
            <h2 className="text-lg font-bold text-gray-900">Koszyk</h2>
            {count > 0 && (
              <span className="bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{count}</span>
            )}
          </div>
          <button onClick={onClose} className="p-2 hover:bg-gray-100 rounded-xl transition-colors">
            <X size={20} />
          </button>
        </div>

        {/* Items */}
        <div className="flex-1 overflow-y-auto p-5 space-y-4">
          {items.length === 0 ? (
            <div className="flex flex-col items-center justify-center h-full text-center py-16">
              <ShoppingCart size={48} className="text-gray-200 mb-4" />
              <p className="text-gray-500 font-medium">Koszyk jest pusty</p>
              <p className="text-gray-400 text-sm mt-1">Dodaj produkty, aby kontynuować</p>
              <button onClick={onClose} className="btn-primary mt-6 text-sm">
                Przeglądaj produkty
              </button>
            </div>
          ) : (
            items.map(({ product, qty }) => (
              <div key={product.id} className="flex gap-3 p-3 bg-gray-50 rounded-2xl">
                <img
                  src={product.image}
                  alt={product.name}
                  className="w-16 h-16 object-cover rounded-xl shrink-0"
                />
                <div className="flex-1 min-w-0">
                  <p className="text-xs text-blue-600 font-semibold">{product.brand}</p>
                  <p className="text-sm font-semibold text-gray-800 line-clamp-2 leading-snug">{product.name}</p>
                  <div className="flex items-center justify-between mt-2">
                    <span className="text-sm font-bold text-gray-900">{(product.price * qty).toLocaleString('pl-PL')} zł</span>
                    <div className="flex items-center gap-2">
                      <button
                        onClick={() => onQtyChange(product.id, -1)}
                        className="p-1 bg-white rounded-lg border border-gray-200 hover:border-blue-300 transition-colors"
                      >
                        <Minus size={12} />
                      </button>
                      <span className="text-sm font-semibold w-5 text-center">{qty}</span>
                      <button
                        onClick={() => onQtyChange(product.id, 1)}
                        className="p-1 bg-white rounded-lg border border-gray-200 hover:border-blue-300 transition-colors"
                      >
                        <Plus size={12} />
                      </button>
                    </div>
                  </div>
                </div>
                <button
                  onClick={() => onRemove(product.id)}
                  className="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors self-start shrink-0"
                >
                  <Trash2 size={14} />
                </button>
              </div>
            ))
          )}
        </div>

        {/* Footer */}
        {items.length > 0 && (
          <div className="p-5 border-t border-gray-100 bg-white">
            <div className="flex items-center justify-between mb-1 text-sm text-gray-500">
              <span>Wysyłka:</span>
              <span className={total >= 299 ? 'text-emerald-600 font-semibold' : ''}>
                {total >= 299 ? 'Darmowa' : '19 zł'}
              </span>
            </div>
            {total < 299 && (
              <div className="mb-3">
                <div className="flex justify-between text-xs text-gray-500 mb-1">
                  <span>Do darmowej dostawy:</span>
                  <span className="font-medium">{(299 - total).toLocaleString('pl-PL')} zł</span>
                </div>
                <div className="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                  <div
                    className="h-full bg-blue-500 rounded-full transition-all duration-500"
                    style={{ width: `${Math.min((total / 299) * 100, 100)}%` }}
                  />
                </div>
              </div>
            )}
            <div className="flex items-center justify-between mb-4">
              <span className="font-bold text-gray-900">Razem:</span>
              <span className="text-2xl font-bold text-blue-600">{total.toLocaleString('pl-PL')} zł</span>
            </div>
            <button className="btn-primary w-full justify-center text-base py-4 rounded-2xl">
              Przejdź do kasy <ArrowRight size={18} />
            </button>
            <button className="btn-secondary w-full justify-center mt-2 py-3 rounded-2xl text-sm" onClick={onClose}>
              Kontynuuj zakupy
            </button>
          </div>
        )}
      </div>
    </>
  );
}
