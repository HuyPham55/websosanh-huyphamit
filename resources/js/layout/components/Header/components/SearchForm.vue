<template>
    <Form class="search-wrap" @submit="onSubmit">
        <Field autocomplete="off" title="" autofocus
               placeholder="Search for products..."
               name="keyword"
               v-model="formData.keyword"/>
        <button aria-label="search-button" type="submit">
            <i class="fa fa-search"></i>
        </button>
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
import {onBeforeMount, onMounted, reactive} from "vue";

const router = useRouter();
const routes = useRoute();

const formData = reactive({
    keyword: ''
})

const onSubmit = function() {
    if (formData.keyword.trim().length === 0) {
        return;
    }
    router.push({name: 'search', query: {keyword: formData.keyword}})
}

const setKeyword = function () {
    if (routes.query.hasOwnProperty('keyword')) {
        formData.keyword = routes.query.keyword
    }
}

onBeforeMount(() => {
    setKeyword();
})
</script>

<style scoped>

</style>
