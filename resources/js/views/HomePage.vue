<template>
    <main class="main-content">
        <div class="featured-categories">
            <ul class="featured-list">
                <li class="featured-item" v-for="category in computedCategories">
                    <router-link :to="{name: 'product_category', params: {id: category.id, slug: category.slug}}">
                        <img :src="category['icon']" alt=""/>
                        <span>
                            {{category['title']}}
                        </span>
                    </router-link>
                </li>
            </ul>
            <div id="slider" class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="slide in slides.data">
                        <a href="#" class="img-slider">
                            <img :src="slide.image" class="img-slider" alt="KidsMart">
                        </a>
                    </div>

                </div>
                <div class="nav-swiper swiper-button-next"></div>
                <div class="nav-swiper swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="product-box" v-for="category in featuredCategories.data">
            <div class="head">
                <h2 class="category-title">
                    <router-link :to="{name: 'product_category', params: {id: category.id, slug: category.slug}}">
                        {{ category['title'] }}
                    </router-link>
                </h2>
                <router-link class="more"
                             :to="{name: 'product_category', params: {id: category.id, slug: category.slug}}">
                    More
                    <i class="fal fa-fw fa-angle-right"></i>
                </router-link>
            </div>
            <div class="wrap">
                <div class="banner-wrap">
                    <a href="#" target="_blank">
                        <img :src="category.banner"/>
                    </a>
                </div>
                <ul class="product-list">
                    <template v-for="(item, index) in category['products']">
                        <li class="list-item" v-if="index < 8">
                            <a href="#">
                                <div class="item-image__container">
                                    <img :src="item['image']" :title="item['title']"/>
                                </div>
                                <h3 class="item-title">{{ item['title'] }}</h3>
                            </a>
                            <span class="item-price">{{ store.formatMoney(item['price']) }}</span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <div class="article-box">
            <h2 class="article-head">
                <a href="#">News</a>
            </h2>
            <div class="article-wrap">
                <div class="article-list">
                    <article class="article-item" v-for="item in featuredNews.data">
                        <a href="#" title="">
                            <span class="article-img">
                                <img :src="item['image']" alt="">
                            </span>
                            <h3 class="article-title">{{ item.title }}</h3>
                        </a>
                        <p class="article-desc">
                            {{ item['short_description'] }}
                        </p>
                    </article>
                </div>
                <div class="article-aside">
                    <div class="article-aside-container">
                        <article class="article-item" v-for="item in asideNews.data">
                            <a href="#" title="">
                        <span class="article-img">
                            <img :src="item.image" alt="">
                        </span>
                                <h3 class="article-title">{{ item.title }}</h3>
                            </a>
                            <p class="article-desc">
                                {{ item['short_description'] }}
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "HomePage"
}
</script>
<script setup>
import {computed, nextTick, onBeforeMount, onMounted, reactive, ref, watch} from "vue";
import {useLayoutStore} from "@/stores";

import {sessionCache} from "@/API/sessionCache";
const store = useLayoutStore()

const headerData = computed(() => store.layoutData.headerData);

const computedCategories = computed(() => headerData.value['menuItems'])


const slides = reactive({
    data: [],
    ready: false
})


const featuredCategories = reactive({
    data: [],
})

const featuredNews = reactive({
    data: [],
})
const asideNews = reactive({
    data: [],
})

let callback = (callbackData) => {
    slides.data = callbackData['slides'];
    featuredCategories.data = callbackData['featured_categories']
    asideNews.data = callbackData['aside_news']
    store.pageData.ready = true;
}

let useCache = true;

onBeforeMount(() => {
    fetchHomePage()
})

const fetchHomePage = async function () {
    let cacheKey = 'homeData';
    store.pageData.ready = false;
    if (sessionCache.has(cacheKey) && useCache) {
        let data = sessionCache.load(cacheKey);
        callback(data);
    } else {
        axios.post("/api/fetch-home-page")
            .then(res => {
                let data = res.data;
                callback(data);
                sessionCache.save(cacheKey, data)
            })
    }
}


watch(() => store.pageData.ready, (value) => {
    if (value) {
        nextTick(() => {
            //wait for Vue to render tags
            initializeSwiper();
        })
    }
}, {immediate: true})
const initializeSwiper = function () {
    let homeSlider = new Swiper('#slider', {
        slidesPerView: '1',
        autoplay: {
            delay: 5000,
        },
        speed: 1000,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
        },
    });
}

onMounted(() => {
})
</script>

<style scoped>

</style>
