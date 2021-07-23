<template>

    <vs-sidebar v-if = "username"
                absolute
                reduce
                hover-expand
                v-model = "active"
                open>
        <template #logo>
            <!-- ...img logo -->
        </template>

        <vs-sidebar-item id = "home"
                         to = "/"
                         class = "w-full">
            <template #icon>
                <i class = "bx bx-home"></i>
            </template>
            Home
        </vs-sidebar-item>

        <vs-sidebar-item id = "schedule"
                         to = "/schedule"
                         class = "w-full">
            <template #icon>
                <i class = "bx bxs-calendar"></i>
            </template>
            Schedule
        </vs-sidebar-item>
        <vs-sidebar-item id = "profile"
                         to = "/profile"
                         class = "w-full">
            <template #icon>
                <i class = "bx bxs-user"></i>
            </template>
            Profile
        </vs-sidebar-item>

        <vs-sidebar-item id = "appointments"
                         to = "/appointments"
                         class = "w-full">
            <template #icon>
                <i class = "bx bx-dumbbell"></i>
            </template>
            My appointments
        </vs-sidebar-item>

        <vs-sidebar-item v-if = "role && role > 0"
                         id = "instructors"
                         to = "/instructors">
            <template #icon>
                <i class = "bx bx-run"></i>
            </template>
            Instructors
        </vs-sidebar-item>
        <vs-sidebar-item v-if = "role && role > 0"
                         id = "all_appointments"
                         to = "/all_appointments">
            <template #icon>
                <i class = "bx bx-calendar-event"></i>
            </template>
            All appointments
        </vs-sidebar-item>
        <vs-sidebar-item
            v-if = "role && role > 1"
            id = "users"
            to = "/users">
            <template #icon>
                <i class = "bx bx-user"></i>
            </template>
            Users
        </vs-sidebar-item>

        <div class = "border-b-2 w-full border-gray-200  my-4">

        </div>

        <div @click = "logout"
             class = "w-full">
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

            </vs-row>
        </template>
    </vs-sidebar>

</template>

<script>
export default {
    data() {
        return {
            active: '',
            username: '',

        }
    },
    name: "Sidebar",
    props: {
        nickname: String,
        role: Number,
    },
    methods: {
        logout: function () {
            const loading = this.$vs.loading({color: '#48CAE4'});
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.get('/api/logout').then(response => {

                    if (response.status === 200) {
                        this.$emit('logout');
                        this.username = '';
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

        nickname: function () {
            this.username = this.nickname
        }
    },

}
</script>

<style scoped>

</style>
