<template>
    <div class="w-full p-4 md:p-10 flex items-center flex-col gap-6 relative">
        <h1 class="w-full text-center font-bold text-2xl md:text-3xl">Election Incidents</h1>
        <div class="w-11/12 md:!w-8/12 md:mt-8 mb-12 md:gap-x-8">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
            industry's standard <span @click="(e)=>selectTopic('party tortious',e)"
                                      class="cursor-pointer sticky top-20 md:!top-4 font-semibold"
                                      :class="getBackgroundColor('party tortious')">dummy text</span>
            ever since the
            1500s, when an unknown printer took a galley of type and
            scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
            electronic typesetting, remaining <span @click="(e)=>selectTopic('reckless UEC',e)"
                                                    class="cursor-pointer sticky top-20 md:!top-4 font-semibold"
                                                    :class="getBackgroundColor('reckless UEC')">essentially unchanged.</span>
            It was popularised in the 1960s
            with the release of
            Letraset sheets containing Lorem Ipsum <span @click="(e)=>selectTopic('wrongful act',e)"
                                                         class="cursor-pointer sticky top-20 md:!top-4 font-semibold"
                                                         :class="getBackgroundColor('wrongful act')">passages</span>,
            and more recently with desktop publishing software like
            Aldus PageMaker including versions of Lorem Ipsum.
        </div>
        <div id="election-incidents-container"
             class="w-full flex flex-wrap gap-6 justify-center">
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
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import settings from "../../../api/settings.js";
import truncate from "../../../api/truncate.js";
import anime from "animejs";
import {onClickOutside} from "js-utils";
import {sleep} from "../../../api/helpers.js";

const props = defineProps([]);

const data = reactive({
    incidents: [],
    currentExpandedBoxIndex: null,
    isExpending: true,
    selectedTopic: null,
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
    })
})
</script>

<style scoped>

</style>
