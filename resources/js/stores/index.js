import {defineStore} from "pinia";
import {computed, reactive, ref} from "vue";
import {sessionCache} from "@/API/sessionCache";
import {useRouter} from "vue-router";


export const useLayoutStore = defineStore('layout', () => {
    const layoutData = reactive({
        ready: false,
        title: '',
        footerData: [],
        headerData: [],
    })
    const pageData = reactive({
        ready: false
    });

    const formatMoney = function (value) {
        return new Intl.NumberFormat('de-DE', { style: 'currency', currency:'VND' }).format(value)
    }

    function setDocumentTitle(string) {
        if (typeof string === "string" && string) {
            document.title = string
        }
    }

    const computedReady = computed(() => pageData.ready && layoutData.ready)

    const fetchLayoutData = function () {
        let cacheKey = 'layoutData';
        layoutData.ready = false;
        let callback = (data) => {
            layoutData.footerData = data['footerData'];
            layoutData.headerData = data['headerData'];
            layoutData.title = data['title'];
            layoutData.ready = true;
        }

        let useCache = true;
        if (sessionCache.has(cacheKey) && useCache) {
            let data = sessionCache.load(cacheKey);
            callback(data);
        } else {
            axios.post("/api/fetch-layout-data")
                .then(res => {
                    let data = res.data;
                    callback(data);
                    sessionCache.save(cacheKey, data)
                })
        }
    }
    return {layoutData, fetchLayoutData, formatMoney, pageData, computedReady, setDocumentTitle}
})


export const useUserStore = defineStore('user', () => {
    const user = ref(null);

    // Token is only used for token based authentication
    const token = ref(null);
    const setAxiosToken = function (value) {
        token.value = value;
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${value}`;
        //Set axios bearer token
    }
    const fetchUserData = function () {
        axios.get('/api/user').then(response => {
            user.value = response.data
        }).catch(e => {

        });
    }

    const userLogOut = function () {
        user.value = null;
        token.value = null;
    }
    return {user, token, setAxiosToken, fetchUserData, userLogOut}
})

export const useProductStore = defineStore('products', () => {
    const router = useRouter();

    const getProductUrl = async function (id) {
        useLayoutStore().layoutData.ready = false;
        return await axios.post('/api/get-product-url', {id})
            .then(res => {
                let data = res.data
                let url = data['data'];
                window.open(url);
            }).finally(() => {
                useLayoutStore().layoutData.ready = true;
            })
    }

    function calcSale(item) {
        if (!item.hasOwnProperty('original_price') || !item.hasOwnProperty('price')) {
            return
        }
        if ((item.original_price === 0) || (item.original_price < item.price)) {
            return
        }
        let percent = ((1 - (item.original_price / item.price)) * 100).toFixed(0);
        return `${percent}%`
    }

    const getItemType = function (item) {
        const itemTypes = {
            'products': 0,
            'comparisons': 1
        }
        let index = item['index'];
        return itemTypes[index]
    }
    const onClick = function (item) {
        //also used in search form, comparison
        let itemType = getItemType(item);
        let id = item.id;
        if (itemType === 0) {
            return getProductUrl(id);
        }
        if (itemType === 1) {
            router.push({name: 'comparison', params: {id: item.id, slug: item.slug}})
        }
    }

    return {getProductUrl, calcSale, onClick}
})

