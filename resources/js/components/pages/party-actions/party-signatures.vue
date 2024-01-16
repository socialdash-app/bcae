<template>
    <div id="party-signatures" class="w-11/12 py-12 lg:!w-9/12 2xl:!w-7/12 flex flex-col relative items-center">
        <h1 class="font-bold text-2xl py-8">Accusations to Government from Parties</h1>
        <div class="flex flex-col relative w-full items-center">
            <div id="party-signatures-scroller"
                 class="grid h-80 overflow-hidden w-full mt-12 sticky grid-flow-col grid-rows-2 items-stretch top-24 gap-4">
                <div
                    class="flex bg-white border-[#92261C] border flex-col shrink-0 w-48 md:w-64 gap-y-2"
                    v-for="accusation in governmentAccusations">
                    <img class="h-8 md:h-16 object-fill" :alt="accusation.partyName"
                         :src="'assets/party-images/'+accusation.img"/>
                    <h2 class="text-lg px-4 py-2 font-semibold">{{ accusation.name }}</h2>
                    <p class="text-[#92261C] px-4">{{ accusation.partyName }}</p>
                </div>
            </div>
            <div class="flex bg-[#E9A498] flex-col my-[15vh] w-11/12 md:!w-10/12 z-10 rounded p-4 md:!p-20 border"
                 v-for="_ in descriptions">
                Lorem ipsum dolor sit amet consectetur. Nunc est felis interdum ultrices sociis feugiat pulvinar. Id
                gravida
                volutpat cursus vulputate in. Malesuada egestas velit ultrices ut. In sed vitae dictumst augue in
                tristique
                ut morbi dolor. Sed eu gravida sed et eget consequat in. Nisl viverra laoreet tempor volutpat morbi
                gravida
                posuere. Purus amet tincidunt a lorem aliquam.
            </div>
            <div class="h-[90vh] w-full shrink-0">

            </div>
        </div>
        <div class="w-10/12 mt-[10vh] flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide w-6 h-6 lucide-arrow-left">
                <path d="m12 19-7-7 7-7"/>
                <path d="M19 12H5"/>
            </svg>
            <input class="w-full mx-2 cursor-grabbing" type="range" v-model="data.progress" min="0" max="100" step="1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide w-6 h-6 lucide-arrow-right">
                <path d="M5 12h14"/>
                <path d="m12 5 7 7-7 7"/>
            </svg>
        </div>
        <div
            class="flex items-center justify-center bg-[#E9A498] my-20 w-11/12 md:w-10/12 z-10 p-4 md:!p-10 rounded border">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-hand w-6 h-6 mr-4">
                <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/>
                <path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/>
                <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/>
                <path
                    d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/>
            </svg>
            <p>Use the above slider to go back and explore all parties that signed.</p>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted, watch} from "vue";
import AnimeScrollTrigger from 'anime-scrolltrigger';
import governmentAccusations from "../../../data/government-accusations.js";
import anime from "animejs";

const props = defineProps([]);

const data = reactive({
    progress: 100,
})

const getNoOfColumns = Math.round(governmentAccusations.length * 0.5)

const descriptions = [1, 2, 3, 4, 5, 6];

watch(() => data.progress, (n) => {
    const scroller = document.getElementById('party-signatures-scroller')
    console.log(n, n / 100, scroller.scrollWidth, (n / 100) * scroller.scrollWidth)
    anime({
        targets: scroller,
        scrollLeft: (n / 100) * scroller.scrollWidth,
        easing: 'easeOutQuart',
        duration: 400,
    })
})

const init = () => {
    const scroller = document.getElementById('party-signatures-scroller')
    new AnimeScrollTrigger(document.querySelector('main'), [{
        scrollTrigger: {
            trigger: '#party-signatures',
            start: 'top top',
            end: 'bottom bottom',
            lerp: true,
            onUpdate: (_, progress) => {
                anime({
                    targets: scroller,
                    scrollLeft: progress * scroller.scrollWidth,
                    easing: 'easeOutQuart',
                    duration: 400,
                })
            }
        }
    }])
}
onMounted(() => {
    setTimeout(() => {
        init();
    }, 2000)
})
</script>

<style scoped>

</style>
