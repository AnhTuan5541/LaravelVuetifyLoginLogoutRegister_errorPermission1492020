<template>
    <div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" v-model="user.name" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" v-model="user.email" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" v-model="user.password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" v-model="user.confirm_password" placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn btn-primary" @click="register">Register</button>
    </div>
</template>

<script>
    export default {
        data: () => ({
            user: {
                name: '',
                email: '',
                password: '',
                confirm_password: ''
            }
        }),
        methods: {
            register() {
                this.$store.dispatch('currentUser/registerUser', this.user)
            }
        }
    }
</script>
