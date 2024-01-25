<template>
    <div :style="{background: headers[2].primaryColor}" id="prominent-events"
         class="relative w-full flex pt-4 md:!pt-6 items-center flex-col">
        <div class="sticky pl-4 md:pl-14 top-4 md:!top-6 w-11/12 z-[100]">
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
                },
                onEnterBack: () => {
                    route.changeSectionHeader(2)
                },
            }
        }])
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
