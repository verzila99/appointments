<template>

    <div class = "flex flex-col justify-between items-start space-y-6 w-80 p-5">

        <label for = "name">Name</label>
        <div class = "flex  items-center rounded-md h-8 relative w-full">
            <i class = "bx bx-user text-gray-500 text-xl absolute left-1.5 top-1/2 transform -translate-y-2/4"></i>
            <input class = " rounded-lg outline-none focus:border-blue-400 border-2 border-solid border-opacity-40 py-2 pl-9 w-full"
                   id = "name"
                   name = "name"
                   type = "text"
                   v-model = "name"
                   placeholder = "Enter your name">
        </div>
        <template v-if = "error.errors && error.errors.name">
            <p v-for = "error in  error.errors.name"
               class = "text-red-600">{{ error }}</p>
        </template>
        <label for = "email">Email</label>
        <div class = "flex  items-center rounded-md h-8 relative w-full">
            <i class = "bx bx-at text-gray-500 text-xl  absolute left-1.5 top-1/2 transform -translate-y-2/4"></i>
            <input class = " rounded-lg outline-none focus:border-blue-400 border-2 border-solid border-opacity-40 py-2 pl-9 w-full"
                   id = "email"
                   name = "email"
                   type = "text"
                   v-model = "email"
                   placeholder = "Enter your email">
        </div>
        <template v-if = "error.errors && error.errors.email">
            <p v-for = "error in  error.errors.email"
               class = "text-red-600">{{ error }}</p>
        </template>
        <label for = "password">Password</label>
        <div class = "flex  items-center  rounded-md h-8 relative w-full">
            <i class = "bx bxs-lock text-gray-500 text-xl  absolute left-1.5 top-1/2 transform -translate-y-2/4"></i>
            <input class = " rounded-lg outline-none focus:border-blue-400 border-2 border-solid border-opacity-40 py-2 pl-9 w-full"
                   id = "password"
                   name = "password"
                   type = "password"
                   v-model = "password"
                   placeholder = "Enter password">
        </div>
        <label for = "confirmed_password">Confirm password</label>
        <div class = "flex  items-center  rounded-md h-8 relative w-full">
            <i class = "bx bxs-lock text-gray-500 text-xl  absolute left-1.5 top-1/2 transform -translate-y-2/4"></i>
            <input class = " rounded-lg outline-none focus:border-blue-400 border-2 border-solid border-opacity-40 py-2 pl-9 w-full"
                   id = "confirmed_password"
                   name = "password_confirmation"
                   v-model = "password_confirmation"
                   type = "password"
                   placeholder = "Enter password again">
        </div>
        <template v-if = "error.errors && error.errors.password">
            <p v-for = "error in  error.errors.password"
               class = "text-red-600">{{ error }}</p>
        </template>
        <a class = "btn bg-primary text-blue-50"
           @click = "register">Sign up</a>
        <div class = "flex justify-between items-center w-full">
            <a class = "text-link hover:text-hover cursor-pointer">Forgot password?</a>
            <a @click = "$emit('switch-to-login')"
               class = "text-link hover:text-hover cursor-pointer">Sign in</a>
        </div>
    </div>
</template>

<script>

export default {
    name: "RegisterModal",
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            error: ''
        }
    },
    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    }
                ).then(response => {
                    if (response.status === 200) {
                        this.$emit('register', response.data.name);
                        this.openNotification('success', 'Registration successful!', 'top-right',);
                    }
                })
                     .catch(error => {
                         console.log(error.response);
                         this.error = error.response.data;
                     });
            });
        },
        openNotification(color, title, position = null) {
            const noti = this.$vs.notification({
                color,
                title,
                position,
            });
            noti.close()
        }
    }


}
</script>

<style>

</style>
