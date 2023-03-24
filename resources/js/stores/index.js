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

})
