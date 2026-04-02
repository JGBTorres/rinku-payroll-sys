import React from 'react';

interface BotonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
    loading?: boolean;
    variant?: 'emerald' | 'blue' | 'red';
    label: string;
}

export const BotonRinku: React.FC<BotonProps> = ({ loading, variant = 'emerald', label, ...props }) => {
    const variants = {
        emerald: 'bg-emerald-600',
        blue: 'bg-blue-600',
        red: 'bg-red-500'
    };

    return (
        <button
            {...props}
            disabled={loading}
            className={`w-full h-14 ${variants[variant]} text-white font-black uppercase text-sm tracking-widest shadow-xl rounded-2xl hover:translate-y-[-2px] active:scale-95 transition-all disabled:opacity-50`}
        >
            {loading ? 'Procesando...' : label}
        </button>
    );
};
