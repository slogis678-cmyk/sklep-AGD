import { useState, useCallback } from 'react';
import DownloadPage from '@/components/DownloadPage';
import Header from '@/components/Header';
import HeroBanner from '@/components/HeroBanner';
import CategoryCards from '@/components/CategoryCards';
import ProductGrid from '@/components/ProductGrid';
import PromoBanner from '@/components/PromoBanner';
import Features from '@/components/Features';
import CartDrawer from '@/components/CartDrawer';
import Footer from '@/components/Footer';
import Toast from '@/components/Toast';
import { Product } from '@/data/products';

interface CartItem {
  product: Product;
  qty: number;
}

export default function App() {
  const [activeCategory, setActiveCategory] = useState<string | null>(null);
  const [searchQuery, setSearchQuery] = useState('');
  const [cartOpen, setCartOpen] = useState(false);
  const [cart, setCart] = useState<CartItem[]>([]);
  const [wishlist, setWishlist] = useState<string[]>([]);
  const [toast, setToast] = useState<string | null>(null);

  const showToast = useCallback((msg: string) => {
    setToast(msg);
  }, []);

  const handleAddToCart = useCallback((product: Product) => {
    setCart(prev => {
      const existing = prev.find(i => i.product.id === product.id);
      if (existing) {
        return prev.map(i => i.product.id === product.id ? { ...i, qty: i.qty + 1 } : i);
      }
      return [...prev, { product, qty: 1 }];
    });
    showToast(`Dodano do koszyka: ${product.name}`);
  }, [showToast]);

  const handleRemoveFromCart = useCallback((id: string) => {
    setCart(prev => prev.filter(i => i.product.id !== id));
  }, []);

  const handleQtyChange = useCallback((id: string, delta: number) => {
    setCart(prev =>
      prev
        .map(i => i.product.id === id ? { ...i, qty: i.qty + delta } : i)
        .filter(i => i.qty > 0)
    );
  }, []);

  const handleWishlist = useCallback((product: Product) => {
    setWishlist(prev => {
      if (prev.includes(product.id)) {
        showToast(`Usunięto z ulubionych: ${product.name}`);
        return prev.filter(id => id !== product.id);
      }
      showToast(`Dodano do ulubionych: ${product.name}`);
      return [...prev, product.id];
    });
  }, [showToast]);

  const handleCategoryChange = useCallback((cat: string | null) => {
    setActiveCategory(cat);
    setSearchQuery('');
    if (cat) setTimeout(() => document.getElementById('products')?.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
  }, []);

  const handleSearch = useCallback((q: string) => {
    setSearchQuery(q);
    setActiveCategory(null);
    if (q) setTimeout(() => document.getElementById('products')?.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
  }, []);

  const handleClearFilters = useCallback(() => {
    setActiveCategory(null);
    setSearchQuery('');
  }, []);

  const cartCount = cart.reduce((s, i) => s + i.qty, 0);

  if (window.location.pathname === '/download') {
    return <DownloadPage />;
  }

  return (
    <div className="min-h-screen bg-gray-50">
      <Header
        cartCount={cartCount}
        wishlistCount={wishlist.length}
        onCartOpen={() => setCartOpen(true)}
        onSearch={handleSearch}
        activeCategory={activeCategory}
        onCategoryChange={handleCategoryChange}
      />

      <main className="max-w-7xl mx-auto px-4">
        {/* Only show hero/categories when not searching/filtering */}
        {!activeCategory && !searchQuery && (
          <>
            <div className="pt-6">
              <HeroBanner onCategoryChange={handleCategoryChange} />
            </div>
            <Features />
            <CategoryCards onCategoryChange={handleCategoryChange} />
            <PromoBanner />
          </>
        )}

        <ProductGrid
          activeCategory={activeCategory}
          searchQuery={searchQuery}
          cartItems={cart}
          wishlist={wishlist}
          onAddToCart={handleAddToCart}
          onWishlist={handleWishlist}
          onClearFilters={handleClearFilters}
        />
      </main>

      <Footer />

      <CartDrawer
        open={cartOpen}
        onClose={() => setCartOpen(false)}
        items={cart}
        onRemove={handleRemoveFromCart}
        onQtyChange={handleQtyChange}
      />

      {toast && <Toast message={toast} onClose={() => setToast(null)} />}
    </div>
  );
}
