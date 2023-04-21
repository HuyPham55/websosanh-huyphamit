<template>
    <div class="filter-item" v-if="options.length">
        <div class="filter-title">
            <slot>
                Seller
            </slot>
        </div>
        <div class="filter-choose">
            <div class="filter-search">
                <input class="filter-box-input" name="li-merchant-list" placeholder="Store"
                       v-model="keyword" @change="filterOptions">
                <span class="filter-search-icon" @click="filterOptions">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <ol class="filter-list li-merchant-list">
                <li v-for="option in computedOptions"
                    class="filter-list-item filter-list-merchant-item merchant-filter">
                    <label class="filter-label">
                        <input type="radio" autocomplete="off"
                               name="seller" v-model.number="selectedValue" :value="option.id"
                               @change="onChange"/>
                        <span class="filter-radio"></span>
                        <span class="filter-name">{{ option['title'] }}</span>
                    </label>
                    <span class="filter-count">{{ option['products_count'] }}</span>
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
export default {
    name: "FilterItem"
}
</script>

<script setup>

import {computed, ref} from "vue";

const props = defineProps({
    options: {
        required: true,

    },
    modelValue: {
        required: true
    }
})
const emit = defineEmits(['change', 'update:modelValue'])

const triggerChange = ref(0);

const keyword = ref('');

const selectedValue = ref(props.modelValue);

const onChange = function () {
    emit('update:modelValue', selectedValue.value);
    emit('change');
}
const options = props.options;
const computedOptions = computed(() => {
    triggerChange.value //reactivity
    let sanitized = keyword.value.toUpperCase().trim();
    let result = options;
    if (sanitized.length) {
        let callback = function (item) {
            return (item['title'].toUpperCase().indexOf(sanitized) > -1)
        }
        result = result.filter(item => callback(item))
    }
    return result;
})

const filterOptions = function () {
    triggerChange.value++;
}
</script>

<style scoped>

</style>
