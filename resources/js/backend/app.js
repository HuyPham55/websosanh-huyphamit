
import { createApp } from 'vue/dist/vue.esm-bundler';
import VueProductScrapeComponent from "@/backend/Components/VueProductScrapeComponent.vue";

let app = createApp({
    components: {
        VueProductScrapeComponent,
    },
});

app.mount("#app");
