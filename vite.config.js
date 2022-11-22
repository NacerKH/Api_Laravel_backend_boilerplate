import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import vueI18n from '@intlify/vite-plugin-vue-i18n'
import { resolve, dirname } from 'node:path'
import { fileURLToPath } from 'url'
import { splitVendorChunkPlugin } from 'vite'
export default defineConfig({
    server: {
        origin: 'http://127.0.0.1:8080'
      },
    plugins: [
        splitVendorChunkPlugin(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
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
        vueI18n({
            include: resolve(dirname(fileURLToPath(import.meta.url)), './resources/js/locales/**'),
          })
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',


        },
    },
});
