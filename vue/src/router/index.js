import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import { inject } from "vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/views/Dashboard.vue')
                }
            ]
        },
        {
            path: '/:link',
            name: 'LinkCheck',
            beforeEnter: async (to, from, next) => {
                const API_URL = inject('API_URL');
                try {
                    const response = await axios.get(`${API_URL}/api/link/move/${to.params.link}`);
                    window.location.href = response.data;
                    next(false);
                } catch (error) {
                    next({ name: 'NotFound' });
                    console.error('Ошибка проверки ссылки:', error);
                }
            }
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'NotFound',
            component: () => import('@/views/pages/NotFound.vue')
        }
    ]
});

export default router;
