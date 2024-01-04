<template>
    <div id="beginning-of-the-end"
         class="flex flex-col w-full bg-[#111827]">
        <!--        <div-->
        <!--            class="w-full indicator flex justify-between bg-white z-[100] h-24 items-center px-20 sticky top-0 left-0">-->
        <!--            <h1 class="text-xl font-semibold">Beginning Of The End</h1>-->
        <!--            <div class="relative flex items-center justify-center">-->
        <!--                <svg width="60" height="60" viewBox="0 0 60 60">-->
        <!--                    <circle id="beginning-of-the-end-progress-indicator" stroke-dashoffset="160" stroke-dasharray="160"-->
        <!--                            r="25"-->
        <!--                            fill="none" stroke-width="8"-->
        <!--                            stroke="#FF7F00" cx="30"-->
        <!--                            cy="30"></circle>-->
        <!--                </svg>-->
        <!--                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
        <!--                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
        <!--                             class="lucide absolute w-7 h-7 lucide-history">-->
        <!--                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>-->
        <!--                            <path d="M3 3v5h5"/>-->
        <!--                            <path d="M12 7v5l4 2"/>-->
        <!--                        </svg>-->
        <!--            </div>-->
        <!--        </div>-->
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
import AnimeScrollTrigger from "../../../../../../scrollanime/index.js";
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
