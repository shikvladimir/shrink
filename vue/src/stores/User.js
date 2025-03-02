import { defineStore, acceptHMRUpdate } from 'pinia';
import axios from 'axios';

export const useUserStore = defineStore('user', {
    state: () => ({
        user: null,
        auth: false,
        token: null
    }),

    actions: {
        async login(credentials) {
            try {
                const response = await axios.post('/api/user/login/', credentials);

                this.user = response.data.name;
                this.auth = response.data.auth;
                this.token = response.data.token;
                localStorage.setItem('token', this.token);
                this.setAxiosToken();
            } catch (err) {
                throw err.response.data;
            }
        },

        setAxiosToken() {
            if (this.token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            }
        },

        async logout() {
            try {
                await axios.post('/api/user/logout');
                this.forgetAuth();
            } catch (error) {
                console.log(error);
                if (error.response.status === 401) {
                    this.forgetAuth();
                }
                throw new Error('Ошибка logout');
            }
        },

        forgetAuth() {
            this.token = null;
            this.user = null;
            this.auth = false;
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        }
    }
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot));
}
