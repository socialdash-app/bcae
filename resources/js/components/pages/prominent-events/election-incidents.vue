<template>
    <div class="w-full flex items-center flex-col gap-6 pt-6 relative">
        <h1 class="w-full text-center font-bold text-2xl md:text-3xl">Election Incidents</h1>
        <div class="w-11/12 md:!w-8/12 md:mt-8 mb-12 md:gap-x-8">
            The Union Election Commission (UEC) encountered some <span @click="(e)=>selectTopic('wrongful act',e)"
                                                                       class="cursor-pointer font-semibold px-1"
                                                                       :class="getBackgroundColor('wrongful act')">wrongful act</span>
            by an individual, apart from their
            <span @click="(e)=>selectTopic('reckless UEC',e)"
                  class="cursor-pointer font-semibold px-1"
                  :class="getBackgroundColor('reckless UEC')">Recklessness</span>, during the election. And, there were
            also concerns raised about
            <span
                @click="(e)=>selectTopic('party tortious',e)"
                class="cursor-pointer left-0 font-semibold px-1"
                :class="getBackgroundColor('party tortious')">party wrongdoing</span> such as
            bringing the fake stamp and ballot paper, that surfaced a confusion. These incidents have prompted
            investigations by relevant authorities to ensure the integrity of the electoral process.
        </div>
        <div :style="{background: headers[2].primaryColor}"
             id="election-incidents-button-container"
             v-show="data.showButtonContainer"
             class="w-full md:!w-11/12 lg:!w-10/12 2xl:!w-9/12 py-2 sticky top-12 md:!top-[4.6rem] z-10 flex flex-wrap justify-center gap-2 md:!gap-4">
            <button @click="(e)=>selectTopic('wrongful act',e)"
                    class="cursor-pointer px-2 py-1 rounded left-0 font-semibold"
                    :class="getBackgroundColor('wrongful act')">wrongful act
            </button>
            <button @click="(e)=>selectTopic('reckless UEC',e)"
                    class="cursor-pointer px-2 py-1 rounded font-semibold"
                    :class="getBackgroundColor('reckless UEC')">Recklessness
            </button>
            <button @click="(e)=>selectTopic('party tortious',e)"
                    class="cursor-pointer px-2 py-1 rounded font-semibold"
                    :class="getBackgroundColor('party tortious')">party wrongdoing
            </button>
        </div>
        <div id="election-incidents-container"
             class="w-full md:!w-11/12 lg:!w-10/12 2xl:!w-9/12 sticky top-36 flex flex-wrap gap-6 justify-center">
            <div
                class="w-40 md:w-64 relative election-incidents-box flex items-center justify-center cursor-pointer h-24"
                v-for="(incident,index) in data.incidents">
                <div
                    :class="getBackgroundColor(incident.topic)"
                    :style="{opacity: data.selectedTopic && data.selectedTopic !== incident.topic ? '0.4': '1'}"
                    class="absolute text-sm md:!text-base w-full top-0 left-0 h-full p-4  rounded-lg font-semibold text-gray-700"
                    @click="(e)=>clickBox(e,index)">
                    <div
                        class="w-full pointer-events-none h-full flex items-center justify-center absolute top-0 left-0 z-[1000]"
                        :class="getBackgroundColor(incident.topic)"
                        v-show="index === data.currentExpandedBoxIndex && data.isExpending">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-loader-2 animate-spin">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                    </div>
                    <p class="pointer-events-none">
                        {{
                            settings.data.locale === 'en' ? truncate(incident.description_en, 40) : truncate(incident.description_mm, 80)
                        }}
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full shrink-0" :style="{height: (width > 400 ? height * 0.5 : 0) + 'px'}">

        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import settings from "../../../api/settings.js";
import truncate from "../../../api/truncate.js";
import anime from "animejs";
import {onClickOutside} from "js-utils";
import {sleep} from "../../../api/helpers.js";
import {headers} from "../../../api/route.js";
import AnimeScrollTrigger from "anime-scrolltrigger";

const props = defineProps([]);
const height = window.innerHeight;
const width = window.innerWidth;
const data = reactive({
    incidents: [],
    currentExpandedBoxIndex: null,
    isExpending: true,
    selectedTopic: null,
    showButtonContainer: false,
})

