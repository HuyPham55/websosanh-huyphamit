<template>
    <div class="auth-container">
        <div class="auth-title">Login</div>
        <div class="auth-content">
        </div>
        <div class="auth-form">
            <div class="form-group">
                <label>
                    <input type="email" class="form-control" autocomplete="off" placeholder="E-mail"/>
                </label>
                <label>
                    <input type="password" class="form-control" autocomplete="off" placeholder="Password"/>
                </label>
            </div>
            <div class="auth-checkbox">
                <label>
                    <input type="checkbox" checked="checked" name="remember" class="remember-checkbox"> Remember me
                </label>
            </div>
        </div>
        <div class="auth-action">
            <button class="register" @click="registerClickHandler">Register</button>
            <button class="login" @click="loginClickHandler">Login</button>
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
const registerClickHandler = function() {
    emit('changeComponent', 'Register')
}
const loginClickHandler = function () {

}
</script>

<style scoped>

</style>
