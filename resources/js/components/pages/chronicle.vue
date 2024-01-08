<template>
    <div id="chronicle-trigger" class="w-full pt-24 flex relative bg-[#FFF21F] flex-col items-center">
        <div id="chronicle" class="w-9/12 flex justify-between">
            <div class="w-5/12 h-[60vh] sticky top-24 left-0">
                <div class="relative w-full h-full">
                    <div class="justify-between chronicle-illustration flex flex-col w-full absolute h-full"
                         :style="{transform: `translateX(${index * 120}%)`, opacity: index === 0? 1: 0}"
                         v-for="(description,index) in descriptions">
                        <div :class="description.bg" class="h-5/6 w-full">

                        </div>
                        <div class="flex flex-col -mb-6">
                            <span class="h-8 w-2 bg-black"></span>
                            <h1 class="text-2xl font-bold -mb-4">{{ description.title }}</h1>
                        </div>
                    </div>
                </div>
                <div class="absolute -left-[42%] bottom-0 w-screen py-1 bg-black">

                </div>
            </div>

            <div class="w-5/12 flex flex-col">
                <div
                    class="flex chronicle-content h-[60vh] rounded border shrink-0 gap-y-4 p-6 bg-black text-white flex-col w-full"
                    :style="{marginBottom: index !== descriptions.length - 1 ? '24rem':'0'}"
                    v-for="(description,index) in descriptions">
                    <h1 class="w-full font-semibold text-4xl">
                        {{ description.title }}</h1>
                    <p class="w-full text-white">{{ description.description }}</p>
                </div>
                <div class="shrink-0" style="height: 30vh">

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from 'anime-scrolltrigger'
import anime from "animejs";
import route from "../../api/route.js";

const props = defineProps([]);

const data = [{}]

const descriptions = [{
    title: '1957',
    bg: 'bg-red-300',
    description: 'The story starts with the military coup-as-per-the-constitution that took place in 1958 when the military pressured a civilian government, which was dealing with divisions within the ruling party, to relinquish state power to the military. Prime Minister U Nu and his cabinet resigned on 28 October, 1958, and handed over power to General Ne Win, who formed a caretaker government to preserve the country.'
}, {
    title: '1962',
    bg: 'bg-blue-300',
    description: 'On 2 March, 1962, General Ne Win and a group of military officers overthrew the Government of Premier U Nu in a swift bloodless coup d\'etat, and established the period of direct military rule and held power for the next twenty-six years. After the coup, General Ne Win formed Revolutionary Council to act as interim government, and the RC has declared that it intends to continue a "neutral" foreign policy.'
}, {
    title: '1988',
    bg: 'bg-gray-300',
    description: 'After the 8888 national uprising aka the People Power Uprising against the Burma Socialist Programme Party government, the third military coup was occurred on 18 September, 1988. The uprising ended with the bloody military coup by the State Law and Order Restoration Council. During the uprising, thousands of people have been killed.'
}, {
    title: '1990',
    bg: 'bg-orange-300',
    description: 'The National League for Democracy formed on September 27, 1988, a week after the formation of the State Law and Order Restoration Council, and won 392 of 492 parliamentary seats in the General elections of 1990, but the military council didn\'t handover power to winning party and canceled the election result. After that, it changed its name to State Peace and Development Council in 1997 and ruled until 2010.'
}, {
    title: '2021',
    bg: 'bg-orange-300',
    description: 'On 1 February, 2021, the military led by Min Aung Hlaing seized state power from a democratically elected government, by announcing a one-year state of emergency period under the pretext of vote fraud. People resisted the coup with protests and rallies across the country, but faced violent repression by the military, resulting the formation of a parallel government and allied with armed groups to fight the junta.'
}];

const translateMultiplier = 120;

const init = () => {
    let chronicleIllustrations = document.querySelectorAll('.chronicle-illustration');
    let chronicleContents = document.querySelectorAll('.chronicle-content');
    let animations = [];
    let stopPercentages = [];
    let duration = 1500;
    let t = [];
    let divider = 100 / descriptions.length;
    for (let i = 0; i <= descriptions.length - 1; i++) {
        animations.push({
            scrollTrigger: {
                trigger: chronicleContents[i],
                start: 'top 20%',
                end: 'bottom 20%',
                onEnter: () => {
                    anime({
                        targets: chronicleIllustrations,
                        easing: 'easeOutQuart',
                        duration: duration,
                        translateX: (el, index) => {
                            return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
                        },
                        opacity: [{
                            value: (_, index) => {
                                return index === i ? 1 : 0;
                            },
                            delay: duration / 3,
                        }]
                    })
                },
                onEnterBack: () => {
                    anime({
                        targets: chronicleIllustrations,
                        easing: 'easeOutQuart',
                        duration: duration,
                        translateX: [{
                            value: (el, index) => {
                                return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
                            },
                            delay: duration / 3,
                        }],
                        opacity: (_, index) => {
                            return index === i ? 1 : 0;
                        },
                    })
                }
            }
        })
        t.push(Object.assign({}, window.getComputedStyle(chronicleIllustrations[i])));
    }

    animations.push({
        targets: '#header-chronicle circle',
        strokeDashoffset: 0,
        // easing: 'easeOutBounce',
        scrollTrigger: {
            smooth: true,
            trigger: '#chronicle-trigger',
            start: 'top top',
            end: 'bottom top',
            lerp: true,
            onEnter: () => {
                route.changeSectionHeader(0)
                console.log('enter chronicle')
            },
            onEnterBack: () => {
                route.changeSectionHeader(0)
                console.log('enter back chronicle');
            },
            onUpdate: (_, progress) => {
            }
        }
    })

    // scaleX(), skewY(), skewX(), scaleY(), translateX(), translateY()
    // anime({
    //     targets: '.lucide-history',
    //     translateY: 10,
    //     translateX: 11,
    //     scaleX: 30,
    //     scaleY: 31,
    //     skewX: 22,
    //     skewY: 11,
    //     // transform: 'matrix(1, 0, 0, 1, 20, 10)',
    //     autoplay: true,
    //     complete: () => {
    //         console.log(window.getComputedStyle(document.querySelector('.lucide-history')).transform)
    //     }
    // })

    new AnimeScrollTrigger(document.querySelector('main'), animations)
}

onMounted(() => {
    setTimeout(() => {
        init()
    }, 2000)
})
</script>

<style scoped>

</style>
