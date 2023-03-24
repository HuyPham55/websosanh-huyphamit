<template>
    <div class="auth-container">
        <div class="auth-title">Register</div>
        <div class="auth-content">
        </div>
        <div class="auth-form">
            <div class="form-group">
                <label>
                    <input type="email" class="form-control" autocomplete="off" placeholder="E-mail"/>
                </label>
                <label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Name"/>
                </label>
                <label>
                    <input type="password" class="form-control" autocomplete="off" placeholder="Password"/>
                </label>
                <label>
                    <input type="password" class="form-control" autocomplete="off" placeholder="Password confirmation"/>
                </label>
            </div>
            <div class="auth-checkbox">
                <label>
                    <input type="checkbox" checked="checked" name="remember" class="remember-checkbox">
                    I have read and accept with <a class="checkbox-url" href="#">terms and conditions</a>.
                </label>
            </div>
        </div>
        <div class="auth-action">
            <button class="register" @click="loginClickHandler">Back</button>
            <button class="login">Register</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "index"
}
</script>
<script setup>
const emit = defineEmits(['changeComponent'])
const loginClickHandler = function () {
    emit('changeComponent', 'Login')

}
</script>

<style scoped>

</style>
