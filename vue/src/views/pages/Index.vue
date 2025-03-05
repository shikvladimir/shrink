<script setup>
import { computed, ref, inject } from 'vue';
import axios from 'axios';
axios.defaults.withCredentials = true;
import Toast from 'primevue/toast';

import { useRoute } from 'vue-router';
const route = useRoute();

import { useUserStore } from '@/stores/User';
const userStore = useUserStore();

import { useConfirm } from 'primevue/useconfirm';
const confirm = useConfirm();

import { useToast } from 'primevue/usetoast';
const toast = useToast();

import { useCopy } from '@/composables/copy';
const { copy } = useCopy();

import { useLinkStore } from '@/stores/link';
const store = useLinkStore();

const link = ref(null);
const name = ref(null);
const visible = ref(false);
const editData = ref(null);
const links = computed(() => store.links);
const API_URL = inject('API_URL');
const UI_URL = inject('UI_URL');

const addLink = () => {
    axios
        .post('/api/link/store', {
            link: link.value,
            name: name.value
        })
        .then(() => {
            useLinkStore().getLinks();
            link.value = null;
            toast.add({ severity: 'success', summary: 'Отлично!', detail: 'Ссылка создана', life: 3000 });
        })
        .catch((err) => {
            console.log(err);
            Object.entries(err.response.data.errors).forEach((i) => {
                toast.add({ severity: 'error', summary: 'Упс!', detail: i[1][0], life: 3000 });
            });
        });
};

const confirmDelete = (event, alias) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Вы действительно хотите удалить ссылку?',
        icon: 'pi pi-info-circle',
        rejectProps: { label: 'Отмена', severity: 'secondary', outlined: true },
        acceptProps: { label: 'Удалить', severity: 'danger' },
        accept: () => {
            axios
                .delete('/api/link/delete/' + alias)
                .then(() => {
                    useLinkStore().getLinks();
                    link.value = null;
                    toast.add({ severity: 'info', summary: 'Отлично!', detail: 'Ссылка удалена!', life: 3000 });
                })
                .catch((err) => {
                    console.log(err.data);
                });
        }
    });
};

const editLink = (data) => {
    visible.value = true;
    editData.value = data;
};

const updateLink = () => {
    axios
        .put('/api/link/update/', {
            alias: editData.value.alias,
            link: editData.value.link,
            name: editData.value.name
        })
        .then(() => {
            useLinkStore().getLinks();
            visible.value = false;
            editData.value = null;
            toast.add({ severity: 'info', summary: 'Отлично!', detail: 'Ссылка обновлена!', life: 3000 });
        })
        .catch((err) => {
            console.log(err.data);
        });
};

const truncate = (str) => (str?.length > 50 ? str.slice(0, 47) + '...' : str);

const checkAndRedirect = (link) => {
    axios
        .get(`${API_URL}/api/link/move/${link}`)
        .then((response) => {
            window.open(response.data, '_blank');
        })
        .catch((err) => {
            route.name({ name: 'NotFound' });
            console.error('Ошибка проверки ссылки:', err);
        });
};
</script>

<template>
    <Toast />
    <ConfirmPopup></ConfirmPopup>
    <Dialog v-model:visible="visible" modal header="Редактировать ссылку" :style="{ width: '50rem' }">
        <div class="items-center gap-4 mb-3">
            <label for="link" class="font-semibold w-24">Название</label>
            <InputText v-model="editData.name" id="link" class="flex-auto w-full" autocomplete="off" />
        </div>
        <div class="items-center gap-4 mb-8">
            <label for="link" class="font-semibold w-24">Ссылка</label>
            <InputText v-model="editData.link" id="link" class="flex-auto w-full" autocomplete="off" />
        </div>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Отмена" severity="secondary" @click="visible = false" />
            <Button type="button" label="Сохранить" @click="updateLink" />
        </div>
    </Dialog>
    <h1 class="text-center">Линкуй и сокращай</h1>
    <div v-if="userStore.auth" class="card">
        <InputText class="w-full mr-5 mb-3" size="small" type="text" v-model="name" placeholder="Введите название" />
        <InputText class="w-full mr-5 mb-5" type="text" v-model="link" placeholder="Введите ссылку" />
        <Button class="mb-5 w-full" @click="addLink">
            <span>Let's Go</span>
            <i class="pi pi-arrow-right"></i>
        </Button>
    </div>

    <div v-if="!links" class="text-center mt-20 mx-5">
        <h5 class="outline-1 outline-offset-2 outline-dashed p-10">Войдите или зарегистрируйтесь что бы сократить свою ссылку</h5>
    </div>

    <div v-for="link in links" :key="link.id" class="relative card flex flex-column !mb-6 !py-7">
        <span class="absolute top-[0px] text-[12px] underline" v-tooltip.top="link.name">{{ truncate(link?.name) }}</span>
        <div class="relative flex justify-between w-full items-center flex-wrap">
            <b class="flex items-center cursor-pointer">
                <span class="rounded-full text-xs bg-blue-300 h-[20px] w-[20px] text-white flex items-center justify-center mr-1">{{ link.clicks }}</span>
                <span @click="checkAndRedirect(link.alias)">{{ UI_URL + '/' + link.alias }}</span>
            </b>
            <div class="flex absolute right-0 top-4 lg:top-[-5px]">
                <div v-if="link.user_id === userStore.authId">
                    <Button v-if="userStore.auth" icon="pi pi-pen-to-square" @click="editLink(link)" severity="secondary" text />
                    <Button v-if="userStore.auth" icon="pi pi-trash" @click="confirmDelete($event, link.alias)" severity="secondary" text />
                </div>
                <Button icon="pi pi-copy" @click="copy(UI_URL + '/' + link.alias)" severity="secondary" text />
            </div>
        </div>
        <span class="absolute bottom-[0px] left-[50px] text-[12px]"
            >Автор: <b>{{ truncate(link.user?.name) }}</b></span
        >
    </div>
</template>

<style scoped lang="scss"></style>
