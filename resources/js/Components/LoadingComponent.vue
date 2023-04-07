<template>
    <div :class="{'preloader': 1, 'inactive': ready}">
        <div class="clear-loading loading-effect" v-if="useCircle">
            <img src="/images/loading.svg" alt=""/>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoadingComponent"
}
</script>

<script setup>
const props = defineProps({
    useCircle: {
        default: true
    },
    ready: {
        default: false,
    },
})
</script>

<style scoped>

</style>
