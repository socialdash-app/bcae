<template>
    <div id="complaint-events-trigger"
         :style="{perspective: '1000px'}"
         class="w-full text-gray-900 relative flex flex-col items-center">
        <div id="complaint-events-container" class="w-full flex flex-col sticky top-0 pt-[10vh] items-center"
             style="transform-style: preserve-3d;"
             :style="{height: height + 'px'}">
            <div @click="expandArticle(index)"
                 v-for="(complaint, index) in data.complaints"
                 style="will-change: transform;"
                 :id="`complaint-${index}`"
                 class="complaint overflow-y-hidden cursor-pointer absolute border border-gray-600 bg-[#BEF4B7] rounded p-4 md:!p-10 "
                 :style="{height: boxHeight + 'px',width: boxWidth + 'px',transform: `translateY(${(index + 1) * boxHeight }px) translateZ(100px)`}">
                <h1 class="font-semibold text-lg md:text-2xl">{{ complaint.title }}</h1>
                <p class="text-sm md:!text-base mt-3 md:mt-6">{{
                        truncate(complaint.description, 800)
                    }}</p>
            </div>
        </div>
        <div class="shrink-0 w-full" :style="{height: `${data.complaints.length * boxHeight }px`}">

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
const boxHeight = width > 768 ? height * 0.5 : height * 0.7;
// w-10/12 md:!w-6/12
const boxWidth = width > 768 ? width * 0.5 : width * 0.8;
let currentExpandedArticleIndex = null;
let currentExpandedArticle = null;

const data = reactive({
    complaints: [],
})

function revertArticle() {
    if (isNaN(currentExpandedArticleIndex)) return;
    currentExpandedArticle.style.zIndex = 'auto'
    currentExpandedArticle.style.overflowY = 'hidden'
    document.getElementById('complaint-events-container').style.transformStyle = 'preserve-3d'

    currentExpandedArticle.querySelector('p').innerText = truncate(data.complaints[currentExpandedArticleIndex].description, width > 768 ? 800 : 400);
    anime({
        targets: currentExpandedArticle,
        translateZ: () => {
            return parseInt(currentExpandedArticle.dataset.currentZOffset);
        },
        translateY: () => {
            return parseInt(currentExpandedArticle.dataset.currentYOffset);
        },
        width: boxWidth,
        height: boxHeight,
        borderRadius: 4,
        easing: 'easeOutQuart',
        duration: 500,
        complete: () => {
            document.querySelector('main').style.overflowY = 'scroll'
            currentExpandedArticle.style.overflowY = 'hidden'
            currentExpandedArticle = null;
            currentExpandedArticleIndex = null;
        }
    })
}

const expandArticle = (index) => {
    let article = document.getElementById(`complaint-${index}`);
    currentExpandedArticleIndex = index;
    article.style.zIndex = 1000;
    // article.style.position = 'fixed';
    article.querySelector('p').innerText = data.complaints[index].description;
    document.querySelector('main').style.overflowY = 'hidden';
    document.getElementById('complaint-events-container').style.transformStyle = 'initial'
    let matrix = new WebKitCSSMatrix(window.getComputedStyle(article).transform)
    console.log(matrix)
    article.dataset.currentZOffset = matrix.m43.toString();
    article.dataset.currentYOffset = matrix.m42.toString();
    anime({
        targets: article,
        translateZ: 0,
        translateY: () => {
            return height * 0.1;
        },
        width: width * 0.9,
        height: height + 'px',
        borderRadius: 20,
        easing: 'easeOutQuart',
        duration: 500,
        zIndex: 10000,
        complete: () => {
            currentExpandedArticle = article;
            article.style.overflowY = 'auto';
            console.log(article.getBoundingClientRect().top)
            // onClickOutside(article, revertArticle)
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
                    value: (_, index) => (complaintBoxes.length - index) * 100,
                    duration: 400,
                    delay: 200,
                }],
                translateZ: {
                    value: (_, index) => -(complaintBoxes.length - index) * 75,
                    delay: (_, index) => (index) * 400,
                },
                scrollTrigger: {
                    trigger: document.querySelector('#complaint-events-trigger'),
                    lerp: true,
                    start: 'top top',
                    end: 'bottom bottom',
                }
            }])

            document.addEventListener("click", (e) => {
                if (!currentExpandedArticle) return;
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
