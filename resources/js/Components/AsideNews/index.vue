<template>
    <div class="article-sidebar">
        <article class="sidebar-item-wrap">
            <h5 class="article-sidebar-title">News</h5>
            <div class="article-sidebar-list">
                <article class="article-sidebar-item" v-for="post in asideItems.data">
                    <router-link
                        :to="{name: 'news_detail', params: {id: post.id, slug: post.slug}}"
                        :title="post.title">
                        <span class="article-sidebar-img">
                            <img :src="post.image" :alt="post.title">
                        </span>
                        <h3>{{ post.title }}</h3>
                    </router-link>
                </article>
            </div>
        </article>
    </div>
</template>

<script>
export default {
    name: "index"
}
</script>

<script setup>
import {onBeforeMount, reactive} from "vue";
import {fetchAsideNews} from "@/API/LayoutApis";

const asideItems = reactive({
    data: []
})

async function fetchNews() {
    asideItems.data = await fetchAsideNews();
}
onBeforeMount(() => {
    fetchNews();
})
</script>

<style scoped>

</style>
