// 1. Define la interfaz con headerExtra (el signo ? lo hace opcional)
interface CardProps {
    titulo: string;
    icono: string;
    isEditing: boolean;
    headerExtra?: React.ReactNode;
    children: React.ReactNode;
}


export const CardRinku: React.FC<CardProps> = ({
    titulo,
    icono,
    isEditing,
    headerExtra,
    children
}) => {
    return (
        <div className={`max-w-6xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden transition-all ${isEditing ? 'ring-2 ring-blue-500' : ''}`}>
            <div className={`p-6 text-white flex justify-between items-center ${isEditing ? 'bg-blue-600' : 'bg-slate-900'}`}>
                <div className="flex items-center gap-4">
                    <div className="text-2xl">{isEditing ? '📝' : icono}</div>
                    <h2 className="font-bold uppercase tracking-tight">{titulo}</h2>
                </div>


                {headerExtra && <div>{headerExtra}</div>}
            </div>
            <div className="p-8">
                {children}
            </div>
        </div>
    );
};
