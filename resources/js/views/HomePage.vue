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
                            <span class="item-price">{{ item['price'] }}</span>
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
                <article class="article-item">
                    <a href="#" title="">
                        <span class="article-img">
                            <img
                                src="https://img.websosanh.vn/v2/users/review/images/danh-gia-chi-tiet-ve-may-giat/hehu2j5aiekyb.jpg?compress=85&amp;width=390"
                                alt="">
                        </span>
                        <h3 class="article-title">Đánh giá chi tiết về máy giặt LG Inverter 9 kg fm1209s6w</h3>
                    </a>
                    <p class="article-desc">
                        Bạn có biết máy giặt LG Inverter 9kg fm1209s6w có tính năng gì nổi bật? Có nên mua máy giặt LG
                        Inverter 9kg fm1209s6w không và mức giá bán như thế nào?</p>
                </article>
                <article class="article-item">
                    <a href="#" title="">
                        <span class="article-img">
                            <img
                                src="https://img.websosanh.vn/v2/users/review/images/may-giat-lg-fv1410s5w-co-tot/rromn1f9puaug.jpg?compress=85&width=390"
                                alt="">
                        </span>
                        <h3 class="article-title">Đánh giá chi tiết về máy giặt LG Inverter 9 kg fm1209s6w</h3>
                    </a>
                    <p class="article-desc">
                        Bạn có biết máy giặt LG Inverter 9kg fm1209s6w có tính năng gì nổi bật? Có nên mua máy giặt LG
                        Inverter 9kg fm1209s6w không và mức giá bán như thế nào?</p>
                </article>
                <article class="article-item">
                    <a href="#" title="">
                        <span class="article-img">
                            <img
                                src="https://img.websosanh.vn/v2/users/review/images/quat-dieu-hoa-erito-eac-8000/aji4a6heomua7.jpg?compress=85&width=390"
                                alt="">
                        </span>
                        <h3 class="article-title">Đánh giá chi tiết về máy giặt LG Inverter 9 kg fm1209s6w</h3>
                    </a>
                    <p class="article-desc">
                        Bạn có biết máy giặt LG Inverter 9kg fm1209s6w có tính năng gì nổi bật? Có nên mua máy giặt LG
                        Inverter 9kg fm1209s6w không và mức giá bán như thế nào?</p>
                </article>
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
import {computed, nextTick, onBeforeMount, onMounted, reactive, watch} from "vue";
import {useLayoutStore} from "@/stores";

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

onBeforeMount(() => {
    fetchHomePage()
})

const fetchHomePage = async function () {
    slides.ready = false;
    axios.post("/api/fetch-home-page")
        .then(res => {
            let data = res.data;
            slides.data = data['slides'];
            slides.ready = true;
            featuredCategories.data = data['featured_categories']
        })
}


watch(() => slides.ready, () => {
    if (slides.ready) {
        nextTick(() => {
            //wait for Vue to render tags
            initializeSwiper();
        })
    }
})
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
