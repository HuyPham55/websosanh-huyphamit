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
                            <img id="zoom" :src="model['image']" alt="">
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
                                    <img :src="product.seller.icon || product.seller.image" alt="">
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
                        <li>
                            <span :class="{'scroll': 1, 'active': activeRef === 'sellerSection'}"
                                  @click="scrollToRef(sellerSection, 'sellerSection')">
                                Price comparison
                            </span>
                        </li>
                        <li>
                            <span :class="{'scroll': 1, 'active': activeRef === 'specificationSection'}"
                                  @click="scrollToRef(specificationSection, 'specificationSection')">
                                Specification
                            </span>
                        </li>
                    </ol>
                </div>
                <div class="product-single">
                    <div class="product-single-wrap">
                        <div class="compare-action" ref="sellerSection">
                            <div class="compare-action-label">Price comparison for <span class="total-result">
                                {{model['products_count']}}
                            </span> merchant{{model['product_count']<=1?'':'s'}}
                            </div>
                            <div class="compare-action-wrap">
                                <div class="compare-action-item compare-sort-inner">
                                    <label>Sort by:</label>
                                    <ul class="compare-action-parent">
                                        <li>
                                            <span class="compare-action-text" @click="toggleSellerSelect(true)">
                                                {{computedSortingTitle}}
                                            </span>
                                            <ul class="compare-action-child" tabindex="3" @blur="toggleSellerSelect(false)" :hidden="!sellerSelectActiveStatus">
                                                <li v-for="option in sortingOptions"
                                                    :class="{'active': option.value === sellers.sortBy}"
                                                    @click="changeSorting(option.value)">
                                                    {{option.title}}
                                                </li>
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
                                    <img :src="seller.image" :alt="seller.title">
                                </span>
                                    <span class="compare-name">
                                        {{seller.title}}
                                    </span>
                                </div>
                                <div class="compare-item-wrap">
                                    <div class="compare-item-container">
                                        <div class="compare-info">
                                            <h3 class="compare-product-title">
                                                <a class="store-item is-trusted" href="#"
                                                   @click.prevent="sellerClickHandler(seller['product_id'])">
                                                    {{seller['product_name']}}
                                                </a>
                                            </h3>
                                            <div class="compare-product-store">Nơi bán: Toàn Quốc, Hà Nội</div>
                                        </div>
                                        <div class="compare-market">
                                            <div class="compare-product-price">
                                                {{store.formatMoney(seller['price'])}}
                                            </div>
                                            <div class="compare-product-vat"></div>
                                            <div class="compare-product-shipping">
                                                <i class="fa fa-star"></i>
                                                Mua ở đây sản phẩm chất lượng
                                            </div>
                                        </div>
                                        <div class="compare-button">
                                            <a class="compare-product-view" rel="nofollow"
                                               @click="sellerClickHandler(seller['product_id'])">
                                                To seller
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <Pagination :total="paginationData.total"
                                    :perPage="paginationData.per_page"
                                    :ready="sellers.ready"
                                    :currentPage="paginationData.current_page"
                                    @changePage="changePage"/>
                        <h2 class="title-section">
                            <span>Specification for: {{model['title']}}</span>
                        </h2>
                        <LoadingComponent
                            :useCircle="false"
                            :ready="sellers.ready"
                            :style="preloaderStyle"/>
                        <div class="product-specification" ref="specificationSection" v-html="model['content']">
                        </div>
                    </div>
                    <div class="product-single-sidebar" hidden>
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
import Pagination from "@/layout/Pagination/index.vue";
const preloaderStyle = {
    width: "-webkit-fill-available",
    position: "absolute",
    transition: "all 0.75",
    'z-index': '1',
}

const sellerSection = ref(null);
const specificationSection = ref(null);
const productStore = useProductStore();
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

const activeRef = ref('sellerSection')

const sortingOptions = [
    {
        value: 'sorting-asc',
        title: 'Default'
    },
    {
        value: 'price-asc',
        title: 'Lowest price first'
    },
    {
        value: 'sorting-desc',
        title: 'Highest price first'
    }
]

const computedSortingTitle = computed(() =>
    sortingOptions.find(item => item.value === sellers.sortBy).title
)

const sellers = reactive({
    data: [],
    ready: false,
    sortBy: sortingOptions[0].value,
})

const sellerSelectActiveStatus = ref(false)
function changeSorting(value) {
    sellers.sortBy = value
    getComparisonSellers(1);
    sellerSelectActiveStatus.value = false;
    scrollToRef(sellerSection.value)
}


function toggleSellerSelect(value) {
    sellerSelectActiveStatus.value = value;
}

const paginationData = reactive({
    current_page: 1,
    per_page: 0,
    total: 0,
})

function changePage(page) {
    getComparisonSellers(page);
}

const computedSellers = computed(() => {
    let result = sellers.data;
    const mapper = (item) => {
        return {
            image: item["seller"].icon || item["seller"].image,
            title: item["seller"].title,
            price: item["price"],
            product_name: item['title'],
            product_id: item['id']
        };
    }
    result = result.map(mapper)
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

const getComparisonSellers = function (page = 1) {
    sellers.ready = false;
    const id = computedId.value
    let data = {
        id,
        sortBy: sellers.sortBy
    }

    if (page !== paginationData.current_page) {
        data['page'] = page;
    }
    axios.post("/api/get-comparison-sellers", data)
        .then(res => {
            store.pageData.ready = true;
            let data = res.data.data;
            sellers.data = data['sellers']['data'];
            let meta = data['sellers']['meta'];
            paginationData.current_page = meta['current_page'];
            paginationData.total = meta['total'];
            paginationData.per_page = meta['per_page'];
        }).finally(() => {
            sellers.ready = true;
    })
}

function sellerClickHandler(id) {
    productStore.getProductUrl(id);
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

const scrollToRef = function(ref, refName = null) {
    let position = ref.scrollHeight;
    if (refName) {
        activeRef.value = refName
    }
    window.scrollTo({top: position, behavior: 'smooth'});
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
