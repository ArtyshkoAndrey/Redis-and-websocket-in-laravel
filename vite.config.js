import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  resolve: {
    alias: {
      '@': 'resources/js',
    },
  },
  plugins: [
    vue(),
    laravel({
      input: [
        'resources/scss/app.scss',
        'resources/js/app.js',
      ],
      refresh: [
        'resources/scss/**',
        'routes/js/',
        'resources/views/**',
      ]
    }),
  ],
});
