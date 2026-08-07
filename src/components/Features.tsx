import { Truck, RotateCcw, CreditCard, ShieldCheck, Headphones, Star } from 'lucide-react';

const features = [
  { icon: Truck, title: 'Darmowa dostawa', desc: 'Od 299 zł zamówienia', color: 'blue' },
  { icon: RotateCcw, title: 'Zwrot 30 dni', desc: 'Bez podawania przyczyny', color: 'emerald' },
  { icon: CreditCard, title: 'Raty 0%', desc: 'Nawet do 36 rat', color: 'amber' },
  { icon: ShieldCheck, title: 'Oryginalne produkty', desc: 'Gwarancja autentyczności', color: 'blue' },
  { icon: Headphones, title: 'Wsparcie 24/7', desc: 'Zawsze do Twojej dyspozycji', color: 'violet' },
  { icon: Star, title: 'Program lojalnościowy', desc: 'Zbieraj punkty i oszczędzaj', color: 'amber' },
];

const colorMap: Record<string, string> = {
  blue: 'bg-blue-50 text-blue-600',
  emerald: 'bg-emerald-50 text-emerald-600',
  amber: 'bg-amber-50 text-amber-600',
  violet: 'bg-violet-50 text-violet-600',
};

export default function Features() {
  return (
    <section className="py-10 border-t border-gray-100">
      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        {features.map((f, i) => (
          <div key={i} className="flex flex-col items-center text-center p-4 rounded-2xl hover:bg-gray-50 transition-colors duration-200 group">
            <div className={`p-3 rounded-2xl mb-3 transition-transform duration-200 group-hover:scale-110 ${colorMap[f.color]}`}>
              <f.icon size={22} />
            </div>
            <div className="text-sm font-semibold text-gray-800 mb-0.5">{f.title}</div>
            <div className="text-xs text-gray-500">{f.desc}</div>
          </div>
        ))}
      </div>
    </section>
  );
}
