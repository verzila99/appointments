require("./bootstrap");

import Vuesax from 'vuesax'
import Vue    from "vue";
import App    from "./App.vue";
import 'vuesax/dist/vuesax.css' //Vuesax styles
import 'boxicons/css/boxicons.min.css';


Vue.use(Vuesax, {
    // options here
})

const app = new Vue({
    el: "#app",
    components: {
        App,
    },
    data() {
        return {
            modal: true
        }
    },
    methods: {
        closeModal: function () {
            this.modal = !this.modal;
            console.log(234);
        }
    }
});
