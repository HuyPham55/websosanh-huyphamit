import '@/styles/index.scss';

import './bootstrap';
import {createApp, h, onMounted} from 'vue';
import App from "@/App.vue";
import router from "@/router";
import {createPinia} from "pinia";
import LoadingComponent from "@/Components/LoadingComponent.vue";
const pinia = createPinia()

let app = createApp({
    router,
    render: function () {
        return h(App);
    }
})
app.component('LoadingComponent', LoadingComponent);
app.use(router);
app.use(pinia)
app.mount("#app");
