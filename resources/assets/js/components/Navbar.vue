<template>
    <div>
        <div class = "container flex justify-around align items-center h-20 bg-white">

            <div class = "logo"></div>
            <nav>
                <ul class = "flex justify-around align items-center">
                    <li><a href = "" class = "text-black hover:text-gray-300 font-bold">Make a appointment</a></li>
                </ul>
            </nav>
            <div class = "navbar-right flex justify-around items-center ">

                <div v-if = "nickname" class = "flex justify-between items-center gap-4">
                    <div class = "flex justify-around items-center gap-4">
                        <vs-avatar class = "capitalize" size = "40" color = "#7d33ff">
                            <template>
                                {{ nickname[0] }}
                            </template>
                        </vs-avatar>
                        <a class = "a-icon capitalize" href = "#"> {{ nickname }}</a>

                    </div>

                    <button class = "btn bg-primary" @click = "logout">Logout
                    </button>
                </div>

                <button v-else class = "btn bg-primary" @click = "activateLoginModal">Login
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
        }
    },
    props: {
        username: String,
    },
    methods: {
        activateLoginModal: function () {
            this.$emit('activate-login-modal')
        },
        logout: function () {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.get('/api/logout').then(response => {
                    if (response.status === 200) {
                        this.nickname = '';
                        this.userImage = '';
                        this.$emit('logout');
                    }
                }).catch(error => console.log(error.response))
            })
        }
    },
    beforeCreate: function () {
        axios.get('sanctum/csrf-cookie').then(() => {
            axios.get('api/show').then(response => {
                if (response.status === 200) {
                    this.nickname = response.data.name;
                    this.userImage = response.data.image;
                }
            }).catch(error => console.log(error.response))
        })
    },
    watch: {
        username: function () {
            this.nickname = this.username;
        }
    }
}
</script>

<style scoped>

</style>
