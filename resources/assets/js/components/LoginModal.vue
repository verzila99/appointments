<template>
    <div class = "flex flex-col justify-between items-start space-y-4 w-80 p-5">

        <label for = "email">Email</label>
        <div class = "flex  items-center rounded-md h-8 relative w-full">
            <i class = "bx bx-at text-gray-500 text-xl  absolute left-1.5 top-1/2 transform -translate-y-2/4"></i>
            <input class = " rounded-lg outline-none focus:border-blue-400 border-2 border-solid border-opacity-40 py-2 pl-9 w-full"
                   :class = "{'border-red-600':error.errors && error.errors.email || !error.message && error}"
                   id = "email"
                   name = "email"
                   type = "text"
                   v-model = "email"
                   placeholder = "Enter your name">
        </div>

        <template v-if = "error.errors && error.errors.email">
            <p v-for = "error in  error.errors.email"
               class = "text-red-600">{{ error }}</p>
        </template>

        <label for = "password">Password</label>
        <div class = "flex  items-center  rounded-md h-8 relative w-full">
            <i class = "bx bxs-lock text-gray-500 text-xl  absolute left-1.5 top-1/2 transform -translate-y-2/4"></i>
            <input class = " rounded-lg outline-none focus:border-blue-400 border-2 border-solid border-opacity-40 py-2 pl-9 w-full"
                   :class = "{'border-red-600':error.errors && error.errors.password || !error.message && error}"
                   id = "password"
                   name = "password"
                   type = "password"
                   v-model = "password"
                   placeholder = "Enter password">
        </div>
        <template v-if = "error.errors && error.errors.password">
            <p v-for = "error in  error.errors.password"
               class = "text-red-600">{{ error }}</p>
        </template>
        <p v-else-if = "!error.message"
           class = "text-red-600">{{ error }}</p>
        <vs-checkbox color = "#48CAE4"
                     v-model = "remember_token">
            Remember me
        </vs-checkbox>
        <a class = "btn bg-primary text-blue-50"
           @click = "login">Sign in</a>
        <div class = "flex justify-between items-center w-full">
            <a class = "text-link hover:text-hover cursor-pointer">Forgot password?</a>
            <a @click = "$emit('switch-to-register')"
               class = "text-link hover:text-hover cursor-pointer">Register</a>
        </div>
    </div>

</template>

<script>

export default {
    name: "LoginModal",
    data() {
        return {
            email: '',
            password: '',
            remember_token: false,
            error: '',
        };
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                    remember_token: this.remember_token,
                }).then(response => {
                    if (response.status === 200) {
                        this.$emit('login', {
                            username: response.data.name, image: response.data.image, role:
                                +response.data.role
                        })
                    }
                }).catch(error => {
                    this.error = error.response.data;
                });
            });
        }
    }
}
</script>

<style>

</style>
