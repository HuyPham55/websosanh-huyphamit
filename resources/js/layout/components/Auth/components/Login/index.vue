<template>
    <Form class="auth-container" @submit="attemptLogin">
        <div class="auth-title">Login</div>
        <div class="auth-content">
        </div>
        <div class="auth-form">
            <div class="form-group">
                <label>
                    <Field type="email" class="form-control" autocomplete="off" placeholder="E-mail" name="email"/>
                </label>
                <label>
                    <Field type="password" class="form-control" autocomplete="off" placeholder="Password"
                           name="password"/>
                </label>
            </div>
            <div class="auth-checkbox">
                <label>
                    <input type="checkbox" checked="checked" name="remember" class="remember-checkbox">
                    Remember me
                </label>
            </div>
        </div>
        <div class="auth-action">
            <button class="register" @click="registerClickHandler" type="button">Register</button>
            <button class="login" type="submit">Login</button>
        </div>
    </Form>
</template>

<script>
export default {
    name: "index"
}
</script>

<script setup>
import {Form, ErrorMessage, Field} from "vee-validate";
import {userUserStore} from "@/stores";
let store = userUserStore()
const emit = defineEmits(['changeComponent', 'closePopup'])
const registerClickHandler = function () {
    emit('changeComponent', 'Register')
}
const loginClickHandler = function () {

}

const attemptLogin = function (data) {
    axios.post("/api/member/login", {
        ...data
    })
        .then(res => {
            let data = res.data;
            if (data['status'] === 'success') {
                store.user = data['data']['user']
                emit('closePopup');
            }
        })
}


</script>

<style scoped>

</style>
