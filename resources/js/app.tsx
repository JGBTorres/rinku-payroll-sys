import './bootstrap';
import '../css/app.css';

import 'react-toastify/dist/ReactToastify.css';
import { ToastContainer } from 'react-toastify';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

createInertiaApp({
    title: (title) => `${title} - Rinku Payroll`,

    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
        const page = pages[`./Pages/${name}.tsx`];

        if (!page) {
            console.error("Archivos detectados por Vite:", Object.keys(pages));
            throw new Error(`Componente no encontrado: ./Pages/${name}.tsx`);
        }

        return (page as any).default || page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(
            <>

                <App {...props} />
                <ToastContainer theme="colored" position="top-right" />
            </>
        );
    },
});
