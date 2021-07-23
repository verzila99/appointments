<template>
    <div>
        <transition name = "modal">
            <modal @close-modal = "closeModal"
                   @register = "register"
                   @login = "login"
                   v-if = "active"></modal>
        </transition>

        <navbar @activate-login-modal = "activateModal"
                @user-data = "login"
                :username = "username"
                :image-user = "userImage"></navbar>
        <router-view @open-modal = "activateModal"
                     :username = "username"
                     :role = "role"></router-view>

        <sidebar
            :nickname = "username"
            :role = "role"
            @logout = "logout"
        ></sidebar>
    </div>
</template>
<script>
import Navbar  from "./components/Navbar";
import Modal   from "./components/Modal";
import Sidebar from "./components/Sidebar";

export default {
    data() {
        return {
            active: false,
            username: "",
            userImage: "",
            role: 0,
        };
    },
    props: {
        activeModal: '',
    },
    emits: {
        login: {}
    },
    components: {
        Navbar,
        Modal,
        Sidebar
    },
    methods: {
        activateModal: function () {
            this.active = true;
            document.querySelector('#overlay').classList.add('show-login-modal');

        },
        closeModal: function () {
            this.active = false;
            document.querySelector('#overlay').classList.remove('show-login-modal');
        },
        register: function (val) {
            this.username = val;
            this.role = val.role;
            this.$emit('login', val);
            this.closeModal();
        },
        login: function (val) {
            this.username = val.username;
            this.role = val.role;
            this.$emit('login', val);
            this.closeModal();
        },
        logout: function () {
            this.username = '';
            this.userImage = '';
            this.$router.push('/');
        },
    },
    watch: {
        activeModal: function () {
            this.active = false;
            this.closeModal();
            console.log(this.activeModal);
        }
    }
}
</script>
<style lang = "scss"
       scoped>
.modal-enter-active {
    animation: modal .3s ease-out forwards;
}

.modal-leave-active {
    animation: modal .3s ease-out reverse;
}

@keyframes modal {
    0% {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    100% {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}
</style>
