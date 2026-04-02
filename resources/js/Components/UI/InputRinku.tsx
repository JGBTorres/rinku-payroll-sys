import React from 'react';

interface InputProps extends React.InputHTMLAttributes<HTMLInputElement> {
    label: string;
    error?: any;
    colSpan?: string;
}

export const InputRinku: React.FC<InputProps> = ({ label, error, colSpan = "md:col-span-3", ...props }) => (
    <div className={`${colSpan} space-y-3`}>
        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">{label}</label>
        <input
            {...props}
            className={`w-full h-14 px-5 text-lg font-medium border-2 transition-all outline-none rounded-2xl ${error ? 'border-red-200 bg-red-50 text-red-600' : 'border-slate-50 bg-slate-50 focus:bg-white focus:border-emerald-500 text-slate-700'
                }`}
        />
    </div>
);
