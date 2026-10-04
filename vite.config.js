import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                    subsets: ['latin', 'latin-ext'],
                    fallbacks: ['ui-sans-serif', 'system-ui', 'sans-serif'],
                    optimizedFallbacks: false,
                    preload: [
                        { weight: 400, style: 'normal' },
                        { weight: 600, style: 'normal' },
                    ],
                }),
                bunny('Fraunces', {
                    weights: [500, 700],
                    subsets: ['latin', 'latin-ext'],
                    fallbacks: ['Georgia', 'Times New Roman', 'serif'],
                    optimizedFallbacks: false,
                    preload: [{ weight: 500, style: 'normal' }],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
