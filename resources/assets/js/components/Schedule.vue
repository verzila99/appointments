<template xmlns="http://www.w3.org/1999/html">
    <div class="container flex justify-center items-center ">
        <section class="mt-6">
            <div
                class="flex flex-col justify-start items-center h-screen  gap-6"
            >
                <div class="center con-selects">
                    <vs-select
                        v-if="instructors.length > 0"
                        label-placeholder="Select instructor"
                        v-model="selectedInstructorId"
                    >
                        <vs-option
                            v-for="instructor in instructors"
                            :label="instructor.name"
                            :key="instructor.id"
                            :value="instructor.id"
                        >
                            {{ instructor.name }}
                        </vs-option>
                    </vs-select>
                </div>
                <div
                    v-if="selectedInstructorId"
                    class="flex justify-between items-center gap-4 self-end"
                >
                    <div
                        @click="page--"
                        :disabled="page <= 1"
                        :class="{ 'cursor-not-allowed': page <= 1 }"
                        class="flex justify-center items-center bg-gray-100
                           rounded-lg shadow-lg hover:bg-gray-200 pl-3 pr-4 py-2 text-xl cursor-pointer disabled:opacity-50"
                    >
                        <i class="bx bxs-left-arrow text-gray-300"></i>
                    </div>
                    <div
                        @click="page++"
                        :disabled="page >= lastPage"
                        :class="{ 'cursor-not-allowed': page >= lastPage }"
                        class="flex justify-center items-center bg-gray-100
                           rounded-lg shadow-lg hover:bg-gray-200 pr-3 pl-4 py-2 text-xl cursor-pointer disabled:opacity-50"
                    >
                        <i class="bx bxs-right-arrow text-gray-300"></i>
                    </div>
                </div>
                <div
                    v-if="selectedInstructorId"
                    class="flex justify-between items-start shadow-2xl rounded-lg p-6"
                >
                    <div class="time flex justify-start flex-col items-center">
                        <div class="cell"></div>
                        <div
                            v-for="(workingHour, i) in workingHours"
                            :key="i"
                            class="cell"
                        >
                            <h4 class="font-bold">{{ workingHour }}</h4>
                        </div>
                    </div>
                    <template v-for="(day, i) in days">
                        <div
                            v-if="i <= page * 7 && i > (page - 1) * 7"
                            class="time flex justify-start flex-col items-center"
                            :key="i"
                        >
                            <div class="cell flex-wrap ">
                                <h4 class="w-full text-center font-bold">
                                    {{ day.date }}
                                </h4>
                                <h4>{{ day.weekday }}</h4>
                            </div>
                            <template
                                v-if="
                                    workingDays()
                                        .split(',')
                                        .includes(day.weekdayNumber.toString())
                                "
                            >
                                <div
                                    v-for="(workingHour, i) in workingHours"
                                    :key="i"
                                    class="cell"
                                >
                                    <a
                                        v-if="
                                            getDateForAppointment().includes(
                                                day.date +
                                                    ', ' +
                                                    workingHour.split(':')[0]
                                            )
                                        "
                                        class="bg-gray-300 text-white w-16 py-2 px-4 rounded-lg
                                       flex justify-center items-center disabled:opacity-50 cursor-not-allowed"
                                        disabled
                                    >
                                        {{ workingHour }}
                                    </a>
                                    <a
                                        v-else-if="
                                            workingHoursOfSelectedInstructor.includes(
                                                workingHour
                                            )
                                        "
                                        :data-time="
                                            day.year +
                                                '.' +
                                                (day.month + 1) +
                                                '.' +
                                                day.day +
                                                ' ' +
                                                workingHour
                                        "
                                        @click="
                                            username
                                                ? confirmAppointment($event)
                                                : $emit('open-modal')
                                        "
                                        class="btn bg-purple-300 text-white w-16 flex justify-center items-center"
                                    >
                                        {{ workingHour }}
                                    </a>
                                    <a
                                        v-else
                                        class="text-gray-400 w-16 flex justify-center items-center"
                                        >{{ workingHour }}</a
                                    >
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </section>
        <vs-dialog width="550px" not-center v-model="activeDialog">
            <template #header>
                <h4 class="not-margin">Confirm the record</h4>
            </template>

            <div
                class="con-content flex flex-col justify-between items-start gap-6"
            >
                <div class="flex justify-between items-center w-1/2">
                    <strong>Instructor:</strong>
                    <strong>{{ selectedInstructor.name }}</strong>
                </div>

                <div class="flex justify-between items-center w-1/2">
                    <strong>Date:</strong> <strong>{{ date }}</strong>
                </div>
            </div>

            <template #footer>
                <div class="con-footer flex gap-4 justify-end items-center">
                    <vs-button
                        class="btn w-20"
                        @click="makeAppointment"
                        transparent
                    >
                        Ok
                    </vs-button>
                    <vs-button
                        class="btn w-20"
                        @click="activeDialog = false"
                        dark
                        transparent
                    >
                        Cancel
                    </vs-button>
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
            workingHours: [
                "8:00",
                "9:00",
                "10:00",
                "11:00",
                "12:00",
                "13:00",
                "14:00",
                "15:00",
                "16:00",
                "17:00",
                "18:00",
                "19:00"
            ],
            workingHoursOfSelectedInstructor: [],
            inaccessibleHoursOfSelectedInstructor: [],
            days: [],
            instructors: [],
            selectedInstructorId: "",
            selectedInstructor: {},
            activeDialog: false,
            date: "",
            page: 1,
            lastPage: null
        };
    },
    props: {
        username: String,
        role: Number
    },
    methods: {
        workingDays() {
            return this.selectedInstructor["working_days"];
        },
        confirmAppointment(e) {
            this.date = e.target.dataset.time;
            this.activeDialog = true;
        },
        makeAppointment() {
            this.activeDialog = false;
            const loading = this.$vs.loading({ color: "#48CAE4" });

            axios.get("/sanctum/csrf-cookie").then(() => {
                axios
                    .post("/api/appointments", {
                        instructor: this.selectedInstructorId,
                        time: this.date.replace(/\.+/g, "-") + ":00"
                    })
                    .then(response => {
                        if (response.status === 200) {
                            this.inaccessibleHoursOfSelectedInstructor.push(
                                response.data
                            );
                        }
                        loading.close();
                        this.openNotification(
                            "success",
                            "Record added!",
                            "top-right"
                        );
                    })
                    .catch(error => {
                        loading.close();
                        if (
                            error.response.status === 403 ||
                            error.response.status === 401
                        ) {
                            this.openNotification(
                                "danger",
                                "You need to sign in.",
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
        },
        openNotification(color, title, position = null) {
            const not = this.$vs.notification({
                color,
                title,
                position
            });
            not.close();
        },
        getDateForAppointment() {
            return this.inaccessibleHoursOfSelectedInstructor.map(item => {
                const date = new Date(item["start_time"]);
                return `${new Intl.DateTimeFormat("en-us", {
                    month: "long"
                }).format(date)}, ${date.getDate()}, ${date.getHours()}`;
            });
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
                .catch(err => {
                    loading.close();
                    console.log(err);
                });
        });
    },
    mounted() {
        let weekday = new Date().getDay() + 1;

        const currentDate = new Date(Date.now() - weekday * 24 * 3600000);
        const [month, day, year] = [
            currentDate.getMonth(),
            currentDate.getDate(),
            currentDate.getFullYear(),
            currentDate.getDay()
        ];
        let l = weekday === 1 ? 15 : 22;
        this.lastPage = weekday === 1 ? 2 : 3;
        for (let i = 0; i < l; i++) {
            const date = new Date(year, month, day + i);
            let dayItem = {};
            dayItem.date = `${new Intl.DateTimeFormat("en-us", {
                month: "long"
            }).format(date)}, ${date.getDate()}`;
            dayItem.year = date.getFullYear();
            dayItem.month = date.getMonth();
            dayItem.day = date.getDate();
            dayItem.weekday = new Intl.DateTimeFormat("en-us", {
                weekday: "long"
            }).format(date);
            dayItem.weekdayNumber = date.getDay();

            this.days.push(dayItem);
        }
    },
    watch: {
        selectedInstructorId: function() {
            this.selectedInstructor = this.instructors.find(el => {
                return el.id === this.selectedInstructorId;
            });

            const startTime = +this.selectedInstructor["schedule"].split(
                "-"
            )[0];
            const endTime = +this.selectedInstructor["schedule"].split("-")[1];
            this.workingHoursOfSelectedInstructor = [];

            for (let i = startTime; i <= endTime; i++) {
                this.workingHoursOfSelectedInstructor.push(i + ":00");
            }
            this.inaccessibleHoursOfSelectedInstructor = this.selectedInstructor[
                "appointments"
            ];
        },
    }
};
</script>

<style scoped></style>
