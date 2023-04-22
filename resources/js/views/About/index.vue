<template>
    <main class="main-content article-wrap">
        <template v-if="store.pageData.ready">
            <ol class="breadcrumbs">
                <li>
                    <router-link :to="{name: 'home'}">Homepage</router-link>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    {{ model['title'] }}
                </li>
            </ol>
            <div class="page-wrap">
                <div class="article-container">
                    <article>
                        <h1 class="title">
                            {{ model['title'] }}
                        </h1>
                        <p class="article-meta">
                            {{model['created_at']}}
                        </p>
                        <h2 class="article-description">
                            {{ model['seo_description'] }}
                        </h2>
                        <div class="article-content" v-html="model['content']">
                        </div>
                        <NewsSlider :items="related.data" :ready="related.ready"/>
                    </article>
                </div>
                <AsideNews/>
            </div>
        </template>
    </main>
</template>

<script>
export default {
    name: "index"
}
</script>

<script setup>
import AsideNews from "@/Components/AsideNews/index.vue";
import {computed, onBeforeMount, reactive, ref} from "vue";
import {useLayoutStore} from "@/stores";
import {useRoute} from "vue-router";
import ProductSlider from "@/views/Product/components/ProductSlider.vue";
import NewsSlider from "@/Components/NewsSlider.vue";

const model = ref({})
const store = useLayoutStore();

const related = reactive({
    ready: false,
    data: []
})

const fetchModelData = function () {
    store.pageData.ready = false;
    axios.post("/api/get-about-page", {
    })
        .then(res => {
            let data = res.data.data;
            store.setDocumentTitle(model.value['title'])
            model.value = data['model'];
            related.data = data['related']['data'];
            related.ready = true;
        }).finally(() => {
        store.pageData.ready = true;
    })
}

onBeforeMount(() => {
    fetchModelData();
})
</script>

<style scoped>

</style>
