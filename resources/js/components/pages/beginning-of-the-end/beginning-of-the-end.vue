<template>
    <div
        class="flex flex-col w-full bg-gray-900">
        <intro-beginning-of-the-end/>
        <div
            class="drama-section py-10 main-intro w-screen h-screen px-3 md:px-20 flex items-center justify-center text-[#E8544E]">
            <div class="text-center">
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro">
                        The
                        BEGINNING</h1></div>
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro mt-4">
                        Of</h1>
                </div>
                <div class="overflow-hidden">
                    <h1 class="text-5xl sm:text-7xl lg:text-9xl transform font-bold drama-intro mt-4">
                        The
                        END</h1>
                </div>
            </div>
        </div>
        <first-media-posts/>
        <bcae-summary/>
        <credit-section/>
        <share-section/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import protestSvg from "../../../assets/protest-svg.js";
import voteSvg from "../../../assets/vote-svg.js";
import FirstMediaPosts from "./first-media-posts.vue";
import IntroBeginningOfTheEnd from "./intro-beginning-of-the-end.vue";
import BcaeSummary from "./bcae-summary.vue";
import CreditSection from "./credit-section.vue";
import ShareSection from "./share-section.vue";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {

})
</script>

<style scoped>

</style>
