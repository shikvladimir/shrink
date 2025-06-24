<script setup>
import { useLayout } from '@/layout/composables/layout';
import AppConfigurator from './AppConfigurator.vue';
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useLinkStore } from '@/stores/link';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
const toast = useToast();

import { useUserStore } from '@/stores/User';
import Devil from "@/components/svg/Devil.vue";
const userStore = useUserStore();

const { toggleMenu, toggleDarkMode, isDarkTheme } = useLayout();

const loginVisible = ref(false);
const registrVisible = ref(false);

const registrData = reactive({
    name: null,
    email: null,
    pass: null
});

const loginData = reactive({
    email: null,
    pass: null
});

const registr = () => {
    axios
        .post('/api/user/registr/', {
            name: registrData.name,
            email: registrData.email,
            pass: registrData.pass
        })
        .then(() => {
            useLinkStore().getLinks();
            registrVisible.value = false;
            registrData.name = null;
            registrData.email = null;
            registrData.pass = null;

            toast.add({ severity: 'info', summary: 'Отлично!', detail: 'Вы зарегистрированы!', life: 3000 });
        })
        .catch((err) => {
            Object.entries(err.response.data.errors).forEach((i) => {
                toast.add({ severity: 'error', summary: 'Упс!', detail: i[1][0], life: 3000 });
            });
        });
};

const login = async () => {
    try {
        await userStore.login(loginData);
        loginVisible.value = false;
    } catch (err) {
        console.log(err.response.data)

        if(err.response.data.errors) {
            Object.entries(err.response.data.errors).forEach((i) => {
                toast.add({ severity: 'error', summary: 'Упс!', detail: i[1][0], life: 3000 });
            });
        }else{
            toast.add({ severity: 'error', summary: 'Упс!', detail: err.response.data, life: 3000 });
        }

    }
};
</script>

<template>
    <Toast />
    <Dialog v-model:visible="loginVisible" modal header="Вход" :style="{ width: '25rem' }">
        <div class="flex items-center gap-8 mb-4">
            <label for="login" class="font-semibold w-24">Email</label>
            <InputText v-model="loginData.email" id="login" class="flex-auto" />
        </div>
        <div class="flex items-center gap-8 mb-8">
            <label for="pass" class="font-semibold w-24">Пароль</label>
            <Password v-model="loginData.pass" class="flex" id="pass" autocomplete="off" :feedback="false" toggleMask />
        </div>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Отмена" severity="secondary" @click="loginVisible = false"></Button>
            <Button type="button" label="Отправить" @click="login"></Button>
        </div>
    </Dialog>

    <Dialog v-model:visible="registrVisible" modal header="Регистрация" :style="{ width: '25rem' }">
        <div class="flex items-center gap-8 mb-4">
            <label for="name" class="font-semibold w-24">Имя</label>
            <InputText v-model="registrData.name" id="name" class="flex-auto" />
        </div>
        <div class="flex items-center gap-8 mb-4">
            <label for="email" class="font-semibold w-24">Email</label>
            <InputText v-model="registrData.email" id="email" class="flex-auto"/>
        </div>
        <div class="flex items-center gap-8 mb-8">
            <label for="pass" class="font-semibold w-24">Пароль</label>
            <Password v-model="registrData.pass" class="flex" id="pass" autocomplete="off" :feedback="false" toggleMask />
        </div>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Отмена" severity="secondary" @click="registrVisible = false"></Button>
            <Button type="button" label="Отправить" @click="registr"></Button>
        </div>
    </Dialog>

    <div class="layout-topbar">
        <div class="layout-topbar-logo-container">
            <!--            <button class="layout-menu-button layout-topbar-action" @click="toggleMenu">-->
            <!--                <i class="pi pi-bars"></i>-->
            <!--            </button>-->
            <router-link to="/" class="layout-topbar-logo">
                <Devil />

                <strong>EvilCut</strong>
            </router-link>
        </div>

        <div class="layout-topbar-actions">
            <div class="layout-config-menu">
                <button type="button" class="layout-topbar-action" @click="toggleDarkMode">
                    <i :class="['pi', { 'pi-moon': isDarkTheme, 'pi-sun': !isDarkTheme }]"></i>
                </button>
                <!--                <div class="relative">-->
                <!--                    <button-->
                <!--                        v-styleclass="{ selector: '@next', enterFromClass: 'hidden', enterActiveClass: 'animate-scalein', leaveToClass: 'hidden', leaveActiveClass: 'animate-fadeout', hideOnOutsideClick: true }"-->
                <!--                        type="button"-->
                <!--                        class="layout-topbar-action layout-topbar-action-highlight"-->
                <!--                    >-->
                <!--                        <i class="pi pi-palette"></i>-->
                <!--                    </button>-->
                <!--                    <AppConfigurator />-->
                <!--                </div>-->
            </div>

            <button
                class="layout-topbar-menu-button layout-topbar-action"
                v-styleclass="{ selector: '@next', enterFromClass: 'hidden', enterActiveClass: 'animate-scalein', leaveToClass: 'hidden', leaveActiveClass: 'animate-fadeout', hideOnOutsideClick: true }"
            >
                <i class="pi pi-ellipsis-v"></i>
            </button>

            <div class="layout-topbar-menu hidden lg:block">
                <div class="layout-topbar-menu-content">
                    <Button v-if="userStore.auth" label="Выход" @click="userStore.logout" text />
                    <Button v-if="!userStore.auth" label="Вход" @click="loginVisible = true" text />
                    <Button v-if="!userStore.auth" label="Регистрация" @click="registrVisible = true" text />

                    <div v-if="userStore.auth" type="button" class="mr-3 mt-[9px]">
                        <span>Привет, {{ userStore.user }}!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
