<template>
    <b-tabs content-class="mt-3">


        <b-tab active title="Студенты">
            <students></students>
        </b-tab>

        <b-tab title="Преподаватели">
            <teachers></teachers>
        </b-tab>

        <b-tab title="Курсы">
            <courses></courses>
        </b-tab>

    </b-tabs>
</template>

<script>
import Students from "./Students";
import Teachers from "./Teachers";
import Courses from "./Courses";

export default {
    name: 'App',
    components: {
        Students,
        Teachers,
        Courses,
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
