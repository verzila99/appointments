<template xmlns = "http://www.w3.org/1999/html">
    <div class = "container flex justify-center items-center ">
        <section class = "appointments mt-6">
            <div class = "flex flex-col justify-between items-start h-screen  gap-6">

                <div class = "center con-selects">
                    <vs-select :placeholder = "selectedInstructor"
                               :value = "selectedInstructor"
                               v-on:input = "selectInstructor( $event.target.value)"
                               ref = "p">

                        <template v-for = "instructor in instructors">
                            <vs-option :label = "instructor.name" :key = "instructor.id" :value = "instructor.id">
                                {{ instructor.name }}
                            </vs-option>
                        </template>

                    </vs-select>
                </div>

                <div v-if = "false" class = "flex justify-between items-center shadow-2xl rounded-lg p-6">
                    <div class = "time flex justify-start flex-col items-center">

                        <div class = "cell">

                        </div>
                        <div v-for = "time in times" class = "cell">
                            <h4 class = "font-bold">{{ time }}</h4>
                        </div>

                    </div>
                    <div v-for = "day in days" class = "time flex justify-start flex-col items-center">

                        <div class = "cell flex-wrap ">
                            <h4 class = "w-full text-center font-bold">{{ day.date }}</h4>
                            <h4>{{ day.weekday }}</h4>
                        </div>
                        <template v-if = "workingDays().split(',').includes(day.weekdayNumber+1)">
                            <div v-for = "time in times" class = "cell">
                                <a class = "btn bg-purple-300 text-white w-16 flex justify-center items-center"> {{
                                        time
                                                                                                                 }} </a>
                            </div>

                        </template>

                    </div>
                </div>
            </div>

        </section>
    </div>
</template>

<script>

export default {
    name: "Appointments",
    data() {
        return {
            times: [
                '8:00',
                '9:00',
                '10:00',
                '11:00',
                '12:00',
                '13:00',
                '14:00',
                '15:00',
                '16:00',
            ],
            days: [],
            instructors: [],
            selectedInstructor: '',


        }
    }
    ,
    methods: {
        workingDays() {
            const instructor = this.instructors.find((el) => {
                return el.id === this.selectedInstructor;
            });
            return instructor['working_days'];


        },
        selectInstructor(e) {
            this.selectInstructor = e;
            console.log(this.selectInstructor, 666);
        }
    },
    beforeCreate: function () {
        const loading = this.$vs.loading({color: '#48CAE4'});
        axios.get('sanctum/csrf-cookie').then(() => {
            axios.get('/api/instructors').then((response) => {
                if (response.status === 200) {
                    console.log(response.data);
                    this.instructors = response.data;
                }
                loading.close();
            }).catch(e => {
                loading.close();
                console.log(e)
            });
        })
    }
    ,
    mounted() {
        const currentDate = new Date();
        const [month, day, year] = [currentDate.getMonth(), currentDate.getDate(), currentDate.getFullYear()];

        for (let i = 0; i < 7; i++) {
            const date = new Date(year, month, day + i);
            let dayItem = {};
            dayItem.date = `${new Intl.DateTimeFormat("en-us", {month: "long"}).format(date)}, ${date.getDate()}`
            dayItem.weekday = new Intl.DateTimeFormat("en-us", {weekday: "long"}).format(date);
            dayItem.weekdayNumber = date.getDay();

            this.days.push(dayItem);
        }
    },
    watch: {
        selectedInstructor: function () {
            console.log(this.selectedInstructor, 234234);

        },
    }

}
</script>

<style scoped>

</style>
