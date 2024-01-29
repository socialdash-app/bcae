<template>

    <div id="the-military"
         :style="{background: headers[4].primaryColor}"
         class="w-full flex-col flex items-center py-4 md:!py-6 relative">
        <div class="sticky ml-[4%] sm:!ml-[8%] self-start top-3 md:!top-6 z-[10002]">
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
import settings from "../../../api/settings.js";
import anime from "animejs";

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
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[4].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
                onEnterBack: () => {
                    route.changeSectionHeader(4);
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[4].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
            }
        }])
    }, settings.animationDuration)

})
</script>

<style scoped>

</style>
