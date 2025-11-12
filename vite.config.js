import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
        cors: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/admin-dashboard.js',
                'resources/js/map-initializer.js',
                'resources/js/registration.js',
                'resources/js/profile/base.js',
                'resources/js/profile/new-request.js',
                'resources/js/profile/requests-list.js',
                'resources/js/admin/user-requests/edit.js',
                'resources/js/admin/routes/create.js',
                'resources/js/admin/routes/edit.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
