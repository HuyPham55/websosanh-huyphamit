import '@/styles/index.scss';

import './bootstrap';
import {createApp, h, onMounted} from 'vue';
import App from "@/App.vue";
import router from "@/router";
import {createPinia} from "pinia";
import LoadingComponent from "@/Components/LoadingComponent.vue";
import {useLayoutStore} from "@/stores";
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
const store = useLayoutStore()
router.beforeEach((to, from, next) => {
    store.layoutData.ready = false;
    next()
})
router.afterEach(() => {
    store.layoutData.ready = true;
})
app.mount("#app");
