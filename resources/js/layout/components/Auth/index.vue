<template>
    <div class="login-popup">
        <div class="auth-overlay"></div>
        <transition name="fade-transform" mode="out-in">
            <component :is="targetComponent" @changeComponent="handler" @closePopup="closePopup">
            </component>
        </transition>
    </div>
</template>

<script>
import Login from "@/layout/components/Auth/components/Login/index.vue";
import Register from "@/layout/components/Auth/components/Register/index.vue";

export default {
    name: "index",
    components: {
        Login,
        Register,
    }
}
</script>

<script setup>
import {ref} from "vue";

const targetComponent = ref('Login');
const handler = function (target) {
    targetComponent.value = target;
}

const closePopup = function () {
    let loginPopup = document.querySelector(".login-popup");
    loginPopup.classList.remove('active');
}
</script>

<style scoped>

</style>
