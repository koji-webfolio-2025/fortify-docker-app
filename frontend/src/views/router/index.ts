import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../LoginView.vue'
import UserView from '../UserView.vue'
import axios from 'axios'

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: LoginView,
    },
    {
        path: '/user',
        name: 'User',
        component: UserView,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, _from, next) => {
    if (to.path === '/login') {
        next()
        return
    }
    try {
        await axios.get('/api/user')
        next()
    } catch {
        next('/login')
    }
})

export default router
