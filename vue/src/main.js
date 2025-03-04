import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import { createPinia } from 'pinia';

import Aura from '@primeuix/themes/aura';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import '@/assets/styles.scss';
import Tooltip from 'primevue/tooltip';



const pinia = createPinia();
const app = createApp(App);

const API_URL = 'http://127.0.0.1:8897';
const UI_URL = 'http://127.0.0.1:5151';

app.provide('API_URL', API_URL);
app.provide('UI_URL', UI_URL);

axios.defaults.baseURL = API_URL;

app.use(router);
app.use(pinia);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: '.app-dark'
        }
    }
});
app.use(ToastService);
app.use(ConfirmationService);

app.component('Toast', Toast);
app.directive('tooltip', Tooltip);
app.mount('#app');

import { useUserStore } from '@/stores/User';
const userStore = useUserStore();
userStore.getUser().then((user) => {
    if (user) {
        userStore.user = user.name;
        userStore.authId = user.authId;
        userStore.auth = user.auth;
        console.log('Пользователь авторизован:');
    } else {
        console.log('Не авторизован');
    }
});
