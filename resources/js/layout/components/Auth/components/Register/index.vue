<template>
    <Form class="auth-container" @submit="attemptRegister" v-slot="{isSubmitting}">
        <div class="auth-title">Register</div>
        <div class="auth-content">
        </div>
        <div class="auth-form">
            <div class="form-group">
                <label>
                    <Field type="email" class="form-control" autocomplete="off" placeholder="E-mail" name="email"/>
                    <ErrorMessage name="email" as="span" class="invalid-feedback"></ErrorMessage>
                </label>
                <label>
                    <Field type="text" class="form-control" autocomplete="off" placeholder="Name" name="name"/>
                    <ErrorMessage name="name" as="span" class="invalid-feedback"></ErrorMessage>
                </label>
                <label>
                    <Field type="password" class="form-control" autocomplete="off" placeholder="Password"
                           name="password"/>
                    <ErrorMessage name="password" as="span" class="invalid-feedback"></ErrorMessage>
                </label>
                <label>
                    <Field type="password" class="form-control" autocomplete="off" placeholder="Password confirmation"
                           name="password_confirmation"/>
                    <ErrorMessage name="password_confirmation" as="span" class="invalid-feedback"></ErrorMessage>
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
            <button class="register" @click="loginClickHandler" type="button" :disabled="isSubmitting">Back</button>
            <button class="login" type="submit" :disabled="isSubmitting">Register</button>
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
import {useUserStore} from "@/stores";

let store = useUserStore()

const emit = defineEmits(['changeComponent', 'closePopup'])
const loginClickHandler = function () {
    emit('changeComponent', 'Login')

}

const attemptRegister = function (data, actions) {
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
        .catch(res => {
            let data = res.response.data
            let errors = data['errors'];
            for (const field in errors) {
                actions.setFieldError(field, errors[field]);

            }
        })
}
</script>

<style scoped>

</style>
