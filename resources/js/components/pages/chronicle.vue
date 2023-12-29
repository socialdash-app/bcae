<template>
    <div id="chronicle-trigger" class="w-full bg-[#fff562] flex relative flex-col items-center">
        <div class="w-full flex justify-between z-[100] h-24 items-center px-20 sticky top-0 left-0">
            <h1 class="text-xl font-semibold">Chronicle</h1>
            <div id="t" class="relative flex items-center justify-center">
                <svg width="60" height="60" viewBox="0 0 60 60">
                    <circle id="chronicle-progress-indicator" stroke-dashoffset="160" stroke-dasharray="160" r="25"
                            fill="none" stroke-width="8"
                            stroke="#FF7F00" cx="30"
                            cy="30"></circle>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide absolute w-7 h-7 lucide-history">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M12 7v5l4 2"/>
                </svg>
            </div>
        </div>
        <div id="chronicle" class="w-9/12 relative flex justify-between">
            <div class="w-5/12 h-[60vh] sticky overflow-hidden top-24 left-0">
                <div class="chronicle-illustration w-full absolute h-5/6"
                     :style="{transform: `translateX(${index * 120}%)`}"
                     :class="description.bg" v-for="(description,index) in descriptions">
                </div>
            </div>
            <div class="w-5/12 flex flex-col">
                <div
                    class="flex chronicle-content h-[60vh] rounded border shrink-0 gap-y-4 p-6 bg-gray-100 flex-col w-full"
                    :style="{marginBottom: index !== descriptions.length - 1 ? '24rem':'0'}"
                    v-for="(description,index) in descriptions">
                    <h1 class="w-full font-semibold text-4xl">
                        {{ description.title }}</h1>
                    <p class="w-full text-gray-700">{{ description.description }}</p>
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

const props = defineProps([]);

const data = [{}]

const descriptions = [{
    title: '1958',
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
                        }
                    })
                },
                onEnterBack: () => {
                    anime({
                        targets: chronicleIllustrations,
                        easing: 'easeOutQuart',
                        duration: duration,
                        translateX: (el, index) => {
                            return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
                        }
                    })
                }
            }
        })
        t.push(Object.assign({}, window.getComputedStyle(chronicleIllustrations[i])));
    }

    let b = anime({
        targets: t,
        height: '400px',
        width: '400px',
        autoplay: false,
    })

    animations.push({
        targets: '#chronicle-progress-indicator',
        strokeDashoffset: 0,
        // easing: 'easeOutBounce',
        scrollTrigger: {
            smooth: true,
            trigger: '#chronicle-trigger',
            start: 'top top',
            end: 'bottom bottom',
            lerp: true,
            onUpdate: (_, progress) => {
                // b.seek(b.duration * progress);
                // let animation = {};
                // b.animations.forEach((a) => {
                //     if (!animation[a.property]) {
                //         animation[a.property] = [];
                //     }
                //     animation[a.property][a.animatable.id] = a.currentValue;
                // })
                // let c = {};
                // Object.keys(animation).forEach((g)=>{
                //     c[g] = (_,index) => animation[g][index];
                // })
                // a.animations.forEach((animation) => {
                //     console.log(animation)
                // })
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
    }, 500)
})
</script>

<style scoped>

</style>
