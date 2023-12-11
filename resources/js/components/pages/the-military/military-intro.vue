<template>
    <div style="height: 200vh;" id="military-intro" class="w-10/12 relative flex flex-col items-center">
        <div id="military-intro-pinner" class="relative h-screen flex w-8/12 flex-col justify-center items-center">
            <h1 style="transform: translateY(50vh)" class="text-7xl military-intro-title font-semibold">
                Military’s
                Interference
                in
                the election</h1>
            <p style="transform: translateY(50vh)"
               class="w-full mt-24 tracking-wider military-intro-content leading-relaxed">
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

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '.military-intro-title',
            translateY: '0',
            scrollTrigger: {
                trigger: '#military-intro',
                start: 'top top',
                end: 'center center',
                lerp: true,
            }
        }, {
            targets: '.military-intro-content',
            translateY: '0',
            scrollTrigger: {
                trigger: '#military-intro',
                start: 'center center',
                end: '90% bottom',
                lerp: true,
            }
        }, {
            scrollTrigger: {
                trigger: '#military-intro',
                start: 'top top',
                end: 'bottom bottom',
                pin: '#military-intro-pinner',
            }
        }])
    }, 500)
})
</script>

<style scoped>

</style>
