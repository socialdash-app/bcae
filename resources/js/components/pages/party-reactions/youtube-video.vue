<template>
    <div class="w-11/12 lg:!w-9/12 2xl:!w-8/12 3xl:!w-7/12 md:h-screen flex flex-col"
         id="party-action-youtube-video">
        <div class="w-full gap-x-6 mt-8 flex">
            <div
                class="hidden lg:!flex w-4/12 rounded-lg h-full p-6 tracking-wider leading-relaxed text-gray-700 bg-[#F4A8FF]">
                At the press conference on November 11, 2020, USDP demanded to hold a joint election with UEC and the
                military, expressing that they would entirely win if it were a free and fair election. They accused the
                teachers on duty at the polling stations of not being neutral, the overage voting process of taking
                longer than usual, advanced votes of not being stored securely and possessing unsealed advanced votes,
                and voter turnout of exceeding the voter list.
            </div>
            <div class="w-full h-full lg:!w-8/12 rounded-lg flex flex-col gap-y-6">
                <iframe class="aspect-video rounded-lg w-full h-full"
                        src="https://www.youtube.com/embed/29jxZ_LF7Wg" allow="fullscreen"></iframe>
                <div @click="data.showDetail = !data.showDetail"
                     class="py-4 px-4 md:!py-6 md:!px-6 md:pointer-events-none lg:!flex-row flex-col flex items-center lg:h-32 bg-[#F4A8FF] rounded-lg w-full">
                    <h1 class="md:text-lg font-semibold w-full">Demand to hold (anew) joint election with UEC and the
                        military</h1>
                    <div class="flex w-full mt-4 lg:mt-0 gap-x-2">
                        <img class="h-full" src="assets/DVB_logo.png" alt="DVB_logo"/>
                        <div class="flex flex-col">
                            <h2 class="font-semibold text-gray-800 md:text-xl">DVB</h2>
                            <time class="text-sm text-gray-700"> 3 minutes 28 seconds long</time>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         v-show="!data.showDetail"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lg:hidden mt-2 lucide-chevron-down">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         v-show="data.showDetail"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-chevron-up lg:hidden">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>
                    <div v-show="data.showDetail" class="w-full">
                        At the press conference on November 11, 2020, USDP demanded to hold a joint election with UEC
                        and the
                        military, expressing that they would entirely win if it were a free and fair election. They
                        accused the
                        teachers on duty at the polling stations of not being neutral, the overage voting process of
                        taking
                        longer than usual, advanced votes of not being stored securely and possessing unsealed advanced
                        votes,
                        and voter turnout of exceeding the voter list.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";

const props = defineProps([]);

const data = reactive({
    showDetail: false,
})

onMounted(() => {

})
</script>

<style scoped>

</style>
