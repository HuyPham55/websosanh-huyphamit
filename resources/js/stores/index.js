import {defineStore} from "pinia";
import {computed, reactive, ref} from "vue";
import {sessionCache} from "@/API/sessionCache";
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
        document.title = string
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
    const getProductUrl = function (id) {
        useLayoutStore().layoutData.ready = false;
        return axios.post('/api/get-product-url', {id})
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

    return {getProductUrl, calcSale}
})

