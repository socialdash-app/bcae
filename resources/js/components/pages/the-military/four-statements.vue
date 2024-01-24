<template>
    <div class="relative w-full flex items-center flex-col"
         :style="{height: `${height * fourStatements.length}px`}" id="four-statements-trigger">
        <!--            <div id="pin"-->
        <!--                 class="w-[60vw] top-0 transform gap-y-36 flex h-screen justify-center absolute items-center flex-col">-->
        <!--                -->
        <!--            </div>-->
        <div :style="{height: height + 'px'}" class="flex flex-col sticky top-0 justify-center w-full items-center">
            <div v-for="(statement,index) in fourStatements"
                 :style="{opacity: index === 0 ? 1: 0, height : height * 0.7 + 'px'}"
                 class="four-statement flex flex-col p-4 md:!p-10 bg-[#AAE998] text-gray-800 border border-gray-600 w-11/12  md:!w-6/12 gap-y-4 md:!gap-y-8 absolute rounded-2xl items-center">
                <!-- <div class="card w-full h-full"></div>-->
                <h1 class="text-2xl font-bold">{{ statement.title }}</h1>
                <h2 class="text-lg font-semibold">{{ statement.subtitle }}</h2>
                <div class="h-[70%] overflow-hidden text-ellipsis">
                    {{ truncate(statement.description, width > 768 ? 1000 : 600) }}
                </div>
                <button class="px-6 self-end py-3 rounded bg-[#EE7E33] text-white">Read More</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import truncate from "../../../api/truncate.js";
import {onMounted} from "vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import {fourStatements} from "../beginning-of-the-end/data.js";
import settings from "../../../api/settings.js";

const props = defineProps([]);

const height = window.innerHeight;

const width = window.innerWidth;

let init = () => {
    let trigger = document.getElementById('four-statements-trigger');

    let cards = document.querySelectorAll('.four-statement');

    let transitionDuration = 1000;

    let transformMultiplier = width > 768 ? 20 : 10;

    let transformValues = [];

    cards.forEach((card, index) => {
        card.style.transform = `translateY(${index * card.getBoundingClientRect().height + 'px'})`;
        transformValues.push((index + 1) * transformMultiplier)
    })

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
                return transformValues[cards.length - 1 - index];
            },
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        translateX: [{
            value: 0,
            delay: (_, index) => index * transitionDuration,
            duration: (_, index) => transitionDuration,
        }, {
            value: (_, index) => transformValues[cards.length - 1 - index],
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        scrollTrigger: {
            trigger: trigger,
            lerp: true,
            start: 'top top',
            end: 'bottom bottom',
        },
    }])
}
onMounted(() => {
    setTimeout(() => {
        init();
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
