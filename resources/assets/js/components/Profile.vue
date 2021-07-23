<template>
    <div class = "container flex h-screen justify-center items-center">

        <div class =
                 "center w-128 p-10 flex flex-col justify-between items-start gap-6 border-2 border-gray-100 rounded-lg">
            <div
                class = "w-full flex justify-between items-center">
                <div class = "flex gap-6 items-center"><i class = "bx bxs-user text-2xl"></i><strong>Name:</strong>
                </div>
                <div class = "w-1/2 flex justify-between gap-6 items-center"><strong>{{ profile.name }}</strong>
                    <a href = ""
                       @click.prevent = "modal=true"
                       class = "btn bg-success text-blue-50">Edit</a></div>
            </div>
            <div
                class = "w-full flex justify-between items-center">
                <div class = "flex gap-6 items-center"><i class = "bx bxs-envelope text-2xl"></i><strong>Email:</strong>
                </div>
                <strong class = "w-1/2">{{ profile.email }}</strong>
            </div>
            <div
                class = "w-full flex justify-between items-center">
                <div
                    class = "flex gap-6 items-center">
                    <i class = "bx bxs-calendar text-2xl"></i>
                    <strong>Date of registration:</strong>
                </div>
                <strong class = "w-1/2">{{ profile.created_at }}</strong>
            </div>
        </div>
        <vs-dialog width = "300px"
                   v-model = "modal">
            <template #header>
                <h4 class = "not-margin">
                    <b>Edit your Name</b>
                </h4>
            </template>

            <div class = "con-content w-full">
                <vs-input v-model = "profile.name"
                          placeholder = "Name"
                          @keypress.enter = "updateName"
                          class = "w-full"
                ></vs-input>
            </div>

            <template #footer>
                <div class = "con-footer flex justify-center items-center gap-6">
                    <vs-button @click = "updateName"
                               transparent>
                        Ok
                    </vs-button>
                    <vs-button @click = "modal=false"
                               dark
                               transparent>
                        Cancel
                    </vs-button>
                </div>
            </template>
        </vs-dialog>
    </div>
</template>

<script>
export default {
    name: "Profile",
    data() {
        return {
            profile: {},
            modal: false,
        }
    },
    methods: {
        updateName() {
            this.modal = false;
            const load = this.$vs.loading({color: '#48CAE4'});
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.put('/api/profile', {
                    name: this.profile.name
                }).then((response) => {
                    if (response.status === 200) {
                        this.profile.name = response.data.name;
                        this.openNotification('success', 'Profile updated.', 'top-right');
                    }
                    load.close();
                }).catch(error => {
                        load.close();
                        if (error.message === 'Request failed with status code 403' ||
                            error.message === 'Request failed with status code 401') {
                            this.openNotification('danger', 'You need to sign in', 'top-right',);
                        } else if (error.response.data.errors) {

                            const errors = error.response.data.errors;

                            if (errors.name) {
                                errors.name.forEach((i) => {
                                    this.openNotification('danger', i, 'top-right',)
                                })
                            }
                        } else {
                            this.openNotification('danger', 'Something goes wrong, try later.', 'top-right',);
                        }
                        console.log(error)
                    }
                );
            })
        },
        openNotification(color, title, position = null) {
            const not = this.$vs.notification({
                color,
                title,
                position,

            });
            not.close()
        },

    },
    beforeCreate() {
        const loading = this.$vs.loading({color: '#48CAE4'});

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.get('/api/profile').then((response) => {
                if (response.status === 200) {
                    this.profile = response.data;

                }
                loading.close();
            }).catch(error => {
                loading.close();
                if (error.message === 'Request failed with status code 403') {
                    this.openNotification('danger', 'You need to sign in', 'top-right',);
                } else {
                    this.openNotification('danger', 'Something goes wrong, try later.', 'top-right',);
                }
                console.log(error)
            });
        })
    }
}
</script>

<style scoped>

</style>
