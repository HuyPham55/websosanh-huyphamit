<template>
    <main class="main-content product-category" v-if="readyStatus">
        <ol class="breadcrumbs">
            <li>
                <router-link :to="{name: 'home'}">Homepage</router-link>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="https://websosanh.vn/dien-lanh/cat-1867.htm">
                    {{category['title']}}
                </a>
            </li>
        </ol>
        <div class="page-wrap">
            <div class="page-sidebar">
                <div class="page-sidebar-item sidebar-menu" v-if="children.data.length">
                    <div class="sidebar-menu-title">
                        {{category['title']}}
                    </div>
                    <ol class="sidebar-menu-wrap" tabindex="0">
                        <li class="has-children" v-for="item in children.data">
                            <router-link :to="{name: 'product_category', params: {id: item['id'], slug: item['slug']}}">
                                {{item['title']}}
                            </router-link>
                        </li>
                    </ol>
                </div>
                <div class="sidebar-filter">
                    <div class="sidebar-filter-title">Filter</div>
                    <Form class="filter-wrap" @submit="">
                        <div class="filter-item" v-if="computedSellers.data.length">
                            <div class="filter-title">Seller</div>
                            <div class="filter-choose">
                                <div class="filter-search">
                                    <input class="filter-box-input" name="li-merchant-list" placeholder="Store">
                                    <span class="filter-search-icon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                                <ol class="filter-list li-merchant-list">
                                    <li v-for="seller in computedSellers.data"
                                        class="filter-list-item filter-list-merchant-item merchant-filter">
                                        <label class="filter-label">
                                            <Field type="radio" name="seller" v-model.number="filterData.seller" :value="seller.id" @change="filterProduct"/>
                                            <span class="filter-radio"></span>
                                            <span class="filter-name">{{seller['title']}}</span>
                                        </label>
                                        <span class="filter-count">130.032</span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <div class="filter-item filter-slide filter-box-price">
                            <div class="filter-title">{{ "Price" }}</div>
                            <div class="filter-slide-wrap">
                                <div class="filter-slide-item filter-price">
                                    <div class="input-slide-wrap">
                                        <Field type="range" class="range" max="200000000" step="10000"
                                               v-model.number="filterData.min_price" name="min_price" @change="filterProduct"/>
                                    </div>
                                    <div class="input-slide-wrap">
                                        <Field type="range" class="range" max="200000000" step="10000"
                                               v-model.number="filterData.max_price" name="max_price"  @change="filterProduct"/>
                                    </div>
                                    <div class="filter-slide-amount">
                                        <span>{{store.formatMoney(filterData.min_price)}}</span>
                                        <span>{{store.formatMoney(filterData.max_price)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
            <div class="page-container">
                <div class="page-header">
                    <div class="page-text">
                        <h1 class="title">{{category['title']}}</h1> | Has <transition name="fade-transform"><b class="total">{{total}}</b></transition> products
                    </div>
                    <div class="sort-wrap">
                        <select class="sorting" title="" v-model="filterData.sorting" @change="filterProduct">
                            <option value="_score-asc">Relevance</option>
                            <option value="price-desc">Highest price first</option>
                            <option value="price-asc">Lowest price first</option>
                            <option value="hits-desc">Most viewed</option>
                        </select>
                    </div>
                </div>
                <div class="list-product">
                    <ProductList :items="products.data"/>
                    <ul class="pagination">
                        <li><a href="" class="active">1</a></li>
                        <li><a href="" >2</a>
                        </li>
                        <li><a href="https://websosanh.vn/s/máy+giặt+toshiba+8.5.htm?pi=3" >3</a>
                        </li>
                        <li><a href="https://websosanh.vn/s/máy+giặt+toshiba+8.5.htm?pi=4">4</a>
                        </li>
                        <li><a href="https://websosanh.vn/s/máy+giặt+toshiba+8.5.htm?pi=5">5</a>
                        </li>
                        <li><a href="https://websosanh.vn/s/máy+giặt+toshiba+8.5.htm?pi=2">›</a></li>
                        <li><a href="https://websosanh.vn/s/máy+giặt+toshiba+8.5.htm?pi=18">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="desc-wrap">
            <div class="desc-content" v-html="category['content']">

            </div>
        </div>
    </main>
</template>

<script setup>
import {computed, onBeforeMount, onMounted, reactive, ref, watch} from "vue";
import { useRoute } from 'vue-router';
import {useLayoutStore} from "@/stores";
import ProductList from "@/views/Product/components/ProductList/index.vue";
import {Form, Field} from "vee-validate";
const store = useLayoutStore();
const route = useRoute();
const computedId = computed(() => route.params.id | 0)
const readyStatus = ref(false);

const category = ref(null);

const children = reactive({
    data: [],
})

const computedSellers = reactive({
    data: [],
})

const products = reactive({
    data: []
})

const total = ref(0);
const fetchCategoryData = function () {
    readyStatus.value = false;
    const id = computedId.value
    axios.post("/api/fetch-product-category", {
        id,
    })
        .then(res => {
            readyStatus.value = true;
            let data = res.data;
            category.value = data['category'];
            children.data = data['children'];
            products.data = data['products']['data'];
            total.value = data['total'];
            computedSellers.data = data['sellers'];
        })
}

const filterData = reactive({
    min_price: 0,
    max_price: 200000000,
    seller: null,
    sorting: '_score-asc'
})

watch(() => filterData.max_price, (newValue, oldValue) => {
    if (newValue <= filterData.min_price && newValue > 0) {
        filterData.min_price = newValue - 1
    }
})

watch(() => filterData.min_price, (newValue, oldValue) => {
    if (newValue >= filterData.max_price) {
        filterData.max_price = newValue + 1;
    }
})

const filterProduct = function() {
    let data = {}
    data.category = computedId.value;

    if (filterData.min_price) {
        data.min_price = filterData.min_price;
    }
    if (filterData.max_price) {
        data.max_price = filterData.max_price;
    }
    if (filterData.sorting !== "relevance") {
        data.sorting = filterData.sorting
    }
    if (filterData.seller !== null) {
        data.seller = filterData.seller
    }

    const callback = axios.post('/api/filter-product', data)
        .then(res => {
            let data = res.data
            total.value = data['total'];
            products.data = data['products']['data'];
        })
    delay(callback, 200)

}

onBeforeMount(() => {
    fetchCategoryData();
})
onMounted(() => {
})


const timer = ref(0)

function delay(callback, ms) {
    timer.value = 0;
    return function () {
        let context = this, args = arguments;
        clearTimeout(timer.value);
        timer.value = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}
</script>

<style scoped>

</style>
