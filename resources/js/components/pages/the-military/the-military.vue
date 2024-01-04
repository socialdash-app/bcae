<template>

    <div id="the-military"
         class="w-full bg-[#FEF5EC] flex-col flex items-center py-2">
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
import route from "../../../api/route.js";

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
