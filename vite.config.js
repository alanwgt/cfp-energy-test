import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    optimizeDeps: {
        esbuildOptions: {
            jsx: 'automatic',
        },
    },
    esbuild: {
        jsxInject: 'import React from "react";',
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
