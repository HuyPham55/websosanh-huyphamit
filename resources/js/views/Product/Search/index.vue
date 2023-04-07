<template>
    <main class="main-content product-category">
        <ol class="breadcrumbs">
            <li>
                <router-link :to="{name: 'home'}">Homepage</router-link>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#" @click.prevent="false">
                    Search
                </a>
            </li>
        </ol>
        <div class="page-wrap" v-if="readyStatus">
            <div class="page-sidebar">
                <div class="sidebar-filter">
                    <div class="sidebar-filter-title">Filter</div>
                    <Form class="filter-wrap" @submit="">
                        <PriceFilter :filter-data="filterData" @change="filterProduct"/>
                    </Form>
                </div>
            </div>
            <div class="page-container">
                <div class="page-header" ref="header">
                    <div class="page-text">
                        <h1 class="title">
                            There are <transition name="fade-transform"><b class="total">{{total}}</b></transition> products for "{{keyword}}"
                        </h1>
                    </div>
                    <div class="sort-wrap">
                        <select class="sorting" title="" v-model="filterData.sorting" @change="filterProduct(1)">
                            <option value="_score-desc">Relevance</option>
                            <option value="price-desc">Highest price first</option>
                            <option value="price-asc">Lowest price first</option>
                            <option value="hits-desc">Most viewed</option>
                        </select>
                    </div>
                </div>
                <div class="list-product">
                    <template v-if="products.data.length !== 0">
                        <ProductList :items="products.data" :ready="products.ready"/>
                        <Pagination :total="total" :perPage="filterData.perPage" :currentPage="filterData.currentPage" @changePage="changePage"/>
                    </template>
                    <ProductEmpty :keyword="keyword" v-else/>
                </div>
            </div>
        </div>
        <LoadingComponent
            :useClass="true"
            :ready="readyStatus"
        />
    </main>
</template>

<script>
export default {
    name: "index.vue"
}
</script>


<script setup>
import {useRoute} from "vue-router";
import {computed, onBeforeMount, onMounted, reactive, ref} from "vue";
import ProductEmpty from "@/views/Product/components/ProductList/ProductEmpty.vue";
import ProductList from "@/views/Product/components/ProductList/index.vue";
import Pagination from "@/layout/Pagination/index.vue";
import PriceFilter from "@/views/Product/components/Filters/PriceFilter.vue";
import {Form} from "vee-validate";
import LoadingComponent from "@/Components/LoadingComponent.vue";
const route = useRoute()

// layout data

const readyStatus = ref(false);
const total = ref(0);
const header = ref(null)

// end layout data


const keyword = computed(() => route.query.keyword)
const filterData = reactive({
    min_price: 0,
    max_price: 200000000,
    seller: null,
    sorting: '_score-desc',
    currentPage: 1,
    perPage: 40,
})


const sellers = reactive({
    data: [],
    keyword: '',
    submit: 0
})
const products = reactive({
    data: [],
    ready: false,
})

const filterProduct = async function (page = 1) {
    products.ready = false;

    let data = {}
    if (filterData.min_price) {
        data.min_price = filterData.min_price;
    }
    if (filterData.max_price) {
        data.max_price = filterData.max_price;
    }
    data.sorting = filterData.sorting
    if (typeof page === 'number' && page !== filterData.currentPage) {
        data.page = page;
    }

    data.keyword = keyword.value;
    const callback = await axios.post('/api/search-by-keyword', data)
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
    return await delay(callback, 200)
}

const changePage = function (pageNumber) {
    scrollToPageHeader();
    filterProduct(pageNumber);
}

onBeforeMount(async () => {
    await filterProduct()
    readyStatus.value = true;
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
