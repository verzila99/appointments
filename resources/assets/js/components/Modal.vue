<template>
    <div class = "modal  absolute shadow-2xl
rounded-lg bg-white">
        <div class = "close absolute text-2xl cursor-pointer right-0 top-0 transform bg-white rounded-lg drop-shadow-lg hover:scale-110 transition-all duration-300 ease-out flex justify-center items-center"
             @click = "$emit('close-modal')">
            <i class = "bx bx-x"></i></div>
        <transition name = "login" mode = "out-in">
            <login-modal @switch-to-register = "switchRegister" v-if = "modal==='login'"></login-modal>
            <register-modal @switch-to-login = "switchLogin" v-else></register-modal>
        </transition>
    </div>
</template>

<script>
import LoginModal    from "./LoginModal";
import RegisterModal from "./RegisterModal";

export default {

    data() {
        return {
            modal: 'login',
        }
    },
    components: {
        LoginModal,
        RegisterModal
    },
    methods: {
        switchRegister: function () {
            this.modal = 'register'
        },
        switchLogin: function () {
            this.modal = 'login'
        },
    }


}
</script>

<style lang = "scss" scoped>
.login-enter-active {
    animation: fading .3s ease-out forwards;
}

.login-leave-active {
    animation: fading .3s ease-out reverse;
}

@keyframes fading {
    0% {
        opacity: 0;

    }
    100% {
        opacity: 1;
    }
}
</style>
