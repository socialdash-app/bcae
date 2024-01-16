<template>
    <div
        class="main-drama-container w-full flex flex-col items-center justify-center overflow-hidden">
        <div class="intro bg-white w-screen relative h-screen flex items-center justify-center">
            <div class="overflow-hidden relative w-10/12 sm:w-4/12 h-1/2">
                <div v-html="protestSvg" class="absolute top-0 left-0 transform opacity-0 -translate-x-30 w-full">
                </div>
                <div v-html="voteSvg" class="absolute top-0 left-0 transform opacity-1  w-full">
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import protestSvg from "../../../assets/protest-svg.js";
import voteSvg from "../../../assets/vote-svg.js";
import AnimeScrollTrigger from "../../../../../../scrollanime/index.js";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
})
</script>

<style scoped>

</style>
