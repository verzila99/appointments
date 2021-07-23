import Vuesax          from 'vuesax';
import Vue             from "vue";
import VueRouter       from 'vue-router';
import App             from "./App.vue";
import 'vuesax/dist/vuesax.css';
import 'boxicons/css/boxicons.min.css';
import Profile         from "./components/Profile";
import Appointments    from "./components/Appointments";
import Schedule        from "./components/Schedule";
import Home            from "./components/Home";
import Instructors     from "./components/Admin/Instructors";
import AllAppointments from "./components/Admin/AllAppointments";
import Users           from "./components/Admin/Users";
import VueCookies      from 'vue-cookies'

Vue.use(VueCookies)

require("./bootstrap");

Vue.use(VueRouter);
Vue.use(Vuesax, {
    colors: {
        white: '#FFFFFF',
        grey: '#EBEBEB',
        primary: '#48CAE4',
        link: '#0096c7',
        hover: '#0077b6',
        success: '#A2D729',
        danger: 'rgb(242, 19, 93)',
        warning: 'rgb(255, 130, 0)',
        dark: '#293241'
    },
});


const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', component: Home},
        {path: '/appointments', component: Appointments},
        {path: '/profile', component: Profile},
        {path: '/schedule', component: Schedule},
        {
            path: '/instructors', component: Instructors,
            beforeEnter: (to, from, next) => {
                if (to.path === '/instructors' && !$cookies.get('logged') ||
                    to.path === '/instructors' && +$cookies.get('role') === 0) {
                    next({path: '/'});
                } else next();
            },
        },
        {
            path: '/all_appointments', component: AllAppointments,
            beforeEnter: (to, from, next) => {
                if (to.path === '/all_appointments' && !$cookies.get('logged') ||
                    to.path === '/all_appointments' && +$cookies.get('role') === 0) {
                    next({path: '/'});
                } else next();
            },
        },
        {
            path: '/users',
            component: Users,
            beforeEnter: (to, from, next) => {
                if (to.path === '/users' && !$cookies.get('logged') ||
                    to.path === '/users' && +$cookies.get('role') !== 2) {
                    next({path: '/'});
                } else next();
            },
        }

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
            modal: true,
            logged_in: false,
            role: null,
        }
    },
    methods: {
        closeModal: function () {
            this.modal = !this.modal;
        },
        login: function (val) {
            Vue.$cookies.set('logged', 'true');
            Vue.$cookies.set('role', val.role);
        },
        logout: function () {
            $cookies.remove('logged');
            $cookies.remove('role');

        }
    }
});
