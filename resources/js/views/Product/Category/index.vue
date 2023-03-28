<template>

</template>

<script>
import {useLink} from "vue-router";
import {computed} from "vue";

export default {
    name: "index.vue",

}
</script>
<script setup>
import {onMounted} from "vue";
import { useRoute } from 'vue-router';
const route = useRoute();
onMounted(() => {
    console.log(route.params.id);
})
</script>

<style scoped>

</style>
