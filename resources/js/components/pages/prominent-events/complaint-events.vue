<template>
    <div id="complaint-events-trigger"
         class="w-full text-gray-700 relative flex flex-col items-center">
        <div class="w-full flex flex-col sticky justify-center top-0 h-screen items-center"
             id="complaint-events-pinner">
            <div @click="expandArticle(index)"
                 v-for="(complaint, index) in complaints"
                 style="will-change: transform;height: 400px;"
                 :id="`complaint-${index}`"
                 class="complaint overflow-y-auto cursor-pointer absolute border bg-green-300 rounded p-10 w-6/12"
                 :style="{transform: `translate3d(${ index % 2 === 0 ? 400: -400}px,${index * 800}px,0)`}">
                <h1 class="font-semibold text-2xl">{{ complaint.title }}</h1>
                <p class="mt-6">{{ truncate(complaint.description, 800) }}</p>
            </div>
        </div>
        <div :style="{height: `${complaints.length * 400}px`}">

        </div>
    </div>
</template>

<script setup>
import {onMounted, reactive} from "vue";
import truncate from "../../../api/truncate.js";
import AnimeScrollTrigger from 'anime-scrolltrigger';
import anime from "animejs";
import {onClickOutside} from "js-utils";

const props = defineProps([]);

const complaints = [{
    title: '19 Parties complaints blah blah...',
    description: 'Lorem ipsum dolor sit amet consectetur. Faucibus pellentesque purus pellentesque congue suspendisse integer dapibus ac. Tellus pellentesque sed vel tincidunt erat rhoncus commodo dui. Pharetra faucibus arcu blandit mauris sagittis donec felis. Hac pellentesque faucibus tristique hendrerit vitae velit. A ornare mattis a egestas praesent integer fermentum mi amet. Accumsan at odio ornare morbi duis urna id bibendum lectus....',
}, {
    title: 'On 11.1.2021 blah blah...',
    description: 'orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n' +
        'Why do we use it?\n' +
        '\n' +
        'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\n' +
        '\n' +
        'Where does it come from?\n' +
        '\n' +
        'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.\n' +
        '\n' +
        'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.\n' +
        'Where can I get some?\n' +
        '\n' +
        'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.',
}, {
    title: 'On 12.1.2021, Government respond to blah blah',
    description: 'Lorem ipsum dolor sit amet consectetur. Faucibus pellentesque purus pellentesque congue suspendisse integer dapibus ac. Tellus pellentesque sed vel tincidunt erat rhoncus commodo dui. Pharetra faucibus arcu blandit mauris sagittis donec felis. Hac pellentesque faucibus tristique hendrerit vitae velit. A ornare mattis a egestas praesent integer fermentum mi amet. Accumsan at odio ornare morbi duis urna id bibendum lectus....',
}, {
    title: 'On 14.1.2021, Ds-info respond to blah blah...',
    description: 'Lorem ipsum dolor sit amet consectetur. Faucibus pellentesque purus pellentesque congue suspendisse integer dapibus ac. Tellus pellentesque sed vel tincidunt erat rhoncus commodo dui. Pharetra faucibus arcu blandit mauris sagittis donec felis. Hac pellentesque faucibus tristique hendrerit vitae velit. A ornare mattis a egestas praesent integer fermentum mi amet. Accumsan at odio ornare morbi duis urna id bibendum lectus....',
}]
const data = reactive({})
let currentExpandedArticleIndex = null;
let currentExpandedArticle = null;

function revertArticle() {
    if (isNaN(currentExpandedArticleIndex)) return;
    currentExpandedArticle.style.zIndex = 'auto'
    currentExpandedArticle.style.overflowY = 'hidden'
    currentExpandedArticle.querySelector('p').innerText = truncate(complaints[currentExpandedArticleIndex].description, 800);
    anime({
        targets: currentExpandedArticle,
        translateX: () => {
            return parseInt(currentExpandedArticle.dataset.currentXOffset);
        },
        translateY: () => {
            return parseInt(currentExpandedArticle.dataset.currentYOffset);
        },
        // width: '50%',
        height: '400px',
        borderRadius: 4,
        easing: 'easeOutQuart',
        duration: 500,
        complete: () => {
            document.querySelector('main').style.overflowY = 'scroll'
            currentExpandedArticle.style.overflowY = 'initial'
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
    article.querySelector('p').innerText = complaints[index].description;
    document.querySelector('main').style.overflowY = 'hidden';
    let matrix = new WebKitCSSMatrix(window.getComputedStyle(article).transform)
    article.dataset.currentXOffset = matrix.m41.toString();
    article.dataset.currentYOffset = matrix.m42.toString();
    anime({
        targets: article,
        translateX: 0,
        translateY: () => {
            return -article.getBoundingClientRect().top + (window.innerHeight * 0.15) + matrix.m42;
        },
        // width: '80%',
        height: '50%',
        borderRadius: 20,
        easing: 'easeOutQuart',
        duration: 500,
        complete: () => {
            currentExpandedArticle = article;
            article.style.overflowY = 'auto';
            // onClickOutside(article, revertArticle)
        }
    })
}

onMounted(() => {
    let complaintBoxes = document.querySelectorAll('.complaint');
    const margin = 100;
    complaintBoxes.forEach((box, index) => {
        let boxRect = box.getBoundingClientRect();
        let translateXDistance = 0;
        let translateYDistance = 0;
        if (index > 0) {
            translateXDistance = (window.innerWidth / 2) + boxRect.width;
            translateYDistance = boxRect.height * 1.5 + margin;
        }
        box.style.transform = `translateX(${index % 2 === 0 ? -translateXDistance : translateXDistance}px) translateY(${index * translateYDistance}px)`;
    })
    let animations = [{
        targets: complaintBoxes,
        translateX: 0,
        translateY: 0,
        delay: (el, index) => index * 2000,
        duration: complaintBoxes.length * 2000,
        scrollTrigger: {
            trigger: document.querySelector('#complaint-events-trigger'),
            lerp: true,
            start: 'top top',
            end: 'bottom bottom',
        }
    }];

    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), animations)
    }, 300)

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
})
</script>

<style scoped>

</style>
