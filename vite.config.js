import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    base: "/build/",
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        emptyOutDir: true,
        rollupOptions: {
            input: ["resources/css/app.css", "resources/js/app.js"],
            output: {
                entryFileNames: "[name].js",
                chunkFileNames: "[name].js",
                assetFileNames: "[name].[ext]",
            },
        },
    },
    server: {
        hmr: {
            host: "localhost",
        },
    },
});
