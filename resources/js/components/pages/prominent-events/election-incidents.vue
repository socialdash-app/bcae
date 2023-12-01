<template>
    <div class="w-full p-10 flex flex-col gap-6">
        <h1 class="w-full text-center font-bold text-3xl">Election Incidents</h1>
        <div class="w-full mt-8 mb-12 flex gap-x-8 justify-center items-center">
            <div class="flex items-center gap-x-4">
                <span class="w-5 h-5 rounded" :class="getBackgroundColor('party tortious')"></span>
                <p class="text-gray-700">Party Tortious</p>
            </div>
            <div class="flex items-center gap-x-4">
                <span class="w-5 h-5 rounded" :class="getBackgroundColor('reckless UEC')"></span>
                <p class="text-gray-700">Reckless UEC</p>
            </div>
            <div class="flex items-center gap-x-4">
                <span class="w-5 h-5 rounded" :class="getBackgroundColor('wrongful act')"></span>
                <p class="text-gray-700">Wrongful Act</p>
            </div>
        </div>
        <div id="election-incidents-container"
             class="w-full flex flex-wrap gap-6 justify-center">
            <div class="w-64 relative election-incidents-box flex items-center justify-center cursor-pointer h-32"
                 v-for="(incident,index) in data.incidents">
                <div
                    :class="getBackgroundColor(incident.topic)"
                    class="absolute w-full top-0 left-0 h-full p-4  rounded-lg font-semibold text-gray-700"
                    @click="(e)=>expandBox(e,index)">
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

const props = defineProps([]);

const data = reactive({
    incidents: [],
    currentExpandedBoxIndex: null,
    isExpending: true,
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

let currentExpandedBox = null;

const closeCurrentExpandedBox = () => {
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
}

const expandBox = (e, index) => {
    const containerRect = document.getElementById('election-incidents-container').getBoundingClientRect();
    const box = e.target;
    let shouldExpandToRight = true;
    let shouldExpandToBottom = true;
    const boxRect = box.getBoundingClientRect();
    // // hide or remove if there is current expanded box
    if (currentExpandedBox) {
        if (currentExpandedBox === box) {
            return;
        }

        closeCurrentExpandedBox()
    }
    //
    data.currentExpandedBoxIndex = index;
    data.isExpending = true;
    //
    const expandedWidth = boxRect.width * 2 + 32; // 16px or 1rem for gap
    const expandedHeight = boxRect.height * 2 + 32;
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
        translateX: shouldExpandToRight ? 0 : -boxRect.width - 32,
        translateY: shouldExpandToBottom ? 0 : -boxRect.height - 32,
        duration: 500,
        complete: () => {
            box.querySelector('p').innerText = settings.data.locale === 'en' ? data.incidents[index].description_en : data.incidents[index].description_mm;
            data.isExpending = false;
            currentExpandedBox = box;
        }
    })


}

onMounted(() => {
    onClickOutside(document.getElementById('election-incidents-container'), function () {
        closeCurrentExpandedBox();
    })
    axios.post('prominent-events/election-incidents').then((res) => {
        data.incidents = res.data;

        setTimeout(() => {
            boxWidth = document.querySelector('.election-incidents-box').getBoundingClientRect().width;
            boxHeight = document.querySelector('.election-incidents-box').getBoundingClientRect().height;
        }, 300)
    })
})
</script>

<style scoped>

</style>
