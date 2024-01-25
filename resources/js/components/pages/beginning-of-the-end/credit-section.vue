<template>
    <div
        class="drama-section py-10 main-intro w-screen h-64 px-3 md:px-20 flex items-center justify-center">
        <button @click="showPopup"
                class="text-center bg-[#FFEB37] text-lg font-semibold px-12 py-3 rounded">
            Credits
        </button>
        <pop-over @click-outside="data.showCreditPopup = false" v-show="data.showCreditPopup">
            <div
                class="py-10 px-6 w-[90vw] md:w-auto md:!py-16 md:!px-16 gap-y-6 text-gray-700 rounded-lg flex flex-col bg-[#FFEB37]">
                <h1 class="uppercase font-semibold text-2xl md:!text-3xl">Before The Coup, After The Election</h1>
                <p class="text-xl md:!text-2xl font-medium">By Alexander Beatson</p>
                <p>With the support of,</p>
                <ul class="list-disc pl-4">
                    <li>Thomas Brillion</li>
                    <li>Avaline Nephilim</li>
                    <li>and others</li>
                </ul>
                <p>And, inspired by the stories from The Pudding and other creators</p>
            </div>
        </pop-over>
    </div>
</template>

<script setup>
import {reactive} from "vue";
import {PopOver} from "vue-common-components";

const props = defineProps([]);

const data = reactive({
    showCreditPopup: false,
})

const showPopup = () => {
    setTimeout(() => {
        data.showCreditPopup = true
    }, 100)
}
</script>

<style scoped>

</style>
