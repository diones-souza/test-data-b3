import { createRouter, createWebHistory } from 'vue-router'
import HomeScreen from '../views/HomeScreen.vue'

const router = createRouter({
    history: createWebHistory('/'),
    routes: [
        {
            path: '/dashbord',
            name: 'Dashboard',
            component: HomeScreen
        },
    ]
})

export default router
