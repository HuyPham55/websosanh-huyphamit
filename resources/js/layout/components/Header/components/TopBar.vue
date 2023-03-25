<template>
    <div class="top-bar">
        <p></p>
        <div class="login-section">
            <div class="login-title" v-if="computedUser">
                <span @click.prevent.stop="logOut">
                    {{computedUser['name']}}
                </span>
            </div>
            <div class="login-title" v-else>
                Login
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TopBar"
}
</script>

<script setup>
import {userUserStore} from "@/stores";
import {computed} from "vue";

const store = userUserStore()

const computedUser = computed(() => store.user)

const logOut = function () {
    axios.post('/api/member/logout')
        .then(res => {
            let data = res.data;
            if (data['status'] === 'success') {
                store.userLogOut()

            }
        })
}
</script>

<style scoped>

</style>
