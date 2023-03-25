<template>
    <Form class="auth-container" @submit="attemptRegister">
        <div class="auth-title">Register</div>
        <div class="auth-content">
        </div>
        <div class="auth-form">
            <div class="form-group">
                <label>
                    <Field type="email" class="form-control" autocomplete="off" placeholder="E-mail" name="email"/>
                </label>
                <label>
                    <Field type="text" class="form-control" autocomplete="off" placeholder="Name" name="name"/>
                </label>
                <label>
                    <Field type="password" class="form-control" autocomplete="off" placeholder="Password"
                           name="password"/>
                </label>
                <label>
                    <Field type="password" class="form-control" autocomplete="off" placeholder="Password confirmation"
                           name="password_confirmation"/>
                </label>
            </div>
            <div class="auth-checkbox">
                <label>
                    <Field type="checkbox" checked="checked" name="remember" class="remember-checkbox"/>
                    I have read and accept with <a class="checkbox-url" href="#">terms and conditions</a>.
                </label>
            </div>
        </div>
        <div class="auth-action">
            <button class="register" @click="loginClickHandler" type="button">Back</button>
            <button class="login" type="submit">Register</button>
        </div>
    </Form>
</template>

<script>
export default {
    name: "index"
}
</script>
<script setup>
import {Form, Field, ErrorMessage} from "vee-validate";
import {userUserStore} from "@/stores";

let store = userUserStore()

const emit = defineEmits(['changeComponent', 'closePopup'])
const loginClickHandler = function () {
    emit('changeComponent', 'Login')

}

const attemptRegister = function (data) {
    axios.post("/api/member/register", {
        ...data
    })
        .then(res => {
            let data = res.data
            if (data['status'] === 'success') {
                store.user = data['data']['user'];
                emit('closePopup');
            }
        })
}
</script>

<style scoped>

</style>
