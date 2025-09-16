import { createApp } from 'vue'
import { createPinia } from 'pinia';
import App from './App.vue'
import router from './router'

import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import PrimeVue from 'primevue/config';
import '@/assets/styles.scss';
const app = createApp(App)
import Aura from '@primeuix/themes/aura';
app.use(router)
app.use(PrimeVue, {
  theme: {
        preset: Aura,
        options: {
            darkModeSelector: '.app-dark'
        }
    }
});
app.use(ToastService);
app.use(createPinia());
app.use(ConfirmationService);
app.mount('#app')

