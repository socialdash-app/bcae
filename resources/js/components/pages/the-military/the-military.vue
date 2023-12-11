<template>

    <div id="the-military"
         class="w-full flex-col flex items-center bg-[#FEF5EC] py-2">
        <div class="w-full flex justify-between bg-[#FEF5EC] z-[100] h-24 items-center px-20 sticky top-0 left-0">
            <h1 class="text-xl font-semibold">The Military</h1>
            <div class="relative flex items-center justify-center">
                <svg width="60" height="60" viewBox="0 0 60 60">
                    <circle id="the-military-progress-indicator" stroke-dashoffset="160" stroke-dasharray="160" r="25"
                            fill="none" stroke-width="8"
                            stroke="#FF7F00" cx="30"
                            cy="30"></circle>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide absolute w-7 h-7 lucide-shield">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                </svg>
            </div>
        </div>
        <military-intro/>
        <four-statements/>
        <statement-dates/>
    </div>
</template>

<script setup>

import {onMounted} from "vue";
import StatementDates from "./statement-dates.vue";
import FourStatements from "./four-statements.vue";
import AnimeScrollTrigger from 'anime-scrolltrigger'
import MilitaryIntro from "./military-intro.vue";

const props = defineProps([]);

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#the-military-progress-indicator',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#the-military',
                start: 'top top',
                end: 'bottom bottom',
                lerp: true,
            }
        }])
    }, 500)

})
</script>

<style scoped>

</style>
