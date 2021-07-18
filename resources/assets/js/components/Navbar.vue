<template>
    <div>
        <div class = "container flex justify-around align items-center h-20 bg-white">

            <div class = "logo"></div>
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
                        <a @click = "openSidebar"
                           class = "a-icon capitalize cursor-pointer"> {{ nickname }}</a>

                    </div>
                </div>

                <button v-else
                        class = "btn bg-primary"
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
            userImage: ''
        }
    },
    props: {
        username: String,
        imageUser: String
    },
    methods: {
        activateLoginModal: function () {
            this.$emit('activate-login-modal')
        },

        openSidebar: function () {
            this.$emit('open-sidebar');
        }
    },
    beforeCreate: function () {
        axios.get('sanctum/csrf-cookie').then(() => {
            axios.get('api/show').then(response => {
                if (response.status === 200) {
                    this.nickname = response.data.name;
                    this.userImage = response.data.image;
                    this.$emit('user-data', [this.nickname, this.userImage]);
                }
            }).catch(error => console.log(error.response))
        })
    },
    watch: {
        username: function () {
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
