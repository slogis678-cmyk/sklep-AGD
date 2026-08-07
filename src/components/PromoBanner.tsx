import { useState, useEffect } from 'react';
import { Clock, ArrowRight } from 'lucide-react';

export default function PromoBanner() {
  const [time, setTime] = useState({ h: 5, m: 42, s: 17 });

  useEffect(() => {
    const t = setInterval(() => {
      setTime(prev => {
        let { h, m, s } = prev;
        s--;
        if (s < 0) { s = 59; m--; }
        if (m < 0) { m = 59; h--; }
        if (h < 0) { h = 23; m = 59; s = 59; }
        return { h, m, s };
      });
    }, 1000);
    return () => clearInterval(t);
  }, []);

  const pad = (n: number) => String(n).padStart(2, '0');

  return (
    <section id="promotions" className="py-4">
      <div className="bg-gradient-to-r from-red-600 via-red-500 to-orange-500 rounded-3xl overflow-hidden">
        <div className="flex flex-col md:flex-row items-center justify-between px-8 py-7 gap-6">
          <div className="flex items-center gap-4">
            <div className="bg-white/20 rounded-2xl p-3">
              <Clock size={28} className="text-white" />
            </div>
            <div>
              <div className="text-white/80 text-sm font-medium mb-0.5">Oferta dnia kończy się za:</div>
              <h3 className="text-white text-xl font-bold">Błyskawiczna Promocja</h3>
            </div>
          </div>

          {/* Countdown */}
          <div className="flex items-center gap-3">
            {[
              { val: pad(time.h), label: 'godzin' },
              { val: pad(time.m), label: 'minut' },
              { val: pad(time.s), label: 'sekund' },
            ].map((item, i) => (
              <div key={i} className="flex items-center gap-3">
                <div className="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2.5 text-center border border-white/20 min-w-[64px]">
                  <div className="text-white text-2xl font-bold font-mono leading-none">{item.val}</div>
                  <div className="text-white/70 text-[10px] mt-0.5">{item.label}</div>
                </div>
                {i < 2 && <span className="text-white font-bold text-xl">:</span>}
              </div>
            ))}
          </div>

          <div className="flex flex-col items-center md:items-end gap-2">
            <div className="text-white/80 text-sm">Oszczędź do <span className="text-white font-bold text-xl">40%</span></div>
            <button className="inline-flex items-center gap-2 bg-white text-red-600 font-bold px-6 py-3 rounded-2xl hover:bg-red-50 transition-all duration-200 shadow-lg hover:shadow-xl active:scale-95 group">
              Sprawdź oferty
              <ArrowRight size={16} className="group-hover:translate-x-0.5 transition-transform" />
            </button>
          </div>
        </div>
      </div>
    </section>
  );
}
