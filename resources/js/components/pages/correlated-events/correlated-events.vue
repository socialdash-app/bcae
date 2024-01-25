<template>
    <div id="correlated-events"
         :style="{background: headers[5].primaryColor}"
         class="w-full flex-col flex relative items-center py-2">
        <div class="sticky pl-4 md:pl-14 top-4 md:!top-6 w-11/12 z-[100]">
            <h1 class="text-xl md:text-3xl font-bold">Correlated Events</h1>
        </div>
        <protests/>
        <disinformation/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import Protests from "./protests.vue";
import Disinformation from "./disinformation.vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import route, {headers} from "../../../api/route.js";
import settings from "../../../api/settings.js";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#header-correlated-events circle',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#correlated-events',
                start: 'top top',
                end: 'bottom top',
                lerp: true,
                onEnter: () => {
                    route.changeSectionHeader(5)
                },
                onEnterBack: () => {
                    route.changeSectionHeader(5)
                },
            }
        }])
    }, settings.animationDuration);
})
</script>

<style scoped>

</style>
