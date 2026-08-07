import { useEffect } from 'react';
import { CheckCircle, X } from 'lucide-react';

interface ToastProps {
  message: string;
  onClose: () => void;
}

export default function Toast({ message, onClose }: ToastProps) {
  useEffect(() => {
    const t = setTimeout(onClose, 3000);
    return () => clearTimeout(t);
  }, [onClose]);

  return (
    <div className="fixed bottom-6 right-6 z-[100] flex items-center gap-3 bg-gray-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl animate-[slideUp_0.3s_ease-out]">
      <CheckCircle size={18} className="text-emerald-400 shrink-0" />
      <span className="text-sm font-medium">{message}</span>
      <button onClick={onClose} className="p-0.5 hover:text-gray-300 transition-colors ml-1">
        <X size={14} />
      </button>
    </div>
  );
}
