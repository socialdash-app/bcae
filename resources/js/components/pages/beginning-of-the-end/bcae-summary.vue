<template>
    <div id="summary" class="w-full flex justify-center relative" :style="{height:300 + 'vh'}">
        <div id="summary-pinner" class="w-10/12 p-10 h-screen text-white flex flex-col gap-y-12">
            <h1 class="text-xl font-semibold">Summary</h1>
            <div class="summary-header flex items-center font-semibold  w-full justify-between">
                <div class="overflow-hidden w-2/12 relative h-28 text-6xl flex flex-col">
                    <p :style="{transform: `translateY(${index * 150}%)`}" v-for="(_,index) in data"
                       class="absolute text-4xl pb-12 summary-index"> 0{{ index }}</p>
                </div>
                <div class="flex w-4/12 gap-y-8 flex-col">
                    <div class="overflow-hidden h-32 relative text-6xl font-bold">
                        <h1 class="summary-title pb-12 h-28 text-[#E8544E] absolute"
                            :style="{transform: `translateY(${index * 150}%)`}"
                            v-for="(datum,index) in data">
                            {{ datum.name }}</h1>
                    </div>
                    <div class="overflow-hidden relative h-28">
                        <h1 class="summary-description absolute pb-12"
                            :style="{transform: `translateY(${index * 150}%)`}"
                            v-for="(datum,index) in data">
                            {{ datum.description }}</h1>
                    </div>
                </div>
            </div>
            <div id="summary-data-table" class="w-full flex flex-col">
                <div class="w-full h-16 border-t border-b py-4 relative overflow-hidden">
                    <div v-for="(datum,index) in data"
                         :style="{transform: `translateY(${index * 150}%)`}"
                         class="w-full first-row absolute flex pb-12 items-center justify-between">
                        <div :class="{'text-center': i === 1,'text-right': i===2}"
                             class="w-4/12"
                             v-for="(value,i) in datum.data[0]" v-if="datum.data[0]">
                            {{ value }}
                        </div>
                    </div>
                </div>
                <div class="w-full h-16 border-b py-4 relative overflow-hidden">
                    <div v-for="(datum,index) in data"
                         :style="{transform: `translateY(${index * 150}%)`}"
                         class="w-full second-row  absolute flex pb-12 items-center justify-between">
                        <div :class="{'text-center': i === 1,'text-right': i===2}"
                             class="w-4/12"
                             v-for="(value,i) in datum.data[1]" v-if="datum.data[1]">
                            {{ value }}
                        </div>
                    </div>
                </div>
                <div class="w-full h-16 border-b py-4 relative overflow-hidden">
                    <div v-for="(datum,index) in data"
                         :style="{transform: `translateY(${index * 150}%)`}"
                         class="w-full third-row absolute flex pb-12 items-center justify-between">
                        <div :class="{'text-center': i === 1,'text-right': i===2}"
                             class="w-4/12"
                             v-for="(value,i) in datum.data[2]" v-if="datum.data[2]">
                            {{ value }}
                        </div>
                    </div>
                </div>
                <div class=" w-full h-16 border-b py-4 relative overflow-hidden">
                    <div v-for="(datum,index) in data"
                         :style="{transform: `translateY(${index * 150}%)`}"
                         class="w-full fourth-row absolute flex pb-12 items-center justify-between">
                        <div :class="{'text-center': i === 1,'text-right': i===2}"
                             class="w-4/12"
                             v-for="(value,i) in datum.data[3]" v-if="datum.data[3]">
                            {{ value }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div id="summary-trigger">-->

        <!--        </div>-->
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from "../../../../../../scrollanime/index.js";
import anime from "animejs";

const props = defineProps([]);

// const reactiveData = reactive({
//     current
// })

const data = [{
    name: 'Election Results',
    description: 'Lorem ipsum dolor sit amet consectetur. Laoreet elementum viverra maecenas odio vitae nibh enim varius. Odio a tincidunt arcu malesuada lectus.',
    data: [
        ['Amyotha Hluttaw', 'Total Votes', '26702406'],
        ['Pyithu Hluttaw', 'Total Votes', '26669636'],
        ['State & Regions Hluttaw', 'Total Votes', '26181274'],
        ['Ethnic Affairs Ministers', 'Total Votes', '3522883'],
        ['', 'Total Winning Parties Vs Total parties', '19/88']
    ]
}, {
    name: 'Party Complaints',
    description: 'Lorem ipsum dolor sit amet consectetur. Laoreet elementum viverra maecenas odio vitae nibh enim varius. Odio a tincidunt arcu malesuada lectus.',
    data: [
        ['Parties', 'to UEC', '7'],
        ['Parties', 'to MAL', '34'],
        ['Parties', 'to government', '19'],
    ]
}, {
    name: 'DS-Info Announcement',
    description: 'Lorem ipsum dolor sit amet consectetur. Laoreet elementum viverra maecenas odio vitae nibh enim varius. Odio a tincidunt arcu malesuada lectus.',
    data: [
        ['Series', '', '29'],
        ['Fraud Votes', '', '200000'],
    ]
}, {
    name: 'Party Actions',
    description: 'Lorem ipsum dolor sit amet consectetur. Laoreet elementum viverra maecenas odio vitae nibh enim varius. Odio a tincidunt arcu malesuada lectus.',
    data: [
        ['Number of parties', '', '9'],
        ['Posted about election fraud', '', '97'],
    ]
}, {
    name: 'Correlated Actions',
    description: 'Lorem ipsum dolor sit amet consectetur. Laoreet elementum viverra maecenas odio vitae nibh enim varius. Odio a tincidunt arcu malesuada lectus.',
    data: [
        ['Protest', '', '88'],
        ['Disinformation', '', '215'],
    ]
}]

onMounted(() => {
    let duration = 1500;
    let summaryIndexes = document.querySelectorAll('.summary-index')
    let summaryTitles = document.querySelectorAll('.summary-title')
    let summaryDescriptions = document.querySelectorAll('.summary-description')
    let firstRows = document.querySelectorAll('#summary .first-row')
    let secondRows = document.querySelectorAll('#summary .second-row')
    let thirdRows = document.querySelectorAll('#summary .third-row')
    let fourthRows = document.querySelectorAll('#summary .fourth-row')
    let stopPercentages = [];
    let animations = [];
    let divider = 100 / summaryIndexes.length;
    let translatePercentages = [-150, 0, 150, 300, 450, 600];
    let startIndex = 1;
    for (let i = 0; i < summaryIndexes.length; i++) {
        animations.push([
            {
                targets: summaryIndexes,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)];
                }
            }, {
                targets: summaryTitles,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)]
                }
            }, {
                targets: summaryDescriptions,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)]
                }
            }, {
                targets: firstRows,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)]
                }
            }, {
                targets: secondRows,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)]
                }
            }, {
                targets: thirdRows,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)]
                }
            }, {
                targets: fourthRows,
                duration: duration,
                easing: 'easeOutQuart',
                translateY: (el, index) => {
                    return translatePercentages[Math.max(index + startIndex - i, 0)]
                }
            },
        ])
        stopPercentages.push(i * divider);
        // let animation = {
        //     titles: {
        //         translateY: [],
        //     },
        //     posts: {
        //         translateX: [],
        //         translateY: [],
        //     }
        // };
        // articles.forEach((article, index) => {
        //     animation.titles.translateY.push(titleTranslateY[Math.max(index + startIndex - i, 0)]);
        //     animation.posts.translateY.push(postTranslateY[Math.max(index + startIndex - i, 0)])
        //     animation.posts.translateX.push(postTranslateX[Math.max(index + startIndex - i, 0)])
        // })
        // animations.push(animation)
    }
    console.log(stopPercentages)
    let currentIndex = 0;
    let timeout = null;
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            scrollTrigger: {
                trigger: document.querySelector('#summary'),
                lerp: true,
                start: 'top top',
                end: 'bottom bottom',
                pin: '#summary-pinner',
                onUpdate: (_, progress) => {
                    if (timeout) clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        let percentage = Math.round(progress * 100);
                        let ps = stopPercentages.filter((p) => percentage > p);
                        if (ps.length > 0) {
                            let index = ps.length - 1;
                            if (index !== currentIndex) {
                                currentIndex = index;
                                let animes = animations[currentIndex];
                                animes.forEach((animation) => {
                                    anime(animation)
                                })
                            }
                        }
                    }, 10)
                }
            }
        }])
    }, 1200)
})
</script>

<style scoped>

</style>
