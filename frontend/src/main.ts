import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './views/router'
import axios from 'axios'

window.axios = axios

//axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL
axios.defaults.baseURL = 'https://api.codeshift-lab.com'
axios.defaults.withCredentials = true //（クッキー送信）

const app = createApp(App)
app.use(router)
app.mount('#app')