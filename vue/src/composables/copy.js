import { copyText } from 'vue3-clipboard';
import { useToast } from 'primevue/usetoast';

export function useCopy() {
    const toast = useToast();

    const copy = (str) => {
        copyText(str, undefined, () => {
            toast.add({ severity: 'info', summary: 'Отлично!', detail: 'Данные скопированы', life: 3000 });
        });
    };
    return { copy };
}
