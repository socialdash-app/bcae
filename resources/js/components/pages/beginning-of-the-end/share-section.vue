<template>
    <div class="w-full flex text-white flex-col items-center">
        <div class="py-16 border-b flex flex-col gap-y-12 items-center w-10/12">
            <h3 class="font-semibold text-xl">Share BCAE on: </h3>
            <div class="w-full flex items-center text-[#E8544E] justify-center gap-x-12">
                <div class="flex flex-col items-center gap-y-2 text-sm">
                    <a href="" v-html="facebook" class="w-10 h-10 border border-[#E8544E] p-2 rounded-full"></a>
                    <span>Facebook</span>
                </div>
                <div class="flex flex-col items-center gap-y-2 text-sm">
                    <a href="" v-html="twitter" class="w-10 h-10 border border-[#E8544E] p-2 rounded-full"></a>
                    <span>X</span>
                </div>
                <div class="flex flex-col items-center gap-y-2 text-sm">
                    <a href="" v-html="instagram" class="w-10 h-10 border border-[#E8544E] p-2 rounded-full"></a>
                    <span>Instagram</span>
                </div>
            </div>
        </div>
        <div class="py-16 border-b flex flex-col gap-y-6 items-center w-10/12">
            <h3 class="font-semibold text-xl">Want to see more stories like this?</h3>
            <p class="text-gray-300">Subscribe our Newsletter!</p>
            <div class="flex items-center gap-x-4 md:!flex-row flex-col">
                <input type="email" placeholder="Enter your email address"
                       class="bg-gray-700 rounded focus:outline-none border border-transparent focus:border-[#E8544E] px-6 py-4"/>
                <button class="mt-4 w-full md:w-auto md:mt-0 bg-[#E8544E] px-6 py-4 rounded">Subscribe</button>
            </div>
        </div>
        <div class="py-16 flex flex-col gap-y-6 items-center w-10/12">
            <h3 class="font-semibold text-xl">Have ideas for new stories?</h3>
            <p class="text-gray-300">Reach out to us and let us touch your thoughts!</p>
            <div class="flex items-center gap-x-4 md:!flex-row flex-col">
                <input type="email" placeholder="Enter your email address"
                       class="bg-gray-700 rounded focus:outline-none border border-transparent focus:border-[#E8544E] px-6 py-4"/>
                <button class="mt-4 w-full md:w-auto md:mt-0 bg-[#E8544E] px-6 py-4 rounded">Contact</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import {facebook, instagram, twitter} from "../../../assets/icons.js";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {

})
</script>

<style scoped>

</style>
