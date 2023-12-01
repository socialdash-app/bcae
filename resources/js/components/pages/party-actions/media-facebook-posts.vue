<template>
    <div id="party-facebook-media-posts"
         class="w-full overflow-visible text-white mt-[20vh] relative flex flex-col items-center">
        <div class="pointer-events-none w-full"
             id="complaint-events-trigger"
             :style="{height: `${articles.length * 600 * 0.5}px`}"></div>
        <div v-for="(article, index) in articles"
             style="will-change: transform;height: 600px;"
             :id="`party-facebook-media-post-${index}`"
             class="party-facebook-media-post overflow-y-auto text-white cursor-pointer absolute border bg-gray-600 rounded p-10 w-6/12"
             :style="{transform: `translateX(${index * 20}px) translateY(${index * 20}px)`, zIndex: -index}">
            <h1 class="font-semibold text-2xl">{{ article.title }}</h1>
            <p class="mt-6">{{ truncate(article.description, 800) }}</p>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import truncate from "../../../api/truncate.js";
import AnimeScrollTrigger from "../../../../../../scrollanime/index.js";

const props = defineProps([]);

const data = reactive({})

const articles = [{
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

onMounted(() => {
    let duration = 2000;
    let articles = document.querySelectorAll('.party-facebook-media-post');
    let articleRect = articles[0].getBoundingClientRect();
    let animations = [{
        targets: articles,
        translateX: [{
            value: 0,
            duration: (el, index) => (index + 1) * duration * 0.5,
        }],
        translateY: [{
            value: 0,
            duration: (el, index) => (index + 1) * duration * 0.5,
        }, {
            value: (el, index) => {
                return index !== articles.length - 1 ? document.querySelector('main').scrollTop - articleRect.top - articleRect.height - 10 : -articleRect.height * 0.7;
            },
        }],
        scrollTrigger: {
            trigger: document.querySelector('#complaint-events-trigger'),
            // debug: true,
            lerp: true,
            start: 'top center',
            end: 'bottom center',
            pin: '#party-facebook-media-posts',
        }
    }];

    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), animations)
    }, 300)
})
</script>

<style scoped>

</style>
