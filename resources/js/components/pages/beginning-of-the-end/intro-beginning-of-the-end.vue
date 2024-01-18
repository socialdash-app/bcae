<template>
    <div
        class="relative main-drama-container bg-white  w-full h-[200vh] shrink-0">
        <div :style="{height: height+ 'px'}"
             class="intro sticky top-0 shrink-0 w-screen flex items-center justify-center">
            <div v-html="protestSvg"
                 id="final-protest-illustration"
                 class="absolute transform opacity-0 w-10/12 sm:w-4/12 -translate-x-30">
            </div>
            <div id="final-vote-illustration" v-html="voteSvg" class="absolute transform opacity-1 w-10/12 sm:w-4/12">
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import protestSvg from "../../../assets/protest-svg.js";
import voteSvg from "../../../assets/vote-svg.js";
import AnimeScrollTrigger from "anime-scrolltrigger";

const height = window.innerHeight;
const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    new AnimeScrollTrigger(document.querySelector('main'), [{
        targets: '#final-vote-illustration',
        opacity: 0,
        translateX: [-30, 0],
        duration: 800,
        easing: 'easeInOutQuart',
        scrollTrigger: {
            trigger: '.main-drama-container',
            start: '40% top',
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
            start: '40% top',
            end: 'bottom top',
        }
    }, {
        targets: '.main-drama-container',
        background: '#111827',
        duration: 800,
        easing: 'easeInOutQuart',
        scrollTrigger: {
            trigger: '.main-drama-container',
            start: '40% top',
            end: 'bottom top',
        }
    }])
})
</script>

<style scoped>

</style>
