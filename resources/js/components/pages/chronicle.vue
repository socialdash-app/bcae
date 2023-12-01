<template>
    <div id="chronicle-trigger" class="w-9/12">
        <div id="chronicle" class="w-full h-screen flex items-center justify-between">
            <div class="w-5/12 h-4/6 relative overflow-hidden">
                <div class="box w-full absolute h-5/6"
                     :style="{transform: `translateX(${index * 120}%)`}"
                     :class="description.bg" v-for="(description,index) in descriptions">

                </div>
            </div>
            <div class="w-5/12 h-4/6 flex flex-col">
                <div class="flex overflow-hidden h-20 relative w-full">
                    <h1 :style="{zIndex: index, transform: `translateX(${index * 120}%)`}"
                        v-for="(description,index) in descriptions"
                        class="title w-full absolute transform shrink-0 font-semibold text-4xl">
                        {{ description.title }}</h1>
                </div>
                <div class="flex relative overflow-hidden h-5/6 w-full">
                    <p :style="{transform: `translateX(${index * 120}%)`}"
                       v-for="(description,index) in descriptions"
                       class="description absolute transform w-full text-gray-700">{{
                            description.description
                        }}</p>
                </div>
            </div>
        </div>
        <div class="w-full h-[300vh]">

        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from 'anime-scrolltrigger'

const props = defineProps([]);

const data = [{}]

const descriptions = [{
    title: 'We are the one',
    bg: 'bg-red-300',
    description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
}, {
    title: 'We are the two',
    bg: 'bg-blue-300',
    description: 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. '
},
    {
        title: 'We are the three',
        bg: 'bg-gray-300',
        description: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.'
    }, {
        title: 'We are the four',
        bg: 'bg-orange-300',
        description: '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"'
    }];

onMounted(() => {
    new AnimeScrollTrigger(document.querySelector('main'), [{
        targets: '.box',
        translateX: (el, index) => {
            return -(descriptions.length - 1 - index) * 100 + '%';
        },
        scrollTrigger: {
            trigger: '#chronicle-trigger',
            start: 'top center',
            end: 'bottom bottom',
            debug: true,
            pin: '#chronicle',
            lerp: true,
        }
    }, {
        targets: '.title',
        translateX: (el, index) => {
            return -(descriptions.length - 1 - index) * 100 + '%';
        },
        scrollTrigger: {
            trigger: '#chronicle-trigger',
            start: 'top center',
            end: 'bottom bottom',
            // debug: true,
            lerp: true,
        }
    }, {
        targets: '.description',
        translateX: (el, index) => {
            return -(descriptions.length - 1 - index) * 100 + '%';
        },
        scrollTrigger: {
            trigger: '#chronicle-trigger',
            start: 'top center',
            end: 'bottom bottom',
            // debug: true,
            lerp: true,
        }
    }])
})
</script>

<style scoped>

</style>
