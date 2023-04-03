<template>
    <div class="product-empty">
        <div class="page-text">There is <b>0</b> match for <span class="title">“{{props.keyword}}“</span></div>
        <p class="product-empty-text">Sorry, your search doesn't have any match<br>Please try again.</p>
    </div>
</template>

<script>
export default {
    name: "ProductEmpty"
}
</script>

<script setup>
const props = defineProps({
    keyword: {
        required: true
    }
})
</script>

<style scoped>

</style>
