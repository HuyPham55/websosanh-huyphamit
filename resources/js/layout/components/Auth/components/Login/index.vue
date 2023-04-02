<template>
    <Form class="auth-container" @submit="onSubmit" v-slot="{isSubmitting}">
        <div class="auth-title">Login</div>
        <div class="auth-content">
        </div>
        <div class="auth-form">
            <div class="form-group">
                <label>
                    <Field type="email" class="form-control" autocomplete="off" placeholder="E-mail" name="email"/>
                    <ErrorMessage name="email" as="span" class="invalid-feedback"></ErrorMessage>
                </label>
                <label>
                    <Field type="password" class="form-control" autocomplete="off" placeholder="Password"
                           name="password"/>
                    <ErrorMessage name="password" as="span" class="invalid-feedback"></ErrorMessage>
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
            <button class="register" @click="registerClickHandler" type="button" :disabled="isSubmitting">
                Register
            </button>
            <button class="login" type="submit" :disabled="isSubmitting">Login</button>
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
import {useUserStore} from "@/stores";
import {ref} from "vue";
let store = useUserStore()
const emit = defineEmits(['changeComponent', 'closePopup'])
const registerClickHandler = function () {
    emit('changeComponent', 'Register')
}
function onSubmit(data, actions) {
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
