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

    const formatMoney = function (value) {
        return new Intl.NumberFormat('de-DE', { style: 'currency', currency:'VND' }).format(value)
    }

    const fetchLayoutData = function () {
        let cacheKey = 'layoutData';
        layoutData.ready = false;
        let callback = (data) => {
            layoutData.footerData = data['footerData'];
            layoutData.headerData = data['headerData'];
            layoutData.title = data['title'];
            layoutData.ready = true;
        }

        if (sessionCache.has(cacheKey)) {
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
    return {layoutData, fetchLayoutData, formatMoney}
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
        axios.post('/api/get-product-url', {id})
            .then(res => {
                let data = res.data
                let url = data['data'];
                window.open(url);
            })
    }
    return {getProductUrl}
})

