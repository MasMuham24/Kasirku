import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // Import tailwindcss
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        // Tambahkan tailwindcss secara eksplisit jika postcss.config.js ada
        fs.existsSync(path.resolve(__dirname, 'postcss.config.js')) ? tailwindcss() : null,
    ].filter(Boolean), // Filter out null values if tailwindcss was not added
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
