import { defineStore, acceptHMRUpdate } from 'pinia';
import axios from 'axios';

export const useLinkStore = defineStore('link', {
    state: () => ({
        links: []
    }),

    actions: {
        async getLinks() {
            try {
                const response = await axios.get('/api/link/get');
                this.links = response.data;
            } catch (err) {
                throw err.response.data;
            }
        }
    }
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useLinkStore, import.meta.hot));
}
