<template>

    <vs-sidebar absolute
                :open.sync = "activeSidebar">
        <template #logo>
            <!-- ...img logo -->
        </template>
        <vs-sidebar-item id = "home"
                         class = "mt-20">
            <template #icon>
                <i class = "bx bx-home"></i>
            </template>
            <router-link to = "/">
                Home
            </router-link>
        </vs-sidebar-item>
        <vs-sidebar-item id = "profile">
            <template #icon>
                <i class = "bx bxs-user"></i>
            </template>
            <router-link to = "/profile">
                Profile
            </router-link>
        </vs-sidebar-item>

        <vs-sidebar-item id = "appointments">
            <template #icon>
                <i class = "bx bx-dumbbell"></i>
            </template>
            <router-link to = "/appointments">
                Appointments
            </router-link>
        </vs-sidebar-item>

        <div class = "border-b-2 w-full border-gray-200  my-4">

        </div>

        <div @click = "logout">
            <vs-sidebar-item id = "logout"
            >
                <template #icon>
                    <i class = "bx bx-log-out"></i>
                </template>
                Logout
            </vs-sidebar-item>
        </div>

        <template #footer>
            <vs-row justify = "space-between">
                <vs-avatar class = "capitalize"
                           size = "40"
                           color = "#7d33ff">
                    <template>
                        {{ nickname[0] }}
                    </template>
                </vs-avatar>

                <vs-avatar badge-color = "danger"
                           badge-position = "top-right">
                    <i class = "bx bx-bell"></i>

                </vs-avatar>
            </vs-row>
        </template>
    </vs-sidebar>

</template>

<script>
export default {
    data() {
        return {
            active: '',
            activeSidebar: false,

        }
    },
    name: "Sidebar",
    props: {
        sidebarActive: Boolean,
        nickname: String,
    },
    methods: {
        logout: function () {
            const loading = this.$vs.loading({color: '#48CAE4'});
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.get('/api/logout').then(response => {

                    if (response.status === 200) {
                        this.$emit('logout');
                        this.activeSidebar = false;
                    }
                    loading.close();
                }).catch(error => {
                    console.log(error.response);
                    loading.close();
                })
            })
        },
    },
    watch: {
        sidebarActive: function () {
            this.activeSidebar = this.sidebarActive;


        },
        activeSidebar: function () {
            if (this.activeSidebar === false) {
                this.$emit('closing-sidebar');

            }

        },
    },

}
</script>

<style scoped>

</style>
