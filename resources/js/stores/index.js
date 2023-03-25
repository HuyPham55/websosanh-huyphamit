import {defineStore} from "pinia";
import {computed, reactive, ref} from "vue";

export const useLayoutStore = defineStore('layout', () => {
    const layoutData = reactive({
        ready: false,
        title: '',
        footerData: [],
        headerData: [],
    })

    const fetchLayoutData = function () {
        layoutData.ready = false;
        axios.post("/api/fetch-layout-data")
            .then(res => {
                layoutData.ready = true;
                let data = res.data;
                layoutData.footerData = data['footerData'];
                layoutData.headerData = data['headerData'];
                layoutData.title = data['title'];
            })
    }
    return {layoutData, fetchLayoutData}
})


export const userUserStore = defineStore('user', () => {
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

