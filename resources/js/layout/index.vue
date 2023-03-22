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
import Login from "@/layout/components/Login/index.vue";
import {onMounted} from "vue";
import {hydrate} from "@/main";
onMounted(() => {
    hydrate();
})
</script>

<style scoped>

</style>
