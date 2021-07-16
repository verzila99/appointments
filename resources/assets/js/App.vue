<template>
    <div>
        <transition name = "modal">
            <modal @close-modal = "closeModal" @register = "register" @login = "login" v-if = "active"></modal>
        </transition>

        <navbar @activate-login-modal = "activateModal"
                @logout = "logout"
                :username = "username"
                :user-image = "userImage"></navbar>
        <appointments></appointments>
    </div>
</template>
<script>
import Navbar       from "./components/Navbar";
import Modal        from "./components/Modal";
import Appointments from "./components/Appointments";

export default {
    data() {
        return {
            active: false,
            username: "",
            userImage: "",
        };
    },
    props: {
        activeModal: '',
    },
    components: {
        Navbar,
        Modal,
        Appointments,

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
            this.closeModal();
        },
        login: function (val) {
            this.username = val[0];
            this.userImage = val[1];
            this.closeModal();
        },
        logout: function () {
            this.username = '';
            this.userImage = '';
        }
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
<style lang = "scss" scoped>
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
