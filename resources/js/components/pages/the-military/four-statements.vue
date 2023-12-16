<template>
    <div class="relative w-full flex items-center flex-col"
         :style="{height: `${fourStatements.length*400}px`}" id="four-statements-trigger">
        <!--            <div id="pin"-->
        <!--                 class="w-[60vw] top-0 transform gap-y-36 flex h-screen justify-center absolute items-center flex-col">-->
        <!--                -->
        <!--            </div>-->
        <div class="flex flex-col mt-[10vh] w-full items-center" id="four-statements-pinner">
            <div v-for="(statement,index) in fourStatements"
                 :style="{opacity: index === 0 ? 1: 0}"
                 class="four-statement flex flex-col p-10 bg-[#AAE998] text-gray-800 border border-gray-600 w-6/12 gap-y-8 h-[600px] absolute rounded-2xl items-center">
                <!-- <div class="card w-full h-full"></div>-->
                <h1 class="text-2xl font-bold">{{ statement.title }}</h1>
                <h2 class="text-lg font-semibold">{{ statement.subtitle }}</h2>
                <div class="h-full">{{ truncate(statement.description, 1000) }}</div>
                <button class="px-6 self-end py-3 rounded bg-[#EE7E33] text-white">Read More</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import truncate from "../../../api/truncate.js";
import {onMounted, reactive} from "vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import {fourStatements} from "../beginning-of-the-end/data.js";

const props = defineProps([]);

let init = () => {
    let trigger = document.getElementById('four-statements-trigger');

    let cards = document.querySelectorAll('.four-statement');

    let transitionDuration = 1000;

    cards.forEach((card, index) => {
        card.style.transform = `translateY(${index * card.getBoundingClientRect().height + 'px'})`;
    })

    let transformYValues = [0, 20, 40, 60];

    let transformXValues = [0, 20, 40, 60];

    new AnimeScrollTrigger(document.querySelector('main'), [{
        targets: cards,
        opacity: [
            {
                value: 1,
                duration: (_, index) => transitionDuration,
                delay: (_, index) => transitionDuration * index,
            }
        ],
        translateY: [{
            value: 0,
            delay: (_, index) => index * transitionDuration,
            duration: (_, index) => transitionDuration,
        }, {
            value: (_, index) => {
                // console.log(index, val)
                return transformYValues[cards.length - 1 - index];
            },
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        translateX: [{
            value: 0,
            delay: (_, index) => index * transitionDuration,
            duration: (_, index) => transitionDuration,
        }, {
            value: (_, index) => {
                let val = transformXValues[cards.length - 1 - index];
                return val;
            },
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        scrollTrigger: {
            smooth: true,
            trigger: trigger,
            pin: '#four-statements-pinner',
            lerp: true,
            start: 'top top',
            end: 'bottom bottom',
            onUpdate: (_, progress) => {
                // console.log(progress)
            }
        },
    }])
}
onMounted(() => {
    setTimeout(() => {
        init();
    }, 500)
})
</script>

<style scoped>

</style>
