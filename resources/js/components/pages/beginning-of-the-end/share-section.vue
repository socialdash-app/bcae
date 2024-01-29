<template>
    <div class="w-full flex text-white flex-col items-center">
        <div class="py-16 border-b flex flex-col gap-y-12 items-center w-10/12">
            <h3 class="font-semibold text-xl">Share BCAE on: </h3>
            <div class="w-full flex items-center text-[#E8544E] justify-center gap-x-12">
                <div class="flex flex-col items-center gap-y-2 text-sm">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fpublic.socialdash.app%2Fbcae"
                       target="_blank" v-html="facebook"
                       class="w-10 h-10 border border-[#E8544E] p-2 rounded-full"></a>
                    <span>Facebook</span>
                </div>
                <div class="flex flex-col items-center gap-y-2 text-sm">
                    <a href="https://twitter.com/intent/tweet/?url=https%3A%2F%2Fpublic.socialdash.app%2Fbcae"
                       v-html="twitter" target="_blank"
                       class="w-10 h-10 border border-[#E8544E] p-2 rounded-full"></a>
                    <span>X</span>
                </div>
                <div class="flex flex-col items-center gap-y-2 text-sm">
                    <a href="mailto:?subject=sharing%20awesome%20datastory%20https%3A%2F%2Fpublic.socialdash.app%2Fbcae"
                       v-html="email" target="_blank"
                       class="w-10 h-10 border border-[#E8544E] p-2 rounded-full"></a>
                    <span>Mail</span>
                </div>
            </div>
        </div>
        <div class="py-16 border-b flex flex-col gap-y-6 items-center w-11/12 md:!w-10/12">
            <h3 class="font-semibold text-xl">Want to see more stories like this?</h3>
            <p class="text-gray-300">Subscribe our Newsletter!</p>
            <div class="flex items-center w-full md:!w-auto gap-x-4 md:!flex-row flex-col">
                <input type="email" placeholder="Enter your email address"
                       class="bg-gray-700 rounded w-full md:w-auto focus:outline-none border border-transparent focus:border-[#E8544E] px-6 py-4"/>
                <button class="mt-4 w-full md:w-auto md:mt-0 bg-[#E8544E] px-6 py-4 rounded">Subscribe</button>
            </div>
        </div>
        <!--        <div class="py-16 border-b flex flex-col gap-y-6 items-center w-11/12 md:!w-10/12">-->
        <!--            <h3 class="font-semibold text-xl">Have ideas for new stories?</h3>-->
        <!--            <p class="text-gray-300">Reach out to us and let us touch your thoughts!</p>-->
        <!--            <div class="flex items-center w-full md:!w-auto gap-x-4 md:!flex-row flex-col">-->
        <!--                <input type="email" placeholder="Enter your email address"-->
        <!--                       class="bg-gray-700 rounded w-full md:w-auto focus:outline-none border border-transparent focus:border-[#E8544E] px-6 py-4"/>-->
        <!--                <button class="mt-4 w-full md:!w-auto md:mt-0 bg-[#E8544E] px-6 py-4 rounded">Contact</button>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="pt-16 flex flex-col gap-y-6 items-center w-11/12 md:!w-10/12">
            <h3 class="font-semibold text-xl">Fuel Our Passion – Support Us on Patreon!</h3>
            <p class="text-gray-300">Help us keep the creative fire burning!</p>
            <div class="flex items-center w-full md:!w-auto gap-x-4 md:!flex-row flex-col">
                <a href="https://www.patreon.com/SocialDash" target="_blank"
                   class="mt-4 text-center w-full md:!w-auto md:mt-0 bg-[#E8544E] px-6 py-4 rounded">Support Us On
                    Patreon
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import {email, facebook, instagram, twitter} from "../../../assets/icons.js";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {

})
</script>

<style scoped>

</style>
