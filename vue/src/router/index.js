import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

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
                },
                {
                    path: '/:alias',
                    name: 'check-link',
                    beforeEnter: async (to, from, next) => {
                        try {
                            const response = await axios.get(`http://127.0.0.1:8897/api/link/move/${to.params.alias}`);
                            window.location.href = response.data;
                            next(false);
                        } catch (error) {
                            next({ name: "NotFound" });
                        }
                    }
                }
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'NotFound',
            component: () => import('@/views/pages/NotFound.vue')
        }
    ]
});

export default router;
