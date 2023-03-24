<template>
<div class="container">
    <TopBar/>
    <Login/>
    <Header/>
    <router-view/>
    <Footer/>
</div>
</template>

<script>
export default {
    name: "index"
}
</script>
<script setup>
import Header from "@/layout/components/Header/index.vue";
import TopBar from "@/layout/components/Header/components/TopBar.vue";
import Footer from "@/layout/components/Footer/index.vue";
import Login from "@/layout/components/Auth/index.vue";
import {onBeforeMount, onMounted} from "vue";
import {hydrate} from "@/main";
import {useLayoutStore} from "@/stores";



const store = useLayoutStore()
onBeforeMount(() => {
    store.fetchLayoutData();
})
onMounted(() => {
    hydrate();
})
</script>

<style scoped>

</style>
