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
import {useLayoutStore, userUserStore} from "@/stores";


const store = useLayoutStore()
const userStore = userUserStore()
onBeforeMount(() => {
    store.fetchLayoutData();
})
onMounted(() => {
    hydrate();
    //Cookie-based authentication
    axios.get('/sanctum/csrf-cookie').then(response => {
        userStore.fetchUserData();
    });
})
</script>

<style scoped>

</style>
