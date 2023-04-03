<template>
    <main class="main-content product-category" v-if="readyStatus">
        <ol class="breadcrumbs">
            <li>
                <router-link :to="{name: 'home'}">Homepage</router-link>
                <i class="fa fa-angle-right"></i>
            </li>
            <li v-for="item in breadcrumb.data">
                <router-link :to="{name: 'product_category', params: {id: item['id'], slug: item['slug']}}">
                    {{item['title']}}
                </router-link>
                <i class="fa fa-angle-right" v-if="item.id !== category.id"></i>
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
                        <div class="filter-item" v-if="sellers.data.length">
                            <div class="filter-title">Seller</div>
                            <div class="filter-choose">
                                <div class="filter-search">
                                    <input class="filter-box-input" name="li-merchant-list" placeholder="Store" v-model="sellers.keyword" @change="filterSeller">
                                    <span class="filter-search-icon" @click="filterSeller">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                                <ol class="filter-list li-merchant-list">
                                    <li v-for="seller in computedSellers"
                                        class="filter-list-item filter-list-merchant-item merchant-filter">
                                        <label class="filter-label">
                                            <input type="radio" autocomplete="off"
                                                   name="seller" v-model.number="filterData.seller" :value="seller.id" @change="filterProduct"/>
                                            <span class="filter-radio"></span>
                                            <span class="filter-name">{{seller['title']}}</span>
                                        </label>
                                        <span class="filter-count">{{seller['products_count']}}</span>
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
                                               v-model.number="filterData.max_price" name="max_price" @change="filterProduct"/>
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
                    <template v-if="products.data.length !== 0">
                        <ProductList :items="products.data"/>
                        <Pagination :total="total" :perPage="pagination.perPage" :currentPage="pagination.currentPage" @changePage="changePage"/>
                    </template>
                    <ProductEmpty :keyword="category.title" v-else/>
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
import Pagination from "@/layout/Pagination/index.vue";
import ProductEmpty from "@/views/Product/components/ProductList/ProductEmpty.vue";

const store = useLayoutStore();
const route = useRoute();
const computedId = computed(() => route.params.id | 0)

// layout data

const readyStatus = ref(false);
const total = ref(0);
const pagination = reactive({
    currentPage: 1,
    perPage: 40,
})
const breadcrumb = reactive({
    data: []
})

// end layout data

const category = ref(null);

const children = reactive({
    data: [],
})

const sellers = reactive({
    data: [],
    keyword: '',
    submit: 0
})

const products = reactive({
    data: []
})

const computedSellers = computed(() => {
    sellers.submit; //reactivity
    let keyword = sellers.keyword.toUpperCase().trim();
    let result = sellers.data;
    if (keyword.length) {
        let callback = function (item) {
            return (item['title'].toUpperCase().indexOf(keyword) > -1) || (item['url'].toUpperCase().indexOf(keyword) > -1)
        }
        result = result.filter(item => callback(item))
    }
    return result;
})
const filterSeller = function() {
    sellers.submit++;
}

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
            sellers.data = data['sellers'];
            breadcrumb.data = data['breadcrumb'];
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
    if (pagination.currentPage !== 1) {
        pagination.currentPage = 1;
    }
})

watch(() => filterData.min_price, (newValue, oldValue) => {
    if (newValue >= filterData.max_price) {
        filterData.max_price = newValue + 1;
    }
    if (pagination.currentPage !== 1) {
        pagination.currentPage = 1;
    }
})

watch(() => filterData.seller, (newValue, oldValue) => {
    if (pagination.currentPage !== 1) {
        pagination.currentPage = 1;
    }
})

const filterProduct = function(page = 1) {
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
    if (typeof page === 'number' && page !== pagination.currentPage) {
        data.page = page;
    }

    const callback = axios.post('/api/filter-product', data)
        .then(res => {
            let data = res.data
            total.value = data['total'];
            products.data = data['products']['data'];
            if (typeof page === 'number' && page !== pagination.currentPage) {
                pagination.currentPage = page;
            }
        })
    delay(callback, 200)
}

const changePage = function (pageNumber) {
    filterProduct(pageNumber);
}

onBeforeMount(() => {
    fetchCategoryData();
})
onMounted(() => {
})



//utilities functions
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
