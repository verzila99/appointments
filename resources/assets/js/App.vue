<template>
    <div>
        <transition name = "modal">
            <modal @close-modal = "closeModal" v-if = "active"></modal>
        </transition>

        <navbar @activate-login-modal = "activateModal"></navbar>
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
            active: false
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
            document.querySelector('body').classList.add('clipped');
            document.querySelector('#overlay').classList.add('show-login-modal');

        },
        closeModal: function () {
            this.active = false;
            document.querySelector('body').classList.remove('clipped');
            document.querySelector('#overlay').classList.remove('show-login-modal');
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
