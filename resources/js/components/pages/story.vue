<template>
    <main :style="{ height: height + 'px' }"
          class="w-screen overscroll-none leading-7 shrink-0  overflow-y-auto overflow-x-hidden flex items-center flex-col">
        <div @click="route.changeTo('home')"
             class="fixed right-6 md:right-20 cursor-pointer top-5 md:top-8 flex z-[10000] items-center justify-center">
            <div class="absolute w-10 md:!w-14 h-10 md:!h-14 flex items-center justify-center">
                <svg :id="'header-' + separateWordByDash(header.name)" :style="{ zIndex: index }"
                     class="absolute w-full h-full"
                     v-for="(header, index) in headers" width="100%" height="100%" viewBox="0 0 60 60">
                    <circle r="25" fill="none" stroke-width="8"
                            :stroke="header.secondaryColor" style="stroke-dashoffset:  160; stroke-dasharray: 160;"
                            cx="30" cy="30"></circle>
                </svg>
            </div>
            <div class="relative w-5 md:!w-7 h-5 md:!h-7 overflow-hidden">
                <span class="w-full header-icon h-full absolute"
                      :style="{ transform: `translateY(${index * 100}%)` }"
                      v-for="(header, index) in headers" v-html="header.icon"></span>
            </div>
        </div>
        <chronicles/>
        <the-election/>
        <prominent-events/>
        <party-reactions/>
        <the-military/>
        <correlated-events/>
        <beginning-of-the-end/>
        <!--        [Home → Chronicles → The Election → Prominent events → Party reactions → The Military → Correlated events →-->
        <!--        Beginning of The End] Comment end-->
    </main>
</template>

<script setup>
import {reactive, onMounted, onDeactivated, onActivated} from "vue";
import Chronicles from "./chronicles.vue";
import TheElection from "./the-election.vue";
import ProminentEvents from "./prominent-events/prominent-events.vue";
import PartyReactions from "./party-reactions/party-reactions.vue";
import TheMilitary from "./the-military/the-military.vue";
import CorrelatedEvents from "./correlated-events/correlated-events.vue";
import BeginningOfTheEnd from "./beginning-of-the-end/beginning-of-the-end.vue";

import route, {headers} from "../../api/route.js";
import {separateWordByDash} from "../../api/helpers.js";


const props = defineProps([]);

const data = reactive({})

const height = window.innerHeight;

let currentScrollOffset = 0;

onMounted(() => {

})

onDeactivated(() => {
    currentScrollOffset = document.querySelector('main').scrollTop;
})

onActivated(() => {
    document.querySelector('main').scrollTop = currentScrollOffset;
})
</script>

<style scoped></style>
