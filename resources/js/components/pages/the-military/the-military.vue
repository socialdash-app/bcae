<template>

    <div id="container"
         class="w-full flex-col flex items-center">
        <div class="shrink-0 w-screen h-screen bg-sky-300"></div>
        <four-statements/>
        <statement-dates/>
    </div>
</template>

<script setup>

import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import gsap from 'gsap';
import {ScrollTrigger} from "gsap/ScrollTrigger";
import anime from "animejs";
import {Calendar} from "v-calendar";
import StatementDates from "./statement-dates.vue";
import FourStatements from "./four-statements.vue";

gsap.registerPlugin(ScrollTrigger)

const props = defineProps([]);


let animations = [];


function lerp(start, end, current) {
    let distance = Math.abs(end - start);
    let currentDist = Math.max(end - current, 0);
    return 1 - Math.min(currentDist / distance, 1);
}


onMounted(() => {

})
</script>

<style scoped>

</style>
