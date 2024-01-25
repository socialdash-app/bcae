<template>

    <div id="the-military"
         :style="{background: headers[4].primaryColor}"
         class="w-full flex-col flex items-center pt-4 md:!pt-6 relative">
        <div class="sticky pl-4 md:pl-14 top-4 md:!top-6 w-11/12 z-[100]">
            <h1 class="text-xl md:text-3xl font-bold">The Military</h1>
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
import route, {headers} from "../../../api/route.js";

const props = defineProps([]);

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#header-the-military circle',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#the-military',
                start: 'top top',
                end: 'bottom top',
                lerp: true,
                onEnter: () => {
                    route.changeSectionHeader(4);
                    console.log('enter election')
                },
                onEnterBack: () => {
                    route.changeSectionHeader(4);
                    console.log('enter back election');
                },
            }
        }])
    }, 2000)

})
</script>

<style scoped>

</style>
