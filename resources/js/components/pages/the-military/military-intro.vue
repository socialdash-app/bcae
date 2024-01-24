<template>
    <div :style="{height: height * 2 + 'px'}" id="military-intro" class="w-full relative flex flex-col items-center">
        <div :style="{height: height + 'px'}"
             class="sticky top-16 md:!top-0 flex w-11/12 md:!w-8/12 flex-col justify-center items-center">
            <h1 style="transform: translateY(200px)"
                class="opacity-0 text-4xl md:text-7xl military-intro-title font-semibold">
                Military’s
                Interference
                in
                the election</h1>
            <p style="transform: translateY(200px)"
               class="w-full mt-12 md:!mt-24 tracking-wider opacity-0 military-intro-content leading-relaxed">
                Lorem ipsum dolor sit amet consectetur. Nulla eget massa etiam odio faucibus hac sed cursus faucibus.
                Volutpat praesent tempus placerat vitae. Proin fringilla non dignissim est mi risus vitae. Duis neque
                eget dui vel. Aliquet adipiscing sapien nulla vel faucibus neque risus arcu. Non et eu non id.
                Adipiscing ultrices facilisi augue neque turpis lacinia dui. Pellentesque nunc netus aliquet enim massa
                neque integer. Facilisi nulla facilisi morbi ipsum. Massa fringilla tellus urna nisi pellentesque.
            </p>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import AnimeScrollTrigger from 'anime-scrolltrigger';
import settings from "../../../api/settings.js";

const props = defineProps([]);

const height = window.innerHeight;

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '.military-intro-title',
            translateY: '0',
            opacity: 1,
            scrollTrigger: {
                trigger: '#military-intro',
                start: 'top top',
                end: 'center center',
                // smooth: true,
                lerp: true,
            }
        }, {
            targets: '.military-intro-content',
            translateY: '0',
            opacity: 1,
            scrollTrigger: {
                trigger: '#military-intro',
                start: '20% top',
                end: 'bottom bottom',
                // smooth: true,
                lerp: true,
            }
        }])
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
