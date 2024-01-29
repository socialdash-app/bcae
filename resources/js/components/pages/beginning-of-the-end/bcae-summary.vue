<template>
    <div id="summary" class="w-full flex items-center justify-center">
        <div class="w-11/12 md:!w-10/12 flex flex-col pt-24  items-center relative">
            <h1 :style="{background: headers[6].primaryColor}"
                class="text-3xl text-white w-full sticky md:!pt-24 z-10 pt-20 top-0 self-start font-bold">Summary</h1>
            <div :id="`summary-${index}`" class="w-full md:!p-10 shrink-0 mt-10 relative"
                 v-for="(datum,index) in data"
                 :style="{height: 2 * height + 'px'}">
                <div class="sticky top-28 md:!top-32 w-full py-10 flex flex-col">
                    <div class="w-full flex justify-between md:!flex-row flex-col">
                        <h1 :style="{transform: `translateY(${height}px)`}"
                            class="text-3xl md:!text-5xl summary-index transform inline-block text-white font-bold">
                            0{{ index + 1 }}
                        </h1>
                        <div class="flex flex-col w-full md:!w-5/12 mt-4 md:mt-0 text-white">
                            <h1 :style="{transform: `translateY(${height}px)`, color: headers[6].secondaryColor}"
                                class="text-3xl md:!text-5xl summary-title transform inline-block font-bold">
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
import {headers} from "../../../api/route.js";

const props = defineProps([]);

const height = window.innerHeight;
const width = window.innerWidth;
const data = [{
    name: 'Election Results',
    description: 'Total votes cast to take the seats in the national legislature',
    data: [
        ['Amyotha Hluttaw', 'Total Votes', '26702406'],
        ['Pyithu Hluttaw', 'Total Votes', '26669636'],
        ['', 'Total Winning Parties Vs Total parties', '14/88']
    ]
}, {
    name: 'Prominent events',
    description: ' Incidents during the election and key events between two standing grounds',
    data: [
        ['Total MPs demand to convene a special session', '', '203'],
        ['Major incidents during the election', '', 'three boxes of election incidents colored accordingly'],
    ]
}, {
    name: 'Party reactions',
    description: 'How do the parties respond to the dispute about the election',
    data: [
        ['Total posts circulating on Facebook', '', '97'],
        ['Total objection letters from parties', '', '194'],
        ['Total parties that sent an open letter to the government', '', '19'],
    ]
}, {
    name: 'The Military',
    description: 'Military constructed narrative of voter fraud and allegation',
    data: [
        ['Total response statements', '', '5'],
        ['Statements of findings in scrutiny of voter lists', '', '29'],
    ]
}, {
    name: 'Correlated Actions',
    description: 'Rally the crowd X web of disinformation',
    data: [
        ['Total protest', '', '88'],
        ['Total disinformation content', '', '604'],
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
