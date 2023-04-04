<template>
    <div class="filter-item" v-if="sellers.data.length">
        <div class="filter-title">Seller</div>
        <div class="filter-choose">
            <div class="filter-search">
                <input class="filter-box-input" name="li-merchant-list" placeholder="Store"
                       v-model="sellers.keyword" @change="filterSeller">
                <span class="filter-search-icon" @click="filterSeller">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <ol class="filter-list li-merchant-list">
                <li v-for="seller in computedSellers"
                    class="filter-list-item filter-list-merchant-item merchant-filter">
                    <label class="filter-label">
                        <input type="radio" autocomplete="off"
                               name="seller" v-model.number="filterData.seller" :value="seller.id"
                               @change="onChange"/>
                        <span class="filter-radio"></span>
                        <span class="filter-name">{{ seller['title'] }}</span>
                    </label>
                    <span class="filter-count">{{ seller['products_count'] }}</span>
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
export default {
    name: "SellerFilter"
}
</script>

<script setup>

import {computed, ref} from "vue";

const props = defineProps({
    sellers: {
        required: true
    },
    filterData: {
        required: true
    },
})
const emit = defineEmits(['change'])

const triggerChange = ref(0);

const onChange = function () {
    emit('change');
}
const sellers = props.sellers;
const computedSellers = computed(() => {
    triggerChange.value //reactivity
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

const filterSeller = function () {
    triggerChange.value++;
}
</script>

<style scoped>

</style>
