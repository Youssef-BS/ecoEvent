import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            // input: ['resources/css/app.css', 'resources/js/app.js'], // My group, it work with Bootstrap intead of tailwind
            input: [],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
