import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'
export default defineConfig({
    plugins: [

        laravel({
            input: [
                './resources/js/app.ts',
                // './resources/views/template/js/index.js',

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
    resolve:{
        alias: {
            "@": path.resolve(__dirname,"./resources/js"),
            "~svg": path.resolve(__dirname,"./resources/js/svg-files"),
            "~icons": path.resolve(__dirname,"./resources/js/svg-components"),
            "ziggy-js": path.resolve(__dirname,"./vendor/tightenco/ziggy/dist"),
            "ziggy": path.resolve(__dirname,"./vendor/tightenco/ziggy/dist/vue.es.js"),
            "~prims": path.resolve(__dirname,"./node_modules/prismjs/themes/prism.min.css"),
        }
    }
});
