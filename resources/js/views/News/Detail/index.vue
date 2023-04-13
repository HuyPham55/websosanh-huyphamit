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
                    <div class="slider-related swiper-container" hidden>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide product-item">
                                <a href="#">
                                    <span class="product-img">
                                        <img src="https://img.websosanh.vn/v2/users/root_product/images/loa-di-dong-bose-soundlink/nxq84fYaBYbY.jpg?compress=85&width=200"/>
                                    </span>
                                    <span class="product-action">So sánh giá</span>
                                    <h3>Loa di động Bose SoundLink Revolve</h3>
                                    <span class="product-meta">
                                        <span class="product-price">
                                            Giá từ 2.700.000 đ
                                        </span>
                                    </span>
                                    <span class="product-bottom">
                                        <span class="product-store">
                                            Nơi bán: Hà Nội, Toàn Quốc
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="swiper-slide product-item">
                                <a href="#">
                                    <span class="product-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/review/images/loa-tronsmart-t2-plus-thiet/g1kzd6yi49u40.jpg?compress=85&width=200"/>
                                    </span>
                                    <span class="product-action">So sánh giá</span>
                                    <h3>Loa di động Bose SoundLink Revolve</h3>
                                    <span class="product-meta">
                                        <span class="product-price">
                                            Giá từ 2.700.000 đ
                                        </span>
                                    </span>
                                    <span class="product-bottom">
                                        <span class="product-store">
                                            Nơi bán: Hà Nội, Toàn Quốc
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="swiper-slide product-item">
                                <a href="#">
                                    <span class="product-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/root_product/images/loa-di-dong-bose-soundlink/nxq84fYaBYbY.jpg?compress=85&width=200"/>
                                    </span>
                                    <span class="product-action">So sánh giá</span>
                                    <h3>Loa di động Bose SoundLink Revolve</h3>
                                    <span class="product-meta">
                                        <span class="product-price">
                                            Giá từ 2.700.000 đ
                                        </span>
                                    </span>
                                    <span class="product-bottom">
                                        <span class="product-store">
                                            Nơi bán: Hà Nội, Toàn Quốc
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="swiper-slide product-item">
                                <a href="#">
                                    <span class="product-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/review/images/danh-gia-loa-bluetooth-bose/6s8ddp58es0m3.jpg?compress=85&width=200"/>
                                    </span>
                                    <span class="product-action">So sánh giá</span>
                                    <h3>Loa di động Bose SoundLink Revolve</h3>
                                    <span class="product-meta">
                                        <span class="product-price">
                                            Giá từ 2.700.000 đ
                                        </span>
                                    </span>
                                    <span class="product-bottom">
                                        <span class="product-store">
                                            Nơi bán: Hà Nội, Toàn Quốc
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="swiper-slide product-item">
                                <a href="#">
                                    <span class="product-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/root_product/images/loa-di-dong-bose-soundlink/nxq84fYaBYbY.jpg?compress=85&width=200"/>
                                    </span>
                                    <span class="product-action">So sánh giá</span>
                                    <h3>Loa di động Bose SoundLink Revolve</h3>
                                    <span class="product-meta">
                                        <span class="product-price">
                                            Giá từ 2.700.000 đ
                                        </span>
                                    </span>
                                    <span class="product-bottom">
                                        <span class="product-store">
                                            Nơi bán: Hà Nội, Toàn Quốc
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="swiper-slide product-item">
                                <a href="#">
                                    <span class="product-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/root_product/images/loa-di-dong-bose-soundlink/nxq84fYaBYbY.jpg?compress=85&width=200"/>
                                    </span>
                                    <span class="product-action">So sánh giá</span>
                                    <h3>Loa di động Bose SoundLink Revolve</h3>
                                    <span class="product-meta">
                                        <span class="product-price">
                                            Giá từ 2.700.000 đ
                                        </span>
                                    </span>
                                    <span class="product-bottom">
                                        <span class="product-store">
                                            Nơi bán: Hà Nội, Toàn Quốc
                                        </span>
                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>
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

const route = useRoute();
const computedId = computed(() => route.params.id | 0)
const model = ref({})
const store = useLayoutStore();
const breadcrumb = reactive({
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
