<template>
    <div
        class="relative main-drama-container w-full h-[200vh] shrink-0">
        <div :style="{height: height+ 'px'}"
             class="intro sticky top-0 shrink-0 w-screen flex items-center justify-center">
            <img id="final-protest-illustration"
                 src="assets/illustrations/protest.svg"
                 alt="protest-illustration"
                 class="absolute transform opacity-0 w-10/12 md:!w-4/12 -translate-x-30"/>
            <img src="assets/illustrations/chronicles/1990/1990.svg"
                 alt="vote-illustration" id="final-vote-illustration"
                 class="absolute transform opacity-1 w-9/12 md:!w-3/12"/>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import protestSvg from "../../../assets/protest-svg.js";
import voteSvg from "../../../assets/vote-svg.js";
import AnimeScrollTrigger from "anime-scrolltrigger";
import anime from "animejs";
import {headers} from "../../../api/route.js";
import settings from "../../../api/settings.js";

const height = window.innerHeight;
const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#final-vote-illustration',
            opacity: 0,
            translateX: [-30, 0],
            duration: 800,
            easing: 'easeInOutQuart',
            scrollTrigger: {
                trigger: '.main-drama-container',
                start: '10% top',
                end: 'bottom top',
            }
        }, {
            targets: '#final-protest-illustration',
            opacity: 1,
            translateX: [0, -30],
            duration: 800,
            easing: 'easeInOutQuart',
            scrollTrigger: {
                trigger: '.main-drama-container',
                start: '10% top',
                end: 'bottom top',
            }
        }, {
            targets: '#beginning-of-the-end',
            background: headers[6].primaryColor,
            duration: 800,
            easing: 'easeInOutQuart',
            scrollTrigger: {
                trigger: '.main-drama-container',
                start: '10% top',
                end: 'bottom top',
                onEnter: () => {
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[6].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                    anime({
                        targets: ['.beginning-of-the-end-title', '.header-icon'],
                        color: '#ffffff',
                        easing: 'easeOutQuart',
                        duration: 600,
                    })
                },
                onLeaveBack: () => {
                    anime({
                        targets: '#section-indicator-section',
                        background: '#ffffff',
                        duration: 300,
                        easing: 'linear'
                    })
                    anime({
                        targets: ['.beginning-of-the-end-title', '.header-icon'],
                        color: '#131313',
                        easing: 'easeOutQuart',
                        duration: 600,
                    })
                }
            }
        }])
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
