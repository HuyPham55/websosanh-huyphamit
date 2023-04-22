<template>
    <main class="main-content article-wrap">
        <template v-if="store.pageData.ready">
            <ol class="breadcrumbs">
                <li>
                    <router-link :to="{name: 'home'}">Homepage</router-link>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li v-for="item in breadcrumb.data">
                    <router-link :to="{name: 'product_category', params: {id: item['id'], slug: item['slug']}}">
                        {{ item['title'] }}
                    </router-link>
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
                            {{ model['short_description'] }}
                        </h2>
                        <div class="article-content" v-html="model['content']">

                        </div>
                    </article>
                    <ProductSlider :ready="related.ready" :items="related.data"/>
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

const route = useRoute();
const computedId = computed(() => route.params.id | 0)
const model = ref({})
const store = useLayoutStore();
const breadcrumb = reactive({
    data: []
})

const related = reactive({
    ready: false,
    data: []
})

const fetchModelData = function () {
    store.pageData.ready = false;
    const id = computedId.value
    axios.post("/api/fetch-news-detail", {
        id,
    })
        .then(res => {
            let data = res.data.data;
            model.value = data['model'];
            breadcrumb.data = data['breadcrumb'];
            store.setDocumentTitle(model.value['title'])
            related.data = data['related'];
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
