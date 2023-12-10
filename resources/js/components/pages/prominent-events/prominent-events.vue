<template>
    <div id="prominent-events" class="relative bg-[#F1FFF0]" style="margin-top: 10px;">
        <div class="w-full flex justify-between bg-[#F1FFF0] z-[100] h-24 items-center px-20 sticky top-0 left-0">
            <h1 class="text-xl font-semibold">Prominent Events</h1>
            <div class="relative flex items-center justify-center">
                <svg width="60" height="60" viewBox="0 0 60 60">
                    <circle id="prominent-events-progress-indicator" stroke-dashoffset="160" stroke-dasharray="160"
                            r="25"
                            fill="none" stroke-width="8"
                            stroke="#44BB33" cx="30"
                            cy="30"></circle>
                </svg>
                <svg class="absolute w-7 h-7" width="42" height="42" viewBox="0 0 42 42" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.25 24.5V21H29.75V24.5H12.25ZM12.25 31.5V28H24.5V31.5H12.25ZM8.75 38.5C7.7875 38.5 6.96325 38.157 6.27725 37.471C5.59125 36.785 5.24884 35.9613 5.25 35L5.25 10.5C5.25 9.5375 5.593 8.71325 6.279 8.02725C6.965 7.34125 7.78867 6.99883 8.75 7H10.5V3.5L14 3.5V7H28V3.5L31.5 3.5V7H33.25C34.2125 7 35.0368 7.343 35.7228 8.029C36.4088 8.715 36.7512 9.53867 36.75 10.5V35C36.75 35.9625 36.407 36.7868 35.721 37.4728C35.035 38.1587 34.2113 38.5012 33.25 38.5H8.75ZM8.75 35H33.25V17.5H8.75V35Z"
                        fill="#041D02"/>
                </svg>
            </div>
        </div>
        <election-incidents/>
        <complaint-events/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import ElectionIncidents from "./election-incidents.vue";
import ComplaintEvents from "./complaint-events.vue";
import AnimeScrollTrigger from "anime-scrolltrigger";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#prominent-events-progress-indicator',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#prominent-events',
                start: 'top top',
                end: 'bottom bottom',
                lerp: true,
            }
        }])
    }, 300)
})
</script>

<style scoped>

</style>
