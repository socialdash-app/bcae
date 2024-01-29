<template>
    <div id="correlated-events"
         :style="{background: headers[5].primaryColor}"
         class="w-full flex-col flex relative items-center py-6">
        <div class="sticky ml-[4%] sm:!ml-[8%] self-start top-3 md:!top-6 z-[10002]">
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
import anime from "animejs";

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
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[5].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
                onEnterBack: () => {
                    route.changeSectionHeader(5)
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[5].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
            }
        }])
    }, settings.animationDuration);
})
</script>

<style scoped>

</style>
