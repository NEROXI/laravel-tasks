import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import * as path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            jquery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js'),
            vue: path.resolve(__dirname, 'node_modules/vue/dist/vue.esm-bundler.js'),
            moment: path.resolve(__dirname, 'node_modules/moment/moment.js'),
        },
    },
    global: {
        jquery: 'jQuery',
        vue: 'Vue',
        moment: 'moment',
    },
});
