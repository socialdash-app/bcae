<template>
    <div :style="{background: headers[2].primaryColor}" id="prominent-events"
         class="relative w-full flex pt-4 md:!pt-6 items-center flex-col">
        <div class="sticky ml-[4%] sm:!ml-[8%] self-start top-3 md:!top-6 z-[10002]">
            <h1 class="text-xl md:text-3xl font-bold">Prominent Events</h1>
        </div>
        <election-incidents/>
        <complaint-events/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import ElectionIncidents from "./election-incidents.vue";
import ComplaintEvents from "./complaint-events.vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import route, {headers} from "../../../api/route.js";
import settings from "../../../api/settings.js";
import anime from "animejs";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#header-prominent-events circle',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#prominent-events',
                start: 'top top',
                end: 'bottom top',
                lerp: true,
                onEnter: () => {
                    route.changeSectionHeader(2)
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[2].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
                onEnterBack: () => {
                    route.changeSectionHeader(2)
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[2].primaryColor,
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
