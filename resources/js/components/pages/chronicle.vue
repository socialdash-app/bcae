<template>
    <div id="chronicle-trigger" class="w-full bg-[#fff562] flex relative flex-col items-center">
        <div class="w-full flex justify-between bg-[#fff562] z-[100] h-24 items-center px-20 sticky top-0 left-0">
            <h1 class="text-xl font-semibold">Chronicle</h1>
            <div class="relative flex items-center justify-center">
                <svg width="60" height="60" viewBox="0 0 60 60">
                    <circle id="chronicle-progress-indicator" stroke-dashoffset="160" stroke-dasharray="160" r="25"
                            fill="none" stroke-width="8"
                            stroke="#FF7F00" cx="30"
                            cy="30"></circle>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide absolute w-7 h-7 lucide-history">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M12 7v5l4 2"/>
                </svg>
            </div>
        </div>
        <div id="chronicle" class="w-9/12 sticky top-24 left-0 h-screen flex items-center justify-between">
            <div class="w-5/12 h-4/6 relative overflow-hidden">
                <div class="chronicle-illustration w-full absolute h-5/6"
                     :style="{transform: `translateX(${index * 120}%)`}"
                     :class="description.bg" v-for="(description,index) in descriptions">

                </div>
            </div>
            <div class="w-5/12 relative h-4/6 flex flex-col overflow-hidden">
                <div :style="{transform: `translateY(${index * 120}%)`}"
                     class="flex absolute chronicle-content h-full rounded border shrink-0 gap-y-4 p-6 bg-gray-100 flex-col overflow-hidden w-full"
                     v-for="(description,index) in descriptions">
                    <h1 class="w-full font-semibold text-4xl">
                        {{ description.title }}</h1>
                    <p class="w-full text-gray-700">{{ description.description }}</p>
                </div>
            </div>
        </div>
        <div class="w-full h-[400vh]">

        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from 'anime-scrolltrigger'
import anime from "animejs";

const props = defineProps([]);

const data = [{}]

const descriptions = [{
    title: '1958',
    bg: 'bg-red-300',
    description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
}, {
    title: '1962',
    bg: 'bg-blue-300',
    description: 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. '
}, {
    title: '1988',
    bg: 'bg-gray-300',
    description: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.'
}, {
    title: '1990',
    bg: 'bg-orange-300',
    description: '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"'
}, {
    title: '2021',
    bg: 'bg-orange-300',
    description: '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"'
}];

const translateMultiplier = 120;

const init = () => {
    let chronicleIllustrations = document.querySelectorAll('.chronicle-illustration');
    let chronicleContents = document.querySelectorAll('.chronicle-content');
    let animations = [];
    let stopPercentages = [];
    let duration = 1500;
    let divider = 100 / descriptions.length;
    for (let i = 0; i <= descriptions.length - 1; i++) {
        animations.push([{
            targets: chronicleIllustrations,
            duration: duration,
            easing: 'easeOutQuart',
            translateX: (el, index) => {
                return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
            }
        }, {
            targets: chronicleContents,
            duration: duration,
            easing: 'easeOutQuart',
            translateY: (el, index) => {
                return i === descriptions.length - 1 && index === i ? 0 : Math.max(-translateMultiplier, index * translateMultiplier - translateMultiplier * i) + '%';
            }
        }])
        stopPercentages.push(i * divider);
        // let animation = {
        //     illustrations: {
        //         translateX: [],
        //     },
        //     contents: {
        //         translateY: [],
        //     }
        // };
        // for (let j = 0; j <= descriptions.length - 1; j++) {
        //     animation.illustrations.translateX.push(i === descriptions.length - 1 && j === i ? 0 : Math.max(-translateMultiplier, j * translateMultiplier - translateMultiplier * i) + '%')
        //     animation.contents.translateY.push(i === descriptions.length - 1 && j === i ? 0 : Math.max(-translateMultiplier, j * translateMultiplier - translateMultiplier * i) + '%')
        // }
        // animations.push(animation)
    }

    let timeout;
    let currentIndex = 0;
    new AnimeScrollTrigger(document.querySelector('main'), [{
        scrollTrigger: {
            trigger: '#chronicle-trigger',
            start: 'top top',
            end: 'bottom bottom',
            // debug: true,
            lerp: true,
            onUpdate: (_, progress) => {
                if (timeout) clearTimeout(timeout);
                timeout = setTimeout(() => {
                    let percentage = Math.round(progress * 100);
                    let ps = stopPercentages.filter((p) => percentage > p);
                    if (ps.length > 0) {
                        let index = ps.length - 1;
                        if (index !== currentIndex) {
                            currentIndex = index;
                            let animes = animations[currentIndex];
                            animes.forEach((animation) => {
                                anime(animation)
                            })
                        }
                    }
                }, 10)
            }
        }
    }, {
        targets: '#chronicle-progress-indicator',
        strokeDashoffset: 0,
        scrollTrigger: {
            trigger: '#chronicle-trigger',
            start: 'top top',
            end: 'bottom bottom',
            lerp: true,
        }
    }])
}

onMounted(() => {
    setTimeout(() => {
        init()
    }, 500)
})
</script>

<style scoped>

</style>
