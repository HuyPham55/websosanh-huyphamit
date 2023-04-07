<template>
    <main class="main-content products">
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
                    {{model['title']}}
                </li>
            </ol>
            <div class="page-wrap">
                <div class="product-title">
                    <h1 class="title">{{model['title']}}</h1>
                    <div class="price-title-box">
                        <div class="price-title">Price from: <span class="price-from">
                            {{store.formatMoney(model['price'])}}
                        </span>
                        </div>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-img-wrap">
                        <a href="" class="images">
                            <img id="zoom" :src="model['image']" alt="KidsMart">
                        </a>
                        <div class="thumbnails swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="thumbnail active" :data-image="model['image']">
                                        <img :src="model['image']" alt=""></div>
                                </div>
                            </div>
                            <div class="nav-swiper swiper-button-next"></div>
                            <div class="nav-swiper swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="product-container">
                        <ul class="store-suggest" v-if="featuredSellers.data.length">
                            <li class="store-suggest-item" v-for="(product) in featuredSellers.data">
                                <a class="store-item is-trusted">
                                <span class="store-suggest-logo">
                                    <img :src="product.seller.icon" alt="">
                                </span>
                                    <span class="store-suggest-price">
                                        {{store.formatMoney(product['price'])}}
                                    </span>
                                    <span class="store-suggest-view" @click="clickHandler(product)">
                                        To seller
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="product-short-description">

                        </div>
                    </div>
                </div>
                <div class="navigation-sticky">
                    <ol class="navigation-sticky-section">
                        <li><span class="scroll active" data-target="#scroll_2">Price comparison</span></li>
                        <li><span class="scroll" data-target="#specifications">Specification</span></li>
                    </ol>
                </div>
                <div class="product-single">
                    <div class="product-single-wrap">
                        <div class="compare-action" id="scroll_2">
                            <div class="compare-action-label">So sánh giá của <span class="total-result">194</span> nơi
                                bán
                            </div>
                            <div class="compare-action-wrap">
                                <div class="compare-action-item compare-sort-inner"><label>Sắp xếp theo:</label>
                                    <ul class="compare-action-parent">
                                        <li>
                                            <span class="compare-action-text">Nổi bật</span>
                                            <ul class="compare-action-child" tabindex="3">
                                                <li data-sort="0" data-text="Nổi bật" class="active">Nổi bật</li>
                                                <li data-sort="1" data-text="Giá tăng dần">Giá tăng dần</li>
                                                <li data-sort="2" data-text="Giá giảm dần">Giá giảm dần</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <ul class="compare-wrap">
                            <li class="compare-item" v-for="seller in computedSellers">
                                <div class="compare-merchant">
                                <span class="compare-logo">
                                    <img
                                        src="https://img.websosanh.vn/v2/users/logo/images/owrpstn9b8xrs?compress=85&amp;width=110&amp;height=40"
                                        alt="galaxydidong.vn">
                                </span>
                                    <span class="compare-name">galaxydidong.vn</span>
                                </div>
                                <div class="compare-item-wrap">
                                    <div class="compare-item-container">
                                        <div class="compare-info">
                                            <h3 class="compare-product-title">
                                                <a class="store-item is-trusted"
                                                   href="/iphone-11-pro-64gb-quoc-te-likenew-99-cu-95/7584681155189959185/2495542234818888352/direct.htm"
                                                   target="_blank" rel="nofollow">
                                                    Iphone 11 Pro 64Gb Quốc Tế LikeNew 99% Cũ 95%
                                                </a>
                                            </h3>
                                            <div class="compare-product-store">Nơi bán: Toàn Quốc, Hà Nội</div>
                                        </div>
                                        <div class="compare-market">
                                            <div class="compare-product-price">7.650.000 đ</div>
                                            <div class="compare-product-vat">(+VAT) 8.415.000 đ</div>
                                            <div class="compare-product-shipping">
                                                <i class="fa fa-star"></i> Mua ở đây sản phẩm chất lượng
                                            </div>
                                        </div>
                                        <div class="compare-button">
                                            <a class="compare-product-view"
                                               href="/iphone-11-pro-64gb-quoc-te-likenew-99-cu-95/7584681155189959185/2495542234818888352/direct.htm"
                                               target="_blank" rel="nofollow">
                                                To seller
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="pagination">
                            <li><a data-page-index="1" data-page="1" rel="nofollow" class="active">1</a></li>
                            <li><a data-page-index="2" data-page="2" rel="nofollow">2</a></li>
                            <li><a data-page-index="3" data-page="3" rel="nofollow">3</a></li>
                            <li><a data-page-index="4" data-page="4" rel="nofollow">4</a></li>
                            <li><a data-page-index="5" data-page="5" rel="nofollow">5</a></li>
                            <li><a data-page-index="2" data-page="2" class="next" title="Trang tiếp"
                                   rel="nofollow">›</a>
                            </li>
                            <li><a data-page-index="20" data-page="20" class="last" title="Trang cuối"
                                   rel="nofollow">»</a>
                            </li>
                        </ul>
                        <h2 class="title-section">
                            <span>Specification for: {{model['title']}}</span>
                        </h2>
                        <div class="product-specification" id="specifications" v-html="model['content']">
                        </div>
                    </div>
                    <div class="product-single-sidebar">
                        <article class="product-sidebar-item">
                            <h5 class="article-sidebar-title">Tin tức về sản phẩm</h5>
                            <div class="article-sidebar-list">
                                <article class="article-sidebar-item">
                                    <a href="" title="">
                                    <span class="article-sidebar-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/review/images/iphone-11-pro-max-cu-gia-bao/ha7p19c7vpnup.jpg?compress=85&amp;width=200">
                                    </span>
                                        <h3>iPhone 11 Pro Max cũ giá bao nhiêu? Có nên mua năm 2022?</h3>
                                    </a>
                                </article>
                                <article class="article-sidebar-item">
                                    <a href="" title="">
                                    <span class="article-sidebar-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/review/images/iphone-11-pro-max-cu-gia-bao/ha7p19c7vpnup.jpg?compress=85&amp;width=200">
                                    </span>
                                        <h3>iPhone 11 Pro Max cũ giá bao nhiêu? Có nên mua năm 2022?</h3>
                                    </a>
                                </article>
                                <article class="article-sidebar-item">
                                    <a href="" title="">
                                    <span class="article-sidebar-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/review/images/iphone-11-pro-max-cu-gia-bao/ha7p19c7vpnup.jpg?compress=85&amp;width=200">
                                    </span>
                                        <h3>iPhone 11 Pro Max cũ giá bao nhiêu? Có nên mua năm 2022?</h3>
                                    </a>
                                </article>
                                <article class="article-sidebar-item">
                                    <a href="" title="">
                                    <span class="article-sidebar-img">
                                        <img
                                            src="https://img.websosanh.vn/v2/users/review/images/iphone-11-pro-max-cu-gia-bao/ha7p19c7vpnup.jpg?compress=85&amp;width=200">
                                    </span>
                                        <h3>iPhone 11 Pro Max cũ giá bao nhiêu? Có nên mua năm 2022?</h3>
                                    </a>
                                </article>
                            </div>
                        </article>

                    </div>
                </div>
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
import {useRoute} from 'vue-router';
import {computed, nextTick, onBeforeMount, onMounted, reactive, ref, watch} from "vue";
import {useLayoutStore} from "@/stores";
import {useProductStore} from "@/stores";


