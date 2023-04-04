<template>
    <div class="filter-item filter-slide filter-box-price">
        <div class="filter-title">{{ "Price" }}</div>
        <div class="filter-slide-wrap">
            <div class="filter-slide-item filter-price">
                <div class="input-slide-wrap">
                    <Field type="range" class="range" max="200000000" step="10000"
                           v-model.number="filterData.min_price" name="min_price" @change="onChange"/>
                </div>
                <div class="input-slide-wrap">
                    <Field type="range" class="range" max="200000000" step="10000"
                           v-model.number="filterData.max_price" name="max_price" @change="onChange"/>
                </div>
                <div class="filter-slide-amount">
                    <span>{{ store.formatMoney(filterData.min_price) }}</span>
                    <span>{{ store.formatMoney(filterData.max_price) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PriceFilter"
}
</script>
<script setup>
import {Form, Field} from "vee-validate";
import {useLayoutStore} from "@/stores";
import {watch} from "vue";

const store = useLayoutStore();

const props = defineProps({
    filterData: {
        required: true
    }
})

const emit = defineEmits(['change'])
const onChange = function () {
    emit('change');
}

const filterData = props.filterData
const offset = 10000

watch(() => filterData.max_price, (newValue, oldValue) => {
    if (newValue <= filterData.min_price && newValue > 0) {
        filterData.min_price = newValue - offset
    }
    if (filterData.currentPage !== 1) {
        filterData.currentPage = 1;
    }
})

watch(() => filterData.min_price, (newValue, oldValue) => {
    if (newValue >= filterData.max_price) {
        filterData.max_price = newValue + offset;
    }
    if (filterData.currentPage !== 1) {
        filterData.currentPage = 1;
    }
})

</script>

<style scoped>

</style>
