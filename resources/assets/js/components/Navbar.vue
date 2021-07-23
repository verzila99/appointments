<template>
    <div>
        <div class = "container shadow-sm flex justify-around align items-center h-20 bg-white">

            <router-link to = "/"
                         class = "logo text-6xl text-gray-600"><i class = "bx bx-dumbbell"></i></router-link>
            <nav>
                <ul class = "flex justify-around align items-center">
                    <li>
                        <router-link to = "/schedule"
                                     class = "text-black hover:text-gray-300 font-bold">
                            Schedule
                        </router-link>

                    </li>
                </ul>
            </nav>
            <div class = "navbar-right flex justify-around items-center ">

                <div v-if = "nickname"
                     class = "flex justify-between items-center gap-4">
                    <div class = "flex justify-around items-center gap-4">
                        <vs-avatar class = "capitalize"
                                   size = "40"
                                   color = "#7d33ff">
                            <template>
                                {{ nickname[0] }}
                            </template>
                        </vs-avatar>
                        <a
                            class = "a-icon capitalize cursor-pointer"> {{ nickname }}</a>
                        <a v-if = "role && role > 0"
                           class = "mx-4 text-gray-800 hover:text-gray-400 "
                           href = "/admin">Admin panel</a>

                    </div>
                </div>

                <button v-else-if = "guest"
                        class = "btn bg-primary text-blue-50"
                        @click = "activateLoginModal">Login
                </button>

            </div>

        </div>

    </div>
</template>

<script>

export default {
    name: "Navbar",
    data() {
        return {
            active: false,
            nickname: '',
            userImage: '',
            role: Number,
            guest: false,
        }
    },
    props: {
        username: String,
        imageUser: String
    },
    emits: {
        'user-data': Object,
        'activate-login-modal': '',
    },
    methods: {
        activateLoginModal: function () {
            this.$emit('activate-login-modal')
        },

    },
    beforeCreate: function () {
        axios.get('sanctum/csrf-cookie').then(() => {
            axios.get('api/profile').then(response => {
                if (response.status === 200 && response.data !== 'guest') {
                    this.nickname = response.data.name;
                    this.userImage = response.data.image;
                    this.role = +response.data.role;
                    this.$emit('user-data', {username: this.nickname, image: this.userImage, role: this.role});
                } else {
                    this.guest = true;
                }
            }).catch(error => {
                this.guest = true;
                console.log(error);
            })
        })
    },
    watch: {
        username: function () {
            if (this.username === '') {
                this.guest = true;
            }
            this.nickname = this.username;

        },
        imageUser: function () {
            this.userImage = this.imageUser;
        }
    }
}
</script>

<style scoped>

</style>
