<script setup>
import { computed, ref, inject } from 'vue';
import axios from 'axios';
axios.defaults.withCredentials = true;
import Toast from 'primevue/toast';

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
const visible = ref(false);
const editData = ref(null);
const links = computed(() => store.links);
const API_URL = inject('API_URL');

const addLink = () => {
    axios
        .post('/api/link/store', {
            link: link.value
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
            link: editData.value.link
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
</script>

<template>
    <Toast />
    <ConfirmPopup></ConfirmPopup>
    <Dialog v-model:visible="visible" modal header="Редактировать ссылку" :style="{ width: '50rem' }">
        <div class="items-center gap-4 mb-8">
            <label for="link" class="font-semibold w-24">Ссылка</label>
            <InputText v-model="editData.link" id="link" class="flex-auto w-full" autocomplete="off" />
        </div>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Отмена" severity="secondary" @click="visible = false" />
            <Button type="button" label="Сохранить" @click="updateLink" />
        </div>
    </Dialog>
    <div v-if="userStore.auth" class="card">
        <InputText class="w-full mr-5 mb-5" type="text" v-model="link" placeholder="Введите ссылку" />
        <Button class="mb-5 w-full" @click="addLink">
            <span>Let's Go</span>
            <i class="pi pi-arrow-right"></i>
        </Button>
    </div>

    <div v-for="link in links" :key="link.id" class="card flex flex-column !mb-2 !py-3">
        <div class="relative flex justify-between w-full items-center flex-wrap">
            <b class="flex items-center cursor-pointer">
                <span class="rounded-full bg-blue-300 h-[20px] w-[20px] text-white flex items-center justify-center mr-1">{{ link.clicks }}</span>
                <a :href="API_URL + '/' + link.alias" target="_blank">{{ API_URL + '/' + link.alias }}</a>
            </b>
            <div class="flex">
                <div v-if="link.user_id === userStore.authId">
                    <Button v-if="userStore.auth" icon="pi pi-pen-to-square" @click="editLink(link)" severity="secondary" text />
                    <Button v-if="userStore.auth" icon="pi pi-trash" @click="confirmDelete($event, link.alias)" severity="secondary" text />
                </div>
                <Button icon="pi pi-copy" @click="copy(API_URL + '/' + link.alias)" severity="secondary" text />
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss"></style>
