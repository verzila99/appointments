<template>
    <div class = "container flex h-screen justify-center items-center">

        <div class = "center w-2/3">
            <vs-table striped
                      class = "appointments flex flex-col justify-between items-center">
                <template #thead>
                    <vs-tr>
                        <vs-th>
                            Instructor
                        </vs-th>
                        <vs-th class = "w-24"
                               sort
                               @click = "appointments = $vs.sortData($event ,appointments, 'start_time')">
                            Date
                        </vs-th>
                        <vs-th>
                            Time
                        </vs-th>
                        <vs-th>
                            Delete
                        </vs-th>
                    </vs-tr>
                </template>
                <template #tbody>
                    <vs-tr
                        :key = "i"
                        v-for = "(appointment, i) in $vs.getPage(appointments, page, itemsPerPage)"

                    >
                        <vs-td>
                            {{ appointment.instructor.name }}
                        </vs-td>
                        <vs-td>
                            {{ appointment.start_time.replace(/-+/g, '.').split(' ')[0] }}
                        </vs-td>
                        <vs-td>
                            {{ appointment.start_time.replace('-', '.').split(' ')[1].slice(0, 5) }}
                        </vs-td>
                        <vs-td>
                            <a class = "btn bg-danger text-blue-50"
                               :data-id = "appointment.id"
                               @click = " confirmDeleting($event)">
                                Delete</a>
                        </vs-td>
                    </vs-tr>
                </template>
                <template #footer>
                    <vs-pagination v-model = "page"
                                   :length = "$vs.getLength(appointments, itemsPerPage)" />
                </template>
            </vs-table>
        </div>
        <vs-dialog width = "450px"
                   class = "px-6"
                   not-center
                   v-model = "activeDialog">
            <template #header>
                <h4 class = "flex  justify-center items-center text-xl mt-4">Confirm deleting</h4>
            </template>
            <div class = "con-content flex flex-col justify-between items-start my-3">
                <div class = "flex justify-center items-center w-full">
                    <strong class = "text-2xl">Are you sure?</strong>
                </div>

            </div>
            <template #footer>
                <div class = "con-footer flex gap-4 justify-end items-center mb-3">
                    <a class = "btn bg-primary text-blue-50 w-20"
                       @click = "deleteAppointment"
                    >
                        Ok
                    </a>
                    <a class = "btn bg-white w-20 text-black"
                       @click = "activeDialog=false"
                    >
                        Cancel
                    </a>
                </div>
            </template>
        </vs-dialog>
    </div>
</template>

<script>
export default {
    name: "Appointments",
    data() {
        return {
            appointments: [],
            page: 1,
            itemsPerPage: 7,
            activeDialog: false,
            deletingId: Number,
        }
    },

    methods: {
        confirmDeleting(event) {
            this.deletingId = event.target.dataset.id;
            this.activeDialog = true;
        },
        deleteAppointment() {
            const loading = this.$vs.loading({color: '#48CAE4'});
            this.activeDialog = false;
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.delete('/api/appointments/' + this.deletingId).then((response) => {
                    if (response.status === 200) {
                        this.appointments = this.appointments.filter(item => +item.id !== +this.deletingId);
                    }

                    loading.close();
                    this.openNotification('success', 'Appointment deleted.', 'top-right');
                }).catch(error => {
                    loading.close();
                    if (error.message === 'Request failed with status code 403' ||
                        error.message === 'Request failed with status code 401') {
                        this.openNotification('danger', 'You need to sign in', 'top-right',);
                    } else {
                        this.openNotification('danger', 'Something goes wrong, try later.', 'top-right',);
                    }
                    console.log(error);


                });
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
    beforeCreate: function () {

        const loading = this.$vs.loading({color: '#48CAE4'});

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.get('/api/appointments').then((response) => {
                if (response.status === 200) {
                    this.appointments = response.data;
                }
                loading.close();
            }).catch(error => {
                loading.close();
                if (error.message === 'Request failed with status code 403') {
                    this.openNotification('danger', 'You need to sign in', 'top-right',);
                }
                console.log(error)
            });
        })
    },
}
</script>

<style scoped>

</style>
