<template>
    <div class="container  pt-16 h-screen flex flex-col items-end gap-6">
        <vs-table>
            <template #thead>
                <vs-tr>
                    <vs-th>
                        Id
                    </vs-th>
                    <vs-th>
                        Name
                    </vs-th>
                    <vs-th>
                        Age
                    </vs-th>
                    <vs-th>
                        Working days
                    </vs-th>
                    <vs-th>
                        Schedule
                    </vs-th>
                    <vs-th>
                        Edit
                    </vs-th>
                    <vs-th>
                        Delete
                    </vs-th>
                </vs-tr>
            </template>
            <template #tbody>
                <vs-tr :key="i" v-for="(instructor, i) in instructors">
                    <vs-td>
                        {{ instructor.id }}
                    </vs-td>
                    <vs-td>
                        {{ instructor.name }}
                    </vs-td>
                    <vs-td>
                        {{ instructor.age }}
                    </vs-td>
                    <vs-td>
                        {{ instructor.working_days }}
                    </vs-td>
                    <vs-td>
                        {{ instructor.schedule }}
                    </vs-td>
                    <vs-td>
                        <div
                            :data-id="instructor.id"
                            :data-name="instructor.name"
                            :data-age="instructor.age"
                            :data-working_days="instructor.working_days"
                            :data-schedule="instructor.schedule"
                            @click="edit($event)"
                            class="btn bg-primary text-blue-50 "
                        >
                            Edit
                        </div>
                    </vs-td>
                    <vs-td>
                        <div
                            :data-id="instructor.id"
                            @click="confirmDeleting($event)"
                            class="btn bg-danger text-blue-50 "
                        >
                            Delete
                        </div>
                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>

        <div class="flex justify-between items-center gap-4">
            <div class="btn bg-primary text-blue-50" @click="addActive = true">
                Add instructor
            </div>
        </div>
        <vs-dialog v-model="editActive">
            <template #header>
                Edit Instructor
            </template>

            <div class="flex justify-between items-start gap-6">
                <strong class="mt-2">{{ editingInstructor.id }}</strong>
                <div class="flex  flex-wrap justify-center items-center gap-6">
                    <vs-input
                        @keypress.enter="saveInstructor"
                        v-model="editingInstructor.name"
                        label-placeholder="Name"
                        :value="editingInstructor.name"
                    />
                    <vs-input
                        @keypress.enter="saveInstructor"
                        v-model="editingInstructor.age"
                        label-placeholder="Age"
                        :value="editingInstructor.age"
                    />
                    <vs-input
                        @keypress.enter="saveInstructor"
                        v-model="editingInstructor.working_days"
                        label-placeholder="Working days"
                        :value="editingInstructor.working_days"
                    />
                    <vs-input
                        @keypress.enter="saveInstructor"
                        v-model="editingInstructor.schedule"
                        label-placeholder="Schedule"
                        :value="editingInstructor.schedule"
                    />
                </div>
            </div>

            <a
                href=""
                class="btn bg-primary text-blue-50 my-6"
                @click.prevent="saveInstructor"
                >Save</a
            >
        </vs-dialog>
        <vs-dialog v-model="addActive">
            <template #header>
                Add Instructor
            </template>

            <div class="flex justify-between items-start gap-6">
                <div class="flex  flex-wrap justify-center items-center gap-6">
                    <vs-input
                        @keypress.enter="addInstructor"
                        v-model="addingInstructor.name"
                        label-placeholder="Name"
                    />
                    <vs-input
                        @keypress.enter="addInstructor"
                        v-model="addingInstructor.age"
                        label-placeholder="Age"
                    />
                    <vs-input
                        @keypress.enter="addInstructor"
                        v-model="addingInstructor.working_days"
                        label-placeholder="Working days"
                    />
                    <vs-input
                        @keypress.enter="addInstructor"
                        v-model="addingInstructor.schedule"
                        label-placeholder="Schedule"
                    />
                </div>
            </div>

            <a
                href=""
                class="btn bg-primary text-blue-50 my-6"
                @click.prevent="addInstructor"
                >Add</a
            >
        </vs-dialog>
        <vs-dialog width="450px" class="px-6" not-center v-model="deleteActive">
            <template #header>
                <h4 class="flex  justify-center items-center text-xl mt-4">
                    Confirm deleting
                </h4>
            </template>
            <div
                class="con-content flex flex-col justify-between items-start my-3"
            >
                <div class="flex justify-center items-center w-full">
                    <strong class="text-2xl">Are you sure?</strong>
                </div>
            </div>
            <template #footer>
                <div
                    class="con-footer flex gap-4 justify-end items-center mb-3"
                >
                    <a
                        class="btn bg-primary text-blue-50 w-20"
                        @click="deleteInstructor"
                    >
                        Ok
                    </a>
                    <a
                        class="btn bg-white w-20 text-black"
                        @click="deleteActive = false"
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
    name: "Instructors",
    data() {
        return {
            instructors: [],
            showInput: false,
            editActive: false,
            deleteActive: false,
            addActive: false,
            editingInstructor: {},
            deletingId: "",
            addingInstructor: {}
        };
    },
    methods: {
        edit(event) {
            console.log(event.target.dataset.id);
            this.editActive = true;
            this.editingInstructor.id = event.target.dataset.id;
            this.editingInstructor.name = event.target.dataset.name;
            this.editingInstructor.age = event.target.dataset.age;
            this.editingInstructor.working_days =
                event.target.dataset.working_days;
            this.editingInstructor.schedule = event.target.dataset.schedule;
        },
        saveInstructor() {
            this.editActive = false;
            const loading = this.$vs.loading({ color: "#48CAE4" });

            axios.get("/sanctum/csrf-cookie").then(() => {
                axios
                    .put("/api/instructors/" + this.editingInstructor.id, {
                        id: this.editingInstructor.id,
                        name: this.editingInstructor.name,
                        age: this.editingInstructor.age,
                        working_days: this.editingInstructor.working_days,
                        schedule: this.editingInstructor.schedule
                    })
                    .then(response => {
                        if (response.status === 200) {
                            this.instructors = this.instructors.map(item => {
                                if (item.id === response.data.id) {
                                    item = response.data;
                                }
                                return item;
                            });
                        }

                        loading.close();
                        this.openNotification(
                            "success",
                            "Instructor updated.",
                            "top-right"
                        );
                    })
                    .catch(error => {
                        loading.close();
                        if (
                            error.message ===
                            "Request failed with status code 403"
                        ) {
                            this.openNotification(
                                "danger",
                                "You need to sign in",
                                "top-right"
                            );
                        } else {
                            this.openNotification(
                                "danger",
                                "Something goes wrong, try later.",
                                "top-right"
                            );
                        }
                        console.log(error);
                    });
            });
        },
        addInstructor() {
            this.addActive = false;
            const loading = this.$vs.loading({ color: "#48CAE4" });

            axios.get("/sanctum/csrf-cookie").then(() => {
                axios
                    .post("/api/instructors/", {
                        name: this.addingInstructor.name,
                        age: this.addingInstructor.age,
                        working_days: this.addingInstructor.working_days,
                        schedule: this.addingInstructor.schedule
                    })
                    .then(response => {
                        if (response.status === 200) {
                            console.log(response.data);
                            this.instructors.push(response.data);
                            this.openNotification(
                                "success",
                                "Instructor updated.",
                                "top-right"
                            );
                        }

                        loading.close();
                    })
                    .catch(error => {
                        loading.close();

                        if (
                            error.message ===
                            "Request failed with status code 403"
                        ) {
                            this.openNotification(
                                "danger",
                                "You need to sign in",
                                "top-right"
                            );
                        } else if (error.response.data.errors) {
                            const errors = error.response.data.errors;
                            console.log(errors);

                            if (errors.name) {
                                errors.name.forEach(i => {
                                    this.openNotification(
                                        "danger",
                                        i,
                                        "top-right"
                                    );
                                });
                            }
                            if (errors.age) {
                                errors.age.forEach(i => {
                                    this.openNotification(
                                        "danger",
                                        i,
                                        "top-right"
                                    );
                                });
                            }
                            if (errors.working_days) {
                                errors.working_days.forEach(i => {
                                    this.openNotification(
                                        "danger",
                                        i,
                                        "top-right"
                                    );
                                });
                            }
                            if (errors.schedule) {
                                errors.schedule.forEach(i => {
                                    this.openNotification(
                                        "danger",
                                        i,
                                        "top-right"
                                    );
                                });
                            }
                        }
                    });
            });
        },
        confirmDeleting(event) {
            this.deletingId = event.target.dataset.id;
            this.deleteActive = true;
        },
        deleteInstructor() {
            const loading = this.$vs.loading({ color: "#48CAE4" });
            this.deleteActive = false;
            axios.get("/sanctum/csrf-cookie").then(() => {
                axios
                    .delete("/api/instructors/" + this.deletingId)
                    .then(response => {
                        if (response.status === 200) {
                            console.log(response);
                            this.instructors = this.instructors.filter(
                                item => +item.id !== +this.deletingId
                            );
                            this.openNotification(
                                "success",
                                "Instructor deleted.",
                                "top-right"
                            );
                        }

                        loading.close();
                    })
                    .catch(error => {
                        loading.close();
                        if (
                            error.message ===
                                "Request failed with status code 403" ||
                            error.message ===
                                "Request failed with status code 401"
                        ) {
                            this.openNotification(
                                "danger",
                                "You need to sign in",
                                "top-right"
                            );
                        } else {
                            this.openNotification(
                                "danger",
                                "Something goes wrong, try later.",
                                "top-right"
                            );
                        }
                        console.log(error);
                    });
            });
        },
        openNotification(color, title, position = null) {
            const not = this.$vs.notification({
                color,
                title,
                position
            });
            not.close();
        }
    },
    beforeCreate: function() {
        const loading = this.$vs.loading({ color: "#48CAE4" });

        axios.get("/sanctum/csrf-cookie").then(() => {
            axios
                .get("/api/instructors")
                .then(response => {
                    if (response.status === 200) {
                        this.instructors = response.data;
                    }
                    loading.close();
                })
                .catch(error => {
                    loading.close();
                    if (
                        error.response.status === 403 ||
                        error.response.status === 401
                    ) {
                        this.openNotification(
                            "danger",
                            "You don't have permission on this action",
                            "top-right"
                        );
                    } else if (error.response.status === 400) {
                        this.openNotification(
                            "danger",
                            error.response.data,
                            "top-right"
                        );
                    } else {
                        this.openNotification(
                            "danger",
                            "Something goes wrong, try later.",
                            "top-right"
                        );
                    }

                    console.log(error);
                });
        });
    }
};
</script>

<style scoped></style>
