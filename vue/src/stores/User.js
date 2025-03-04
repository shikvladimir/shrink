import { defineStore, acceptHMRUpdate } from 'pinia';
import axios from 'axios';
const API_URL = 'http://127.0.0.1:8897';

axios.defaults.withCredentials = true;

export const useUserStore = defineStore('user', {
    state: () => ({
        user: null,
        authId: null,
        auth: false,
        token: null
    }),

    actions: {
        async login(credentials) {
            const response = await axios.post(`${API_URL}/api/user/login`, credentials);
            this.user = response.data.name;
            this.authId = response.data.authId;
            this.auth = response.data.auth;
        },

        async logout() {
            await axios.post(`${API_URL}/api/user/logout`);
            this.user = null;
            this.authId = null;
            this.auth = false;
        },

        async getUser() {
            try {
                // await axios.get(`${API_URL}/sanctum/csrf-cookie`);
                const response = await axios.get(`${API_URL}/api/user/get`);
                console.log(response.data);
                this.user = response.data.name;
                this.authId = response.data.authId;
                this.auth = response.data.auth;
                return response.data;
            } catch {
                return null;
            }
        }
    }
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot));
}