const productStore = useProductStore();
const readyStatus = ref(false);
const store = useLayoutStore();
const route = useRoute();
const breadcrumb = reactive({
    data: []
})
const computedId = computed(() => route.params.id | 0)
const model = ref({})
const featuredSellers = reactive({
    data: []
})

const sellers = reactive({
    data: []
})

const computedSellers = computed(() => {
    let result = sellers.data;
    return result;
})

const fetchModelData = function () {
    store.pageData.ready = false;
    const id = computedId.value
    axios.post("/api/fetch-comparison-data", {
        id,
    })
        .then(res => {
            let data = res.data.data;
            model.value = data['model'];
            breadcrumb.data = data['breadcrumb'];
            let allSellers = data['featuredSellers'];
            featuredSellers.data = allSellers.slice(0, 4);
        }).finally(() => {
        store.pageData.ready = true;
    })
}

const clickHandler = function(item) {
    let id = item.id;
    productStore.getProductUrl(id);
}
watch(()=> store.pageData.ready, () => {
    if (store.pageData.ready) {
        nextTick(() => {
            //wait for Vue to render tags
            initializeSwiper();
        })
    }
})

const getComparisonSellers = function () {
    const id = computedId.value
    axios.post("/api/get-comparison-sellers", {
        id,
    })
        .then(res => {
            store.pageData.ready = true;
            let data = res.data.data;
            sellers.data = data['sellers'];
        }).finally(() => {
    })
}

const initializeSwiper = function () {
    var thumb = new Swiper('.thumbnails', {
        slidesPerView: 4,
        spaceBetween: 10,
        rewind: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    let thumbnails = document.querySelectorAll(".thumbnail");
    thumbnails.forEach(item => {
        item.addEventListener("click", function () {
            let image = this.attributes['data-image'].value;
            let imageEl = document.querySelector(".images img");
            imageEl.src = image;
            if (!this.classList.contains('active')) {
                thumbnails.forEach(siblings => siblings.classList.remove('active'))
                this.classList.add("active")
            }
        })
    })
}
onBeforeMount(() => {
    fetchModelData();
})
onMounted(() => {
    getComparisonSellers()
})
</script>

<style scoped>

</style>
