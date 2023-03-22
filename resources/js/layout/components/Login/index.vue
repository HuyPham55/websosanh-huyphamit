<template>
    <div class="login-popup">
        <div class="auth-overlay"></div>
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
                <div class="remember-me">
                    <label>
                        <input type="checkbox" checked="checked" name="remember" class="remember-checkbox"> Remember me
                    </label>
                </div>
            </div>
            <div class="auth-action">
                <button class="register">Register</button>
                <button class="login">Login</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index"
}
</script>

<style scoped>

</style>
