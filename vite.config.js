 import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'; // Importamos plugin de Vue
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

 export default defineConfig({
     base: '/',  // Rutas relativas para assets
     plugins: [
         laravel({
             input: [
                 'resources/css/app.css',
                 'resources/js/app.js',
             ],
             refresh: true,
         }),
         vue(),         // Añadimos soporte para .vue
         tailwindcss(),
     ],
     resolve: {
         alias: {
             'vue': 'vue/dist/vue.esm-bundler.js',
         },
     },
     build: {
         manifest: true,
         outDir: 'public/build',
         emptyOutDir: true,
         rollupOptions: {
             output: {
                 entryFileNames: 'assets/[name]-[hash].js',
                 chunkFileNames: 'assets/[name]-[hash].js',
                 assetFileNames: 'assets/[name]-[hash][extname]',
             },
         },
     },
 });