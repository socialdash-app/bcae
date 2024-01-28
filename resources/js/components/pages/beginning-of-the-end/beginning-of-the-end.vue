<template>
    <div id="beginning-of-the-end"
         class="flex flex-col w-full py-12 relative items-center">
        <div class="sticky beginning-of-the-end-title pl-4 md:pl-14 top-4 md:!top-6 w-11/12 z-[10000]">
            <h1 class="text-xl md:text-3xl font-bold">Beginning Of The End</h1>
        </div>
        <intro-beginning-of-the-end/>
        <div
            :style="{color: headers[6].secondaryColor}"
            class="drama-section py-10 main-intro w-screen h-screen px-3 md:px-20 flex items-center justify-center">
            <div class="text-center font-lato">
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro">
                        The BEGINNING
                    </h1>
                </div>
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro mt-4">
                        Of
                    </h1>
                </div>
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro mt-4">
                        The
                        END
                    </h1>
                </div>
            </div>
        </div>
        <first-media-posts/>
        <bcae-summary/>
        <credit-section/>
        <share-section/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import protestSvg from "../../../assets/protest-svg.js";
import voteSvg from "../../../assets/vote-svg.js";
import FirstMediaPosts from "./first-media-posts.vue";
import IntroBeginningOfTheEnd from "./intro-beginning-of-the-end.vue";
import BcaeSummary from "./bcae-summary.vue";
import CreditSection from "./credit-section.vue";
import ShareSection from "./share-section.vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import route, {headers} from "../../../api/route.js";
import anime from "animejs";
import settings from "../../../api/settings.js";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#header-beginning-of-the-end circle',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#beginning-of-the-end',
                start: 'top top',
                end: 'bottom bottom',
                lerp: true,
                onEnter: () => {
                    route.changeSectionHeader(6)
                    anime({
                        targets: '#section-indicator-section',
                        background: '#ffffff',
                        duration: 300,
                        easing: 'linear'
                    })
                }
            }
        },])
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
