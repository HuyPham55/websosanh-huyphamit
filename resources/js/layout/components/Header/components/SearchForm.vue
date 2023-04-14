<template>
    <Form class="search-wrap" @submit="onSubmit">
        <Field autocomplete="off" title="" autofocus
               placeholder="Search for products..."
               name="keyword"
               @input="onInput"
               @blur="hideSearchResult"
               @click="inputHandleClick"
               v-model="formData.keyword"/>
        <button aria-label="search-button" type="submit">
            <i class="fa fa-search"></i>
        </button>
        <div class="search-result" :hidden="computedHidden">
            <ol id="resultFilter">
                <li v-for="suggest in searchResult.suggestion">
                    <router-link :to="{name: 'search', query: {keyword: suggest}}">
                        {{suggest}}
                    </router-link>
                </li>
                <li class="has-store" v-for="item in searchResult.items">
                    <a href="" @click.prevent="clickHandler(item)">
                        {{ item.title }}
                        <span class="search-store"> Price:
                            <span class="price">
                                {{ store.formatMoney(item.price) }}
                            </span>
                        </span>
                    </a>
                </li>
            </ol>
        </div>
    </Form>
</template>

<script>
export default {
    name: "SearchForm"
}

</script>

<script setup>
import {useRoute, useRouter} from "vue-router";
import {Form, Field} from "vee-validate";
import {computed, onBeforeMount, onMounted, reactive, ref} from "vue";
import {useProductStore} from "@/stores";
import {useLayoutStore} from "@/stores";

const store = useLayoutStore();
const router = useRouter();
const routes = useRoute();
const productStore = useProductStore();

const formData = reactive({
    keyword: '',
    onBlur: false,
})

const searchResult = reactive({
    suggestion: [],
    items: [],
    ready: false,
    pending: false,
})

let computedResultLength = computed(() => {
    return searchResult.suggestion.length + searchResult.items.length
})

const computedHidden = computed(() => {
    return computedResultLength.value === 0 || formData.onBlur;

})
const onSubmit = function () {
    if (formData.keyword.trim().length === 0) {
        return;
    }
    router.push({name: 'search', query: {keyword: formData.keyword}})
    formData.onBlur = true;
}

const setKeyword = function () {
    if (routes.query.hasOwnProperty('keyword')) {
        formData.keyword = routes.query.keyword
    }
}

onBeforeMount(() => {
    setKeyword();
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

const callback = function () {
    formData.onBlur = false;
    if (formData.keyword.length <= 3) {
        return;
    }
    searchResult.ready = false;
    axios.get('/api/search', {
        params: {
            keyword: formData.keyword
        }
    }).then((res) => {
        let data = res.data;
        searchResult.suggestion = data['suggests'];
        searchResult.items = data['items'];
    }).finally(() => {
        searchResult.ready = true
    })
}
const onInput = delay(callback, 100)

const itemTypes = {
    //also used in product list component
    'products': 0,
    'comparisons': 1
}
const getItemType = function(item) {
    //also used in product list component
    let index = item['index'];
    return itemTypes[index]
}
const clickHandler = function(item) {
    //also used in product list component
    let itemType = getItemType(item);
    let id = item.id;
    if (itemType === 0) {
        productStore.getProductUrl(id);
        return;
    }
    if (itemType === 1) {
        router.push({name: 'comparison', params: {id: item.id, slug: item.slug}})
    }
}

function hideSearchResult() {
    formData.onBlur = true;
}
function inputHandleClick() {
    if (formData.onBlur === true) {
        formData.onBlur = false
    }
}
</script>

<style scoped>

</style>
