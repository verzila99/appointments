<template>
    <div class = "home w-full flex items-start justify-end">
        <div class = "container flex items-start justify-end">
            <div class = "w-128"></div>
            <div class =
                     "flex flex-col justify-end items-start mt-48 gap-12 p-12 w-128 h-auto  border-4 border-white rounded-md">
                <h2 class = "text-gray-800 text-7xl">Fitness instructor</h2>
                <p class = "text-gray-800 text-2xl">Sign up to take a lesson</p>
                <a v-if = "!$cookies.get('logged')"
                   href = ""
                   class = "btn bg-primary text-blue-50"
                   @click.prevent = "$emit('open-modal')">Sign up</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Home",
    emits:
        {
            openModal: ''
        }

}
</script>

<style scoped>
.home {
    background-image: url('../../images/home.jpg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 92vh;
}
</style>
