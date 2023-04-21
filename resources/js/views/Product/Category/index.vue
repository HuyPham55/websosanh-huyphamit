<template>
    <main class="main-content product-category">
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
                    <i class="fa fa-angle-right" v-if="item.id !== category.id"></i>
                </li>
            </ol>
            <div class="page-wrap">
                <div class="page-sidebar">
                    <div class="page-sidebar-item sidebar-menu" v-if="children.data.length">
                        <div class="sidebar-menu-title">
                            {{ category['title'] }}
                        </div>
                        <ol class="sidebar-menu-wrap" tabindex="0">
                            <li class="has-children" v-for="item in children.data">
                                <router-link :to="{name: 'product_category', params: {id: item['id'], slug: item['slug']}}">
                                    {{ item['title'] }}
                                </router-link>
                            </li>
                        </ol>
                    </div>
                    <div class="sidebar-filter">
                        <div class="sidebar-filter-title">Filter</div>
                        <Form class="filter-wrap" @submit="">
                            <FilterItem v-model="filterData.seller" :options="sellers.data" @change="filterProduct"/>
                            <PriceFilter :filterData="filterData" @change="filterProduct"/>
                        </Form>
                    </div>
                </div>
                <div class="page-container">
                    <div class="page-header" ref="header">
                        <div class="page-text">
                            <h1 class="title">{{ category['title'] }}</h1> | Has
                            <transition name="fade-transform"><b class="total">{{ total }}</b></transition>
                            products
                        </div>
                        <div class="sort-wrap">
                            <select class="sorting" title="" v-model="filterData.sorting" @change="filterProduct(1)">
                                <option value="">Sorting</option>
                                <option value="price-desc">Highest price first</option>
                                <option value="price-asc">Lowest price first</option>
                                <option value="hits-desc">Most viewed</option>
                            </select>
                        </div>
                    </div>
                    <div class="list-product">
                        <template v-if="products.data.length !== 0">
                            <ProductList :items="products.data" :ready="products.ready"/>
                            <Pagination :total="total"
                                        :perPage="filterData.perPage"
                                        :currentPage="filterData.currentPage"
                                        :ready="products.ready"
                                        @changePage="changePage"/>
                        </template>
                        <ProductEmpty :keyword="category.title" v-else/>
                    </div>
                </div>
            </div>
            <div class="desc-wrap" v-if="category['content']">
                <div class="desc-content" v-html="category['content']">

                </div>
            </div>
        </template>
    </main>
</template>
<script setup>
import {computed, nextTick, onBeforeMount, onMounted, reactive, ref, watch} from "vue";
import {useRoute, useRouter} from 'vue-router';
import {useLayoutStore} from "@/stores";
import ProductList from "@/views/Product/components/ProductList/index.vue";
import {Form} from "vee-validate";
import Pagination from "@/layout/Pagination/index.vue";
import ProductEmpty from "@/views/Product/components/ProductList/ProductEmpty.vue";
import PriceFilter from "@/views/Product/components/Filters/PriceFilter.vue";
import FilterItem from "@/views/Product/components/Filters/FilterItem.vue";


const store = useLayoutStore();
const route = useRoute();
const router = useRouter();
const computedId = computed(() => route.params.id | 0)

// layout data

const total = ref(0);
const breadcrumb = reactive({
    data: []
})

const header = ref(null)

// end layout data

const category = ref(null);

const children = reactive({
    data: [],
})

const sellers = reactive({
    data: [],
})

const products = reactive({
    data: [],
    ready: false,
})


const fetchCategoryData = function () {
    store.pageData.ready = false;
    const id = computedId.value
    let data = {
        id,
    }

    axios.post("/api/fetch-product-category", data)
        .then(res => {
            store.pageData.ready = true;
            let data = res.data;
            category.value = data['category'];
            children.data = data['children'];
            total.value = data['total'];
            sellers.data = data['sellers'];
            breadcrumb.data = data['breadcrumb'];

            store.setDocumentTitle(category.value.title)
        }).finally(() => {
        store.pageData.ready = true;
    })
}

const filterData = reactive({
    min_price: 0,
    max_price: 200000000,
    seller: null,
    sorting: '',
    currentPage: 1,
    perPage: 40,
})


watch(() => filterData.seller, (newValue, oldValue) => {
    if (filterData.currentPage !== 1) {
        filterData.currentPage = 1;
    }
})

const filterProduct = function (page = 1) {
    products.ready = false;
    let data = {}
    data.category = computedId.value;

    if (filterData.min_price) {
        data.min_price = filterData.min_price;
    }
    if (filterData.max_price) {
        data.max_price = filterData.max_price;
    }

    data.sorting = filterData.sorting

    if (filterData.seller !== null) {
        data.seller = filterData.seller
    }
    if (typeof page === 'number' && page !== filterData.currentPage) {
        data.page = page;
    }

    const callback = axios.post('/api/filter-product', data)
        .then(res => {
            let data = res.data
            total.value = data['total'];
            products.data = data['products']['data'];
            if (typeof page === 'number' && page !== filterData.currentPage) {
                filterData.currentPage = page;
            }
        }).finally(() => {
            products.ready = true;
        })
    delay(callback, 200)
}

const changePage = function (pageNumber) {
    scrollToPageHeader();
    filterProduct(pageNumber);
}

onBeforeMount(() => {
    fetchCategoryData();
    filterProduct();
})
onMounted(() => {
})


//utilities functions

const scrollToPageHeader = function() {
    let headerPosition = header.value.scrollHeight;
    window.scrollTo({top: headerPosition, behavior: 'smooth'});
}

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
