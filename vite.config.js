import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    optimizeDeps: {
        esbuildOptions: {
            jsx: 'automatic',
        },
    },
    esbuild: {
        jsxInject: 'import React from "react";'
    },
    plugins: [
        laravel({
            input: ['resources/js/index.jsx'],
            refresh: true,
        }),
    ],
    server: {
        host: true,
    },
});
