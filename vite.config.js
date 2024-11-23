import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/theme.css', // Tambahkan jika diperlukan
            ],
            refresh: [
                ...refreshPaths,
                'app/Filament/**',
                'app/Livewire/**',
                'app/Forms/Components/**',
                'app/Infolist/Components/**',
                'app/Providers/Filament/**',
                'app/Table/Columns/**'
            ],
        }),
    ],
});
