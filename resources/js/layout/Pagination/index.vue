<template>
    <ul class="pagination" v-show="componentDisplay">
        <template v-if="!onFirstPage">
            <li><a @click="changePage(1)">«</a></li>
            <li><a @click="changePage(currentPage - 1)">‹</a></li>
        </template>
        <li v-for="number in arrayElements" @click="changePage(number)">
            <a :class="{'active': number===currentPage}">
                {{ number }}
            </a>
        </li>
        <template v-if="hasMorePages">
            <li><a @click="changePage(currentPage + 1)">›</a></li>
            <li><a @click="changePage(lastPageNumber)">»</a></li>
        </template>
    </ul>
</template>

<script>
export default {
    name: "index.vue"
}
</script>


<script setup>
import {computed} from "vue";

const props = defineProps({
    total: {
        //total number of item
        type: Number,
        required: true,
    },
    perPage: {
        //number of item per page
        type: Number,
        required: true
    },
    currentPage: {
        type: Number,
        required: true
    },
    ready: {
        required: false,
        default: true,
    }

})

const componentDisplay = computed(() => props.total > props.perPage)

const onFirstPage = computed(() => props.currentPage === 1)

const lastPageNumber = computed(() => ((Math.floor(props.total / props.perPage)) + (props.total % props.perPage ? 1 : 0)) | 0);

const hasMorePages = computed(() => props.currentPage !== lastPageNumber.value)

const emit = defineEmits(['changePage']);

const upperLimit = computed(() => {
    let result = props.currentPage + 5;
    if (result > lastPageNumber.value) {
        result = lastPageNumber.value;
    }
    return result;
})

const arrayElements = computed(() => {
    let result = [];
    for (let i = props.currentPage; i <= upperLimit.value; i++) {
        result.push(i);
    }
    return result;
})
const changePage = function (number) {
    number = number | 0;
    if (props.ready) {
        emit("changePage", number);
    }
}

</script>
<style scoped>

</style>
