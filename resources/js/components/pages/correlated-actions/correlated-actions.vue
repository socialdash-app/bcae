<template>
    <div id="correlated-actions"
         class="w-full flex-col flex relative items-center bg-[#FDF4E9] py-2">
        <div class="w-full flex justify-between bg-[#FDF4E9] z-[100] h-24 items-center px-20 sticky top-0 left-0">
            <h1 class="text-xl font-semibold">Party Actions</h1>
            <div class="relative flex items-center justify-center">
                <svg width="60" height="60" viewBox="0 0 60 60">
                    <circle id="correlated-actions-progress-indicator" stroke-dashoffset="160" stroke-dasharray="160"
                            r="25"
                            fill="none" stroke-width="8"
                            stroke="#A65628" cx="30"
                            cy="30"></circle>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide absolute w-7 h-7 lucide-route">
                    <circle cx="6" cy="19" r="3"/>
                    <path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"/>
                    <circle cx="18" cy="5" r="3"/>
                </svg>
            </div>
        </div>
        <protests/>
        <disinformation/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import Protests from "./protests.vue";
import Disinformation from "./disinformation.vue";
import AnimeScrollTrigger from "anime-scrolltrigger";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#correlated-actions-progress-indicator',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#correlated-actions',
                start: 'top top',
                end: 'bottom bottom',
                lerp: true,
            }
        }])
    }, 500);
})
</script>

<style scoped>

</style>
