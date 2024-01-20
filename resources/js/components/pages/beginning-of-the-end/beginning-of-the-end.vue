<template>
    <div id="beginning-of-the-end"
         class="flex flex-col w-full bg-[#111827]">
        <intro-beginning-of-the-end/>
        <div
            class="drama-section py-10 main-intro w-screen h-screen px-3 md:px-20 flex items-center justify-center text-[#E8544E]">
            <div class="text-center">
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro">
                        The
                        BEGINNING</h1></div>
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro mt-4">
                        Of</h1>
                </div>
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro mt-4">
                        The
                        END</h1>
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
import route from "../../../api/route.js";
import anime from "animejs";

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
                    console.log('enter')
                },
                onEnterBack: () => {
                    route.changeSectionHeader(6)
                    console.log('enter back');
                },
            }
        }, {
            scrollTrigger: {
                trigger: '.drama-section',
                start: 'top top',
                end: 'bottom top',
                onEnter: () => {
                    anime({
                        targets: '.header',
                        color: '#fff',
                        easing: 'easeOutQuart',
                        duration: 600,
                    })
                },
                onLeaveBack: () => {
                    anime({
                        targets: '.header',
                        color: '#131313',
                        easing: 'easeOutQuart',
                        duration: 600,
                    })
                }
            }
        }])
    }, 2000)
})
</script>

<style scoped>

</style>
