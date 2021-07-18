require("./bootstrap");
import Vuesax       from 'vuesax';
import Vue          from "vue";
import VueRouter    from 'vue-router';
import App          from "./App.vue";
import 'vuesax/dist/vuesax.css';
import 'boxicons/css/boxicons.min.css';
import Profile      from "./components/Profile";
import Appointments from "./components/Appointments";
import Schedule     from "./components/Schedule";
import Home         from "./components/Home";

Vue.use(VueRouter);
Vue.use(Vuesax, {
    // options here
});

const router = new VueRouter({
    routes: [
        {path: '/', component: Home},
        {path: '/appointments', component: Appointments},
        {path: '/profile', component: Profile},
        {path: '/schedule', component: Schedule},
    ]
})


const app = new Vue({
    el: "#app",
    router,
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
