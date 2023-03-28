<template>
    <div class="top-bar">
        <p>Bán hàng cùng Let's compare</p>
        <div :class="{'login-section': 1, 'logged-in': computedUser}">
            <div class='login-title'
                 v-if="computedUser">
                <span>
                    {{computedUser['name']}}
                </span>
                <ol class="sub-menu-top">
                    <li>
                        <a>My account</a>
                    </li>
                    <li>
                        <a @click.prevent.stop="logOut">Log out</a>
                    </li>
                </ol>
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
