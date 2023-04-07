<template>
<div class="container">
    <TopBar/>
    <Login/>
    <Header/>
    <router-view v-slot="{ Component, route }" >
        <transition name="fade-transform" mode="out-in">
            <component :is="Component" :key="key"/>
        </transition>
    </router-view>
    <loading-component :ready="store.computedReady"/>
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
import {computed, onBeforeMount, onMounted} from "vue";
import {hydrate} from "@/main";
import {useLayoutStore, useUserStore} from "@/stores";
import {useRoute} from "vue-router";
import LoadingComponent from "@/Components/LoadingComponent.vue";

const route = useRoute()
const store = useLayoutStore()
const userStore = useUserStore()

const key = computed(() => {
    return route.fullPath;
})

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
