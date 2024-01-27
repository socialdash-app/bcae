<template>
    <div id="complaint-events-trigger"
         class="w-full text-gray-900 relative flex flex-col items-center">
        <div id="complaint-events-container"
             class="w-full overflow-hidden flex flex-col sticky top-0 pt-[10vh] items-center"
             style=" z-index: 100;"
             :style="{height: height + 'px'}">
            <div v-for="(complaint, index) in data.complaints"
                 style="will-change: transform;"
                 :id="`complaint-${index}`"
                 :data-index="index"
                 class="complaint flex flex-col cursor-pointer overflow-y-hidden absolute border border-gray-600 bg-[#BEF4B7] rounded p-4 md:!p-10"
                 :style="{zIndex: index * 10,height: boxHeight + 'px',width: boxWidth + 'px',transform: `translateY(${(index + 1) * boxHeight }px) scale(1)`}">
                <h1 class="font-semibold text-lg md:text-2xl">{{ complaint.title }}</h1>
                <p :style="{height: boxHeight * 0.6 + 'px'}"
                   class="text-sm overflow-hidden text-ellipsis md:!text-base mt-3 md:mt-6">
                    {{
                        truncate(complaint.description, width > 768 ? 1200 : 600)
                    }}</p>
                <button class="px-6 mt-auto self-end py-3 rounded bg-[#EE7E33] text-white"
                        @click="clickArticle(index)">
                    Read More
                </button>
            </div>
        </div>
        <div class="shrink-0 w-full" :style="{height: `${data.complaints.length * boxHeight }px`}" style="z-index: -10">

        </div>
    </div>
</template>

<script setup>
import {onMounted, reactive} from "vue";
import truncate from "../../../api/truncate.js";
import AnimeScrollTrigger from 'anime-scrolltrigger';
import anime from "animejs";
import settings from "../../../api/settings.js";

const props = defineProps([]);

const width = window.innerWidth;
const height = window.innerHeight;
const boxHeight = width > 768 ? height * 0.6 : height * 0.7;
// w-10/12 md:!w-6/12
const boxWidth = width > 768 ? width * 0.5 : width * 0.8;
let currentExpandedArticle = null;
let currentExpandedArticleIndex = null;

const data = reactive({
    complaints: [],
})

const clickArticle = (index) => {
    setTimeout(() => {
        if (currentExpandedArticleIndex === index) {
            revertArticle();
            return;
        }
        expandArticle(index)
    }, 100)

}

function revertArticle() {
    if (currentExpandedArticleIndex === null) return;
    let p = currentExpandedArticle.querySelector('p');
    p.innerText = truncate(data.complaints[currentExpandedArticleIndex].description, width > 768 ? 1200 : 600);
    currentExpandedArticle.querySelector('button').innerText = 'Read More';
    anime({
        targets: currentExpandedArticle,
        translateY: currentExpandedArticle.dataset.currentYOffset + 'px',
        scale: parseFloat(currentExpandedArticle.dataset.currentScale),
        width: boxWidth,
        height: boxHeight,
        easing: 'easeOutQuart',
        duration: 500,
        zIndex: currentExpandedArticleIndex * 10,
        complete: () => {
            document.querySelector('main').style.overflowY = 'scroll'
            currentExpandedArticle = null;
            currentExpandedArticleIndex = null;
            p.style.height = boxHeight * 0.6 + 'px';
            p.style.overflowY = 'hidden';
        }
    })

}

function expandArticle(index) {
    let article = document.getElementById(`complaint-${index}`);
    currentExpandedArticleIndex = index;
    article.style.zIndex = 1000;
    let expandedHeight = height * 0.8
    let p = article.querySelector('p');
    p.innerText = data.complaints[index].description;
    document.querySelector('main').style.overflowY = 'hidden';
    let matrix = new WebKitCSSMatrix(window.getComputedStyle(article).transform)
    article.dataset.currentYOffset = matrix.m42.toString();
    article.dataset.currentScale = matrix.a.toString();
    anime({
        targets: article,
        translateY: 0,
        scale: 1,
        width: width * 0.9,
        height: expandedHeight + 'px',
        easing: 'easeOutQuart',
        duration: 500,
        complete: () => {
            currentExpandedArticle = article;
            p.style.height = expandedHeight * 0.7 + 'px'
            p.style.overflowY = 'auto';
            currentExpandedArticle.querySelector('button').innerText = 'Close';
        }
    })
}

onMounted(() => {
    fetch('assets/data/complaints.json').then(async (res) => {
        return await res.json();
    }).then((json) => {
        data.complaints = json;
        setTimeout(() => {
            let complaintBoxes = document.querySelectorAll('.complaint');

            new AnimeScrollTrigger(document.querySelector('main'), [{
                targets: complaintBoxes,
                translateY: [{
                    value: 0,
                    delay: (_, index) => (index) * 400,
                    duration: 400,
                }, {
                    value: (_, index) => (complaintBoxes.length - index) * height * 0.05,
                    duration: 400,
                    delay: 200,
                }],
                scale: [{
                    value: (_, index) => index !== complaintBoxes.length - 1 ? 1.05 : 1,
                    delay: (_, index) => (index) * 400,
                    duration: 400,
                }, {
                    value: (_, index) => index !== complaintBoxes.length - 1 ? 1 - (complaintBoxes.length - index) * 0.02 : 1,
                    duration: 400,
                }, {
                    value: (_, index) => index !== complaintBoxes.length - 1 ? 1 - (complaintBoxes.length - index) * 0.03 : 1,
                    duration: 400,
                }, {
                    value: (_, index) => index !== complaintBoxes.length - 1 ? 1 - (complaintBoxes.length - index) * 0.04 : 1,
                    duration: 400,
                }],
                scrollTrigger: {
                    trigger: document.querySelector('#complaint-events-trigger'),
                    lerp: true,
                    start: 'top top',
                    end: 'bottom bottom',
                }
            }])

            document.addEventListener("click", (e) => {
                if (!currentExpandedArticle || e.target.tagName === 'button') {
                    return
                }
                const elementRect = currentExpandedArticle.getBoundingClientRect();
                let targetElement = e.target;
                const targetElementRect = targetElement.getBoundingClientRect();
                if (
                    targetElementRect.left < elementRect.left ||
                    targetElementRect.right > elementRect.right ||
                    targetElementRect.top < elementRect.top ||
                    targetElementRect.bottom > elementRect.bottom
                ) {
                    revertArticle()
                }
            });
        }, settings.animationDuration)
    })

})
</script>

<style scoped>

</style>
