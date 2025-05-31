import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    proxy: {
      // APIリクエストを8080に転送
      '^/(login|logout|sanctum|api)': {
        target: 'http://153.126.164.246:8080',
        changeOrigin: true,
        // secure: false, // httpsの場合
        // rewrite: path => path.replace(/^\/api/, '')
      }
    }
  }
})
