import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/views/auth/login.js',
                'resources/js/views/auth/register.js',
                'resources/js/views/auth/forgot-password.js',
                'resources/js/views/auth/reset-password.js',
                'resources/js/views/auth/confirm-password.js',
                'resources/js/views/layouts/partials/header.js',
                'resources/js/views/profile/edit.js',
                'resources/js/views/profile/update-password.js',
                'resources/js/views/profile/delete-account.js',
                'resources/js/views/roles/create.js',
                'resources/js/views/roles/edit.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            'vue': 'vue/dist/vue.esm-bundler.js',
            'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
        }
    },
    // Hide console.log after run `npm run build`
    // Source: https://github.com/vitejs/vite/discussions/7920
    esbuild: {
        drop: ['console', 'debugger'],
    },
});
