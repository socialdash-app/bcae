<template>
    <div
        class="drama-section py-10 bg-[#FFEB37] main-intro w-screen py-10 px-3 md:px-20 flex items-center justify-center">
        <button @click="showPopup"
                class="text-center bg-[#101728] text-white text-lg font-semibold px-14 py-5">
            Credits
        </button>
        <pop-over @click-outside="data.showCreditPopup = false" v-show="data.showCreditPopup">
            <div
                class="py-10 px-6 w-[90vw] md:w-auto md:!py-16 md:!px-16 gap-y-6 text-gray-700 rounded-lg flex flex-col bg-[#FFEB37]">
                <h1 class="uppercase font-semibold text-2xl md:!text-3xl">Before The Coup, After The Election</h1>
                <a class="text-xl md:!text-2xl font-medium underline"
                   target="_blank"
                   href="https://www.researchgate.net/profile/Alexander-Beatson">By Alexander Beatson</a>
                <p>With the support of,</p>
                <ul class="list-disc pl-4">
                    <li><a href="https://twitter.com/thomasbrillion" class="underline" target="_blank">Thomas
                        Brillion</a></li>
                    <li>Avaline Nephilim</li>
                    <li>And, others</li>
                </ul>
                <p class="italic">Inspired by the stories from <a href="https://pudding.cool/" target="_blank"
                                                                  class="underline">The
                    Pudding</a> and
                    other creators</p>
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
