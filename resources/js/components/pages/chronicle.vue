<template>
    <div id="chronicle-trigger" class="w-full flex relative bg-[#FFF21F] flex-col items-center">
        <div class="sticky pl-12 top-14 w-11/12 z-[100]">
            <h1 class="text-3xl font-bold">Chronicles</h1>
        </div>
        <div id="chronicle"
             class="w-11/12 pt-24 items-center md:!items-start md:!w-9/12 md:!flex-row flex-col flex justify-between">
            <div class="w-11/12 md:!w-5/12 h-[50vh] md:!h-[60vh] sticky top-24 left-0">
                <div class="relative w-full h-full">
                    <div class="justify-between chronicle-illustration flex flex-col w-full absolute h-full"
                         :style="{transform: `translateX(${index * 120}%)`, opacity: index === 0? 1: 0}"
                         v-for="(description,index) in descriptions">
                        <div :class="description.bg" class="h-5/6 w-full">

                        </div>
                    </div>
                </div>
                <div :style="{transform: `translateX(${index * 120}%)`}"
                     class="flex chronicle-year-indicator absolute w-full flex-col -mt-4"
                     v-for="(description,index) in descriptions">
                    <span class="h-7 w-1 bg-black"></span>
                    <h1 class="text-2xl font-semibold -mb-4">{{ description.title }}</h1>
                </div>
                <div class="absolute -left-[9.9%] md:!-left-[42%] bottom-0 w-screen py-1 bg-black">
                </div>
            </div>
            <div class="w-full md:!w-5/12 flex flex-col z-10">
                <div
                    class="flex chronicle-content rounded border shrink-0 gap-y-4 px-4 py-6 md:!px-8 md:!py-12 bg-black text-white flex-col w-full"
                    :style="{marginBottom: index !== descriptions.length - 1 ? '24rem':'0'}"
                    v-for="(description,index) in descriptions">
                    <p class="w-full text-white">{{ description.description }}</p>
                </div>
                <div class="shrink-0 md:h-[60vh] h-[30vh]">
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
    let chronicleYearIndicators = document.querySelectorAll('.chronicle-year-indicator');
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
                start: 'top center',
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
                    anime({
                        targets: chronicleYearIndicators,
                        easing: 'easeOutQuart',
                        duration: duration,
                        translateX: (el, index) => {
                            return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
                        },
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
                    anime({
                        targets: chronicleYearIndicators,
                        easing: 'easeOutQuart',
                        duration: duration,
                        translateX: (el, index) => {
                            return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
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
        }
    })
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