let boxWidth = null,
    boxHeight = null;

const getBackgroundColor = (topic) => {
    switch (topic) {
        case 'party tortious':
            return 'bg-blue-200';
        case 'reckless UEC':
            return 'bg-red-200';
        case 'wrongful act':
            return 'bg-orange-200';
    }
}
const selectTopic = (topic, e) => {
    e.stopPropagation();
    setTimeout(() => {
        data.selectedTopic = topic;
    }, 50)
}

let currentExpandedBox = null, isAnimating = false;

const closeCurrentExpandedBox = async () => {
    if (!currentExpandedBox) {
        return
    }
    currentExpandedBox.style.zIndex = null;
    currentExpandedBox.style.position = null;

    anime({
        targets: currentExpandedBox,
        width: boxWidth,
        height: boxHeight,
        easing: 'easeOutQuart',
        translateX: 0,
        translateY: 0,
        duration: 500,
    })

    currentExpandedBox.querySelector('p').innerText = settings.data.locale === 'en' ? truncate(data.incidents[data.currentExpandedBoxIndex].description_en, 40) : truncate(data.incidents[data.currentExpandedBoxIndex].description_mm, 80);
    currentExpandedBox = null;
    data.currentExpandedBoxIndex = null;
    return true;
}

const expandBox = async (e, index) => {
    const box = e.target;
    if (isAnimating) await sleep(500);
    // // hide or remove if there is current expanded box
    if (currentExpandedBox) {
        if (currentExpandedBox === box) {
            return;
        }

        await closeCurrentExpandedBox()
    }
    isAnimating = true;
    const containerRect = document.getElementById('election-incidents-container').getBoundingClientRect();
    let shouldExpandToRight = true;
    let shouldExpandToBottom = true;
    const boxRect = box.getBoundingClientRect();
    //
    data.currentExpandedBoxIndex = index;
    data.isExpending = true;
    //
    const expandedWidth = boxRect.width * 2 + 24; // 16px or 1rem for gap
    const expandedHeight = boxRect.height * 2 + 24;
    const predictedRight = boxRect.left + expandedWidth;
    const predictedBottom = boxRect.top + expandedHeight;

    if (predictedRight >= containerRect.right) {
        shouldExpandToRight = false;
    }

    if (predictedBottom >= containerRect.bottom) {
        shouldExpandToBottom = false;
    }

    box.style.zIndex = 100;
    anime({
        targets: box,
        width: expandedWidth,
        height: expandedHeight,
        easing: 'easeOutQuart',
        translateX: shouldExpandToRight ? 0 : -boxRect.width - 24,
        translateY: shouldExpandToBottom ? 0 : -boxRect.height - 24,
        duration: 500,
        complete: () => {
            box.querySelector('p').innerText = settings.data.locale === 'en' ? data.incidents[index].description_en : data.incidents[index].description_mm;
            data.isExpending = false;
            currentExpandedBox = box;
            isAnimating = false;
        }
    })
}

const clickBox = (e, index) => {
    if (data.currentExpandedBoxIndex === index) {
        window.open(data.incidents[data.currentExpandedBoxIndex].url, '_blank')
        return;
    }

    expandBox(e, index)
}

const initTriggers = () => {
    new AnimeScrollTrigger(document.querySelector('main'), [{
        scrollTrigger: {
            trigger: '#election-incidents-container',
            start: '15% top',
            end: 'bottom top',
            onEnter: () => {
                data.showButtonContainer = true;
            },
            onLeaveBack: () => {
                data.showButtonContainer = false;
            }
        }
    }])
}

onMounted(() => {
    onClickOutside(document.getElementById('election-incidents-container'), function () {
        closeCurrentExpandedBox();
        data.selectedTopic = null;
    })
    fetch('assets/data/election-incidents.json').then(async (res) => {
        data.incidents = await res.json();

        setTimeout(() => {
            boxWidth = document.querySelector('.election-incidents-box').getBoundingClientRect().width;
            boxHeight = document.querySelector('.election-incidents-box').getBoundingClientRect().height;
        }, 300)

        setTimeout(() => {
            initTriggers();
        }, settings.animationDuration)
    })
})
</script>

<style scoped>

</style>
