<template>
    <div class = "container  pt-16 h-screen flex flex-col items-end gap-6">
        <vs-table>
            <template #header>

                <div class = " w-72 flex justify-end items-center gap-4 ">
                    <vs-input v-model = "date"
                              type = "date"
                              border
                              placeholder = "choose day" />
                    <a @click.prevent = "date=''"
                       class = "btn bg-primary text-blue-50">Clear</a>
                </div>

                <div class = " w-72 flex justify-end items-center gap-6 my-8">
                    <vs-select v-if = "instructors.length > 0"
                               placeholder = "Select instructor"
                               v-model = "instructor"
                    >

                        <vs-option v-for = "instructor in instructors"
                                   :label = " instructor.name"
                                   :key = "instructor.id"
                                   :value = "instructor.name">
                            {{ instructor.name }}
                        </vs-option>
                    </vs-select>
                    <a @click.prevent = "instructor=''"
                       class = "btn bg-primary text-blue-50">Clear</a>
                </div>
            </template>
            <template #thead>
                <vs-tr>
                    <vs-th>
                        Id
                    </vs-th>
                    <vs-th sort
                           @click = "appointments = compare()">
                        Instructor
                    </vs-th>
                    <vs-th sort
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
                    v-for = "(appointment, i) in
                    $vs.getPage(mergeSearch($vs.getSearch(appointments, date),
                        $vs.getSearch(appointments,instructor))
                , page, itemsPerPage)"

                >
                    <vs-td>
                        {{ appointment.id }}
                    </vs-td>
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
                        <div
                            :data-id = "appointment.id"
                            @click = "confirmDeleting($event) "
                            class = "btn bg-danger text-blue-50 ">Delete
                        </div>
                    </vs-td>
                </vs-tr>
            </template>
            <template #footer>
                <vs-pagination v-model = "page"
                               :length = "$vs.getLength(mergeSearch($vs.getSearch(appointments, date),
                        $vs.getSearch(appointments,instructor)), itemsPerPage)" />
            </template>
        </vs-table>
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
    name: "AllAppointments",
    data() {
        return {
            appointments: [],
            page: 1,
            itemsPerPage: 10,
            date: '',
            search: '',
            instructors: [],
            instructor: '',
            sorting: false,
            deletingId: Number,
            activeDialog: false,
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
        compare() {
            this.sorting = !this.sorting;
            if (this.sorting) {
                return this.appointments.sort((a, b) => {
                    if (a.instructor.name[0] < b.instructor.name[0]) {
                        return -1;
                    }
                    if (a.instructor.name[0] > b.instructor.name[0]) {
                        return 1;
                    }
                    return 0;
                })

            } else {
                return this.appointments.sort((a, b) => {
                    if (a.instructor.name[0] < b.instructor.name[0]) {
                        return 1;
                    }
                    if (a.instructor.name[0] > b.instructor.name[0]) {
                        return -1;
                    }
                    return 0;
                })
            }
        },

        mergeSearch(array1, array2) {
            let result = [];
            for (const el of array1) {
                for (const item of array2) {
                    if (el.id === item.id) {
                        result.push(el);
                    }
                }
            }

            return result;
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
    watch: {

        date() {
            this.page = 1;
        },
        instructor() {
            this.page = 1;
        }
    },
    beforeCreate: function () {

        const loading = this.$vs.loading({color: '#48CAE4'});

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.get('/api/all_appointments').then((response) => {
                if (response.status === 200) {
                    console.log(response.data);
                    this.appointments = response.data.appointments;
                    this.instructors = response.data.instructors;
                }
                loading.close();
            }).catch(error => {
                loading.close();

                if (error.response.status === 403 || error.response.status === 401) {
                    this.openNotification('danger', 'You don\'t have permission on this action', 'top-right',);
                } else if (error.response.status === 400) {
                    this.openNotification('danger', error.response.data, 'top-right',);
                } else {
                    this.openNotification('danger', 'Something goes wrong, try later.', 'top-right',);
                }

                console.log(error);
            });
        })

    }
}
</script>

<style scoped>

</style>
