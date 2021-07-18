<template>
    <div>
        <transition name = "modal">
            <modal @close-modal = "closeModal"
                   @register = "register"
                   @login = "login"
                   v-if = "active"></modal>
        </transition>

        <navbar @activate-login-modal = "activateModal"

                @open-sidebar = "openSidebar"
                @user-data = "login"
                :username = "username"
                :image-user = "userImage"></navbar>
        <router-view></router-view>

        <sidebar :sidebar-active = "activeSidebar"
                 @closing-sidebar = "closingSidebar"
                 :nickname = "username"
                 @logout = "logout"
        ></sidebar>
    </div>
</template>
<script>
import Navbar   from "./components/Navbar";
import Modal    from "./components/Modal";
import Schedule from "./components/Schedule";
import Sidebar  from "./components/Sidebar";

export default {
    data() {
        return {
            active: false,
            username: "",
            userImage: "",
            activeSidebar: false,
        };
    },
    props: {
        activeModal: '',
    },
    components: {
        Navbar,
        Modal,
        Schedule,
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
        },
        openSidebar: function () {

            this.activeSidebar = true;
        },
        closingSidebar: function () {
            this.activeSidebar = false;
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
