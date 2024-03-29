<template>
    <div class="relative w-full flex items-center flex-col"
         :style="{height: `${height * fourStatements.length}px`}" id="four-statements-trigger">
        <div id="four-statements-container" :style="{height: height + 'px'}"
             class="flex flex-col sticky top-0 justify-center overflow-hidden  w-full items-center">
            <div v-for="(statement,index) in fourStatements"
                 :style="{height : boxHeight + 'px', width: boxWidth + 'px', transform: `translateY(${index * height}px)`}"
                 :id="`four-statements-${index}`"
                 class="four-statement z-10 flex flex-col p-4 md:!p-10 bg-[#AAE998] text-gray-800 border border-gray-600 gap-y-4 md:!gap-y-8 absolute rounded-2xl items-center">
                <h1 class="text-2xl font-bold">{{ statement.title }}</h1>
                <h2 class="text-lg font-semibold">{{ statement.subtitle }}</h2>
                <div class="h-[70%] overflow-hidden text-ellipsis"
                     v-html="truncate(statement.description, width > 768 ? 1000 : 600)">

                </div>
                <button v-text="data.currentExpandedArticleIndex === index ? 'Close' : 'Read More'"
                        class="px-6 self-end py-3 rounded bg-[#EE7E33] text-white" @click="clickArticle(index)">

                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import truncate from "../../../api/truncate.js";
import {onMounted, reactive} from "vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import {fourStatements} from "../beginning-of-the-end/data.js";
import settings from "../../../api/settings.js";
import anime from "animejs";

const props = defineProps([]);

const height = window.innerHeight;

const width = window.innerWidth;

const data = reactive({
    currentExpandedArticleIndex: null,
})
let currentExpandedArticle = null;

const boxHeight = height * 0.7;

const boxWidth = width > 768 ? width * 0.5 : width * 0.91667;

const clickArticle = (index) => {
    setTimeout(() => {
        if (data.currentExpandedArticleIndex === index) {
            revertArticle();
            return;
        }
        expandArticle(index)
    }, 300)

}

function revertArticle() {
    if (isNaN(data.currentExpandedArticleIndex)) return;
    currentExpandedArticle.style.zIndex = 'auto'
    currentExpandedArticle.style.overflowY = 'hidden';
    currentExpandedArticle.style.zIndex = 10;
    let p = currentExpandedArticle.querySelector('div');
    p.style.height = boxHeight * 0.7 + 'px';
    p.style.overflow = 'hidden';
    p.innerText = truncate(fourStatements[data.currentExpandedArticleIndex].description, width > 768 ? 1000 : 600);
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
        borderRadius: 16,
        easing: 'easeOutQuart',
        duration: 500,
        complete: () => {
            document.querySelector('main').style.overflowY = 'scroll'
            currentExpandedArticle.style.overflowY = 'hidden'
            currentExpandedArticle = null;
            data.currentExpandedArticleIndex = null;
        }
    })

}

function expandArticle(index) {
    let article = document.getElementById(`four-statements-${index}`);
    data.currentExpandedArticleIndex = index;
    article.style.zIndex = 1000;
    let p = article.querySelector('div');
    p.style.height = 'auto';
    p.innerHTML = fourStatements[index].description;
    p.style.overflowY = 'auto';
    document.querySelector('main').style.overflowY = 'hidden';
    let matrix = new WebKitCSSMatrix(window.getComputedStyle(article).transform)
    article.dataset.currentZOffset = matrix.m43.toString();
    article.dataset.currentYOffset = matrix.m42.toString();
    anime({
        targets: article,
        translateZ: 0,
        translateY: () => {
            return 0;
        },
        width: width * 0.9,
        height: height * 0.8 + 'px',
        borderRadius: 20,
        easing: 'easeOutQuart',
        duration: 500,
        complete: () => {
            currentExpandedArticle = article;
            article.style.overflowY = 'auto';
        }
    })
}

let init = () => {
    let trigger = document.getElementById('four-statements-trigger');

    let cards = document.querySelectorAll('.four-statement');

    let transitionDuration = 1000;

    let transformMultiplier = width > 768 ? 20 : 10;

    let transformValues = [];

    cards.forEach((card, index) => {
        card.style.transform = `translateY(${index * card.getBoundingClientRect().height + 'px'})`;
        transformValues.push((index + 1) * transformMultiplier)
    })

    new AnimeScrollTrigger(document.querySelector('main'), [{
        targets: cards,
        translateY: [{
            value: (_, index) => index * height,
            delay: 0,
        }, {
            value: 0,
            delay: (_, index) => index * transitionDuration,
            duration: (_, index) => transitionDuration,
        }, {
            value: (_, index) => {
                // console.log(index, val)
                return transformValues[cards.length - 1 - index];
            },
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        translateX: [{
            value: 0,
            delay: (_, index) => index * transitionDuration,
            duration: (_, index) => transitionDuration,
        }, {
            value: (_, index) => transformValues[cards.length - 1 - index],
            duration: (_, index) => Math.max(transitionDuration, (cards.length - index) * transitionDuration),
        }],
        scrollTrigger: {
            trigger: trigger,
            lerp: true,
            start: 'top top',
            end: 'bottom bottom',
        },
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
}
onMounted(() => {
    setTimeout(() => {
        init();
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
