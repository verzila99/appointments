<template>
    <div>
        <div class = "container flex justify-around align items-center h-20 bg-white">

            <div class = "logo"></div>
            <nav>
                <ul class = "flex justify-around align items-center">
                    <li><a href = "" class = "text-black hover:text-gray-300 font-bold">Make a appointment</a></li>
                </ul>
            </nav>
            <div class = "navbar-right flex justify-around items-center ">
                <button class = "btn bg-primary" @click = "activateLoginModal">Login
                </button>
            </div>

        </div>

    </div>
</template>

<script>

export default {
    name: "Navbar",
    data() {
        return {
            active: false,
            email: '',
            password: '',
            remember: false,
        }
    },
    methods: {
        activateLoginModal: function () {
            this.$emit('activate-login-modal')
        }
    }
}
</script>

<style scoped>

</style>
