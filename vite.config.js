import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                },
            },
        }),
        laravel({
            input: ['resources/ts/src/main.ts'],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
          plugins: [
            require('tailwindcss'),
          ],
        },
      }
});
