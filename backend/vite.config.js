import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],

  // Configure Vite's development server
  server: {
    host: '0.0.0.0',

    port: 5173,

    hmr: {
      host: 'localhost',
    },

    watch: {
      usePolling: true,
      ignored: ['**/vendor/**', '**/node_modules/**', '**/storage/**'],
    },
  },
});
