<template>
    <router-view />
    <button type="button" id="btn-to-top">
        <i class="fas fa-angle-up"></i>
    </button>
</template>

<script>
export default {
    name: "App"
}
</script>

<script setup>
import {onMounted} from "vue";

onMounted(() => {
})
</script>
<style scoped>

</style>
