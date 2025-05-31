import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './views/router'
import axios from 'axios'

axios.defaults.baseURL = '/'
axios.defaults.withCredentials = true //（クッキー送信）

const app = createApp(App)
app.use(router)
app.mount('#app')