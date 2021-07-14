<template xmlns = "http://www.w3.org/1999/html">
    <div class = "container flex justify-center items-center ">
        <section class = "appointments mt-6">
            <div class = "flex justify-between items-start h-screen  gap-6">

                <div class = "center con-selects">
                    <vs-select placeholder = "Select fitness instructor" v-model = "instructor">
                        <vs-option label = "Vuesax" value = "1">
                            Vuesax
                        </vs-option>
                        <vs-option label = "Vue" value = "2">
                            Vue
                        </vs-option>
                        <vs-option label = "Javascript" value = "3">
                            Javascript
                        </vs-option>
                        <vs-option label = "Sass" value = "4">
                            Sass
                        </vs-option>
                        <vs-option label = "Typescript" value = "5">
                            Typescript
                        </vs-option>
                        <vs-option label = "Webpack" value = "6">
                            Webpack
                        </vs-option>
                        <vs-option label = "Nodejs" value = "7">
                            Nodejs
                        </vs-option>
                    </vs-select>
                </div>

                <div class = "flex justify-between items-center shadow-2xl rounded-lg p-6">
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
                        <div v-for = "time in times" class = "cell">
                            <a class = "btn bg-purple-300 text-white w-16 flex justify-center items-center"> {{
                                    time
                                                                                                             }} </a>
                        </div>

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
            instructor: ''

        }
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
            this.days.push(dayItem);
        }
    }
    ,
}
</script>

<style scoped>

</style>
