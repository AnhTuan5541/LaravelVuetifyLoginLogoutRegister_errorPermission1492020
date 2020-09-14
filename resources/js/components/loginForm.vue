<template>
    <div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" v-model="user.email" aria-describedby="emailHelp" placeholder="Enter email" @keyup.enter="login">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" v-model="user.password" placeholder="Password" @keyup.enter="login">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary" @click="login">Submit</button>
    </div>
</template>

<script>
    export default {
        data: () => ({
            user: {
                email: '',
                password: '',
            }
        }),
        methods: {
            login() {
                this.$store.dispatch('currentUser/loginUser', this.user)
            }
        }
    }
</script>
