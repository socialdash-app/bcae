<template>
    <div id="summary" class="w-full flex items-center justify-center">
        <div class="w-11/12 md:!w-10/12 flex flex-col pt-24  items-center relative">
            <h1 class="text-3xl text-white w-10/12 sticky top-24 self-start font-bold">Summary</h1>
            <div :id="`summary-${index}`" class="w-full md:!p-10 shrink-0 mt-10 relative"
                 v-for="(datum,index) in data"
                 :style="{height: 2 * height + 'px'}">
                <div class="sticky top-32 w-full py-10 flex flex-col">
                    <div class="w-full flex justify-between md:!flex-row flex-col">
                        <h1 :style="{transform: `translateY(${height}px)`}"
                            class="text-5xl summary-index transform inline-block text-white font-bold">
                            0{{ index + 1 }}
                        </h1>
                        <div class="flex flex-col w-full md:!w-5/12 mt-4 md:mt-0 text-white">
                            <h1 :style="{transform: `translateY(${height}px)`}"
                                class="text-5xl summary-title transform inline-block font-bold text-[#E8544E]">
                                {{ datum.name }}
                            </h1>
                            <p :style="{transform: `translateY(${height}px)`}"
                               class="mt-4 summary-description transform inline-block translate-y-full">
                                {{ datum.description }}</p>
                        </div>
                    </div>
                    <div class="text-white w-full mt-8">
                        <div v-for="(properties,index) in datum.data" class="w-full border-t summary-data flex"
                             :class="{'border-b':index === datum.data.length - 1}"
                             :style="{transform: `translateY(${height}px)`}">
                            <div class="py-4 w-4/12"
                                 :class="{
                                'text-right': j=== 2,
                                'text-transparent via-[#E8544E] bg-gradient-to-r bg-clip-text from-white to-[#E8544E]': j=== 0}"
                                 v-for="(property,j) in properties">
                                {{ property }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import anime from "animejs";
import settings from "../../../api/settings.js";

const props = defineProps([]);

const height = window.innerHeight;
const width = window.innerWidth;
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
    let animations = [];
    for (let i = 0; i < data.length; i++) {
        let summaryId = `summary-${i}`
        animations.push({
            targets: [`#${summaryId} .summary-index`, `#${summaryId} .summary-title`, `#${summaryId} .summary-description`],
            translateY: '0px',
            easing: 'easeOutQuart',
            duration: 1000,
            scrollTrigger: {
                trigger: `#${summaryId}`,
                start: 'top center',
                end: 'center center',
                lerp: true,
            },
        })

        animations.push({
            targets: `#${summaryId} .summary-data`,
            translateY: '0px',
            delay: (_, index) => index * 200,
            easing: 'easeOutQuart',
            scrollTrigger: {
                trigger: `#${summaryId}`,
                start: 'center center',
                end: 'bottom bottom',
                lerp: true,
            },
        })
    }
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), animations)
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
