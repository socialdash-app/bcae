<template>

    <div id="container"
         class="w-full flex-col flex items-center">
        <div class="shrink-0 w-screen h-screen bg-sky-300"></div>
        <div class="relative w-full mt-[10vh] flex items-center flex-col"
             id="trigger"
             :style="{height: `${data.length*400}px`}">
            <!--            <div id="pin"-->
            <!--                 class="w-[60vw] top-0 transform gap-y-36 flex h-screen justify-center absolute items-center flex-col">-->
            <!--                -->
            <!--            </div>-->
            <div v-for="(card,index) in data"
                 :class="card.backgroundColor"
                 class="card w-7/12 gap-y-4 h-[600px] absolute rounded-2xl items-center justify-center">
                <!-- <div class="card w-full h-full"></div>-->
            </div>
        </div>

        <div class="shrink-0 w-screen h-screen bg-amber-300"></div>
    </div>
</template>

<script setup>

import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import gsap from 'gsap';
import {ScrollTrigger} from "gsap/ScrollTrigger";
import anime from "animejs";

gsap.registerPlugin(ScrollTrigger)

const props = defineProps([]);

// const data = reactive({})

let data = [{
    image: 'https://cdn.marvel.com/content/1x/deadpool3_lob_crd_01.jpg',
    title: 'Dead Pool 3',
    backgroundColor: 'bg-gray-800',
}, {
    image: 'https://cdn.marvel.com/content/1x/captainamericabravenewworld_lob_crd_01.jpg',
    title: 'Captain America',
    backgroundColor: 'bg-orange-300',
}, {
    image: 'https://cdn.marvel.com/content/1x/fantasticfour_lob_crd_01.jpg',
    title: 'Fantastic Four',
    backgroundColor: 'bg-blue-300',
}, {
    image: 'https://cdn.marvel.com/content/1x/thunderbolts_lob_crd_01.jpg',
    title: 'ThunderBolts',
    backgroundColor: 'bg-red-300',
}]

let animations = [];


function lerp(start, end, current) {
    let distance = Math.abs(end - start);
    let currentDist = Math.max(end - current, 0);
    return 1 - Math.min(currentDist / distance, 1);
}


let init = () => {

    let container = document.getElementById('container');

    let trigger = document.getElementById('trigger');

    let animations = [];

    let cards = document.querySelectorAll('.card');

    let threshold = (1 / cards.length) * 100;

    let transitionDuration = 1000;

    cards.forEach((card, index) => {
        card.style.transform = `translateY(${index * card.getBoundingClientRect().height + 'px'})`;
    })


    let transformYValues = [0, 20, 40, 60];

    let transformXValues = [0, 20, 40, 60];


    new AnimeScrollTrigger(document.querySelector('main'), [{
        targets: cards,
        // translateY: [{
        //     value: 0,
        //     delay: (_, index) => index * transitionDuration,
        //     duration: transitionDuration,
        // }, {
        //     value: (_, index) => {
        //         let val = cards.length - index >= 1 ? transformYValues[Math.max(1 - index, 0)] : transformYValues[cards.length - index - 1];
        //         console.log(index, val)
        //         return val;
        //     },
        //     delay: (_, index) => 0,
        //     duration: transitionDuration,
        // }, {
        //     value: (_, index) => {
        //         let val = cards.length - index >= 2 ? transformYValues[Math.max(2 - index, 0)] : transformYValues[cards.length - index - 1];
        //         return val;
        //     },
        //     delay: (_, index) => index <= 2 ? transitionDuration : transitionDuration * index,
        //     duration: transitionDuration,
        // }, {
        //     value: (_, index) => {
        //         let val = cards.length - index >= 3 ? transformYValues[Math.max(3 - index, 0)] : transformYValues[cards.length - index - 1]
        //         return val;
        //     },
        //     delay: (_, index) => index <= 3 ? transitionDuration : transitionDuration * index,
        //     duration: transitionDuration,
        // }],
        translateY: [{
            value: 0,
            delay: (_, index) => index * transitionDuration,
            duration: (_, index) => transitionDuration,
        }, {
            value: (_, index) => {
                let val = transformYValues[cards.length - 1 - index];
                // console.log(index, val)
                return val;
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
                console.log(index, val)
                return val;
            },
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        // translateX: [{
        //     value: (_, index) => {
        //         let val = cards.length - index >= 1 ? transformXValues[Math.max(1 - index, 0)] : transformXValues[cards.length - index - 1];
        //         return val;
        //     },
        //     delay: (_, index) => index <= 1 ? transitionDuration : 2 * transitionDuration * index,
        //     duration: (_, index) => index <= 1 ? 0 : transitionDuration,
        // }, {
        //     value: (_, index) => {
        //         let val = cards.length - index >= 2 ? transformXValues[Math.max(2 - index, 0)] : transformXValues[cards.length - index - 1];
        //         return val;
        //     },
        //     delay: (_, index) => index <= 2 ? transitionDuration : transitionDuration * index,
        //     duration: transitionDuration,
        // }, {
        //     value: (_, index) => {
        //         let val = cards.length - index >= 3 ? transformXValues[Math.max(3 - index, 0)] : transformXValues[cards.length - index - 1]
        //         return val;
        //     },
        //     delay: (_, index) => index <= 3 ? transitionDuration : transitionDuration * index,
        //     duration: transitionDuration,
        // }],
        scrollTrigger: {
            trigger: trigger,
            // debug: true,
            pin: '#trigger',
            lerp: true,
            start: '10% center',
            end: 'bottom bottom',
            onUpdate: (_, progress) => {
                // console.log(progress)
            }
        },
    }])
}

onMounted(() => {
    init();
})
</script>

<style scoped>

</style>
