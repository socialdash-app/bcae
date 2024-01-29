<template>
    <main :style="{ height: height + 'px' }"
          id="story"
          class="w-screen overscroll-none leading-7 shrink-0  overflow-y-auto overflow-x-hidden flex items-center flex-col">
        <div id="section-indicator-section"
             class="fixed z-[10001] pr-6 md:!pr-20 py-4 md:!py-6 top-0 left-0 w-screen flex justify-end">
            <div
                class="flex items-center justify-center">
                <div @click="route.changeTo('explore')"
                     class="absolute z-[10001] cursor-pointer  w-10 md:!w-14 h-10 md:!h-14 flex items-center justify-center">
                    <svg :id="'header-' + separateWordByDash(header.name)" :style="{ zIndex: index }"
                         class="absolute w-full h-full"
                         v-for="(header, index) in headers" width="100%" height="100%" viewBox="0 0 60 60">
                        <circle r="25" fill="none" stroke-width="8"
                                :stroke="header.secondaryColor" style="stroke-dashoffset:  160; stroke-dasharray: 160;"
                                cx="30" cy="30"></circle>
                    </svg>
                </div>
                <div class="relative w-5 md:!w-8 h-5 md:!h-8 overflow-hidden">
                <span @click="route.changeTo('explore')"
                      class="w-full z-[10001] cursor-pointer  header-icon h-full absolute"
                      :style="{ transform: `translateY(${index * 100}%)` }"
                      v-for="(header, index) in headers" v-html="header.icon"></span>
                </div>
            </div>
        </div>
        <chronicles/>
        <the-election/>
        <prominent-events/>
        <party-reactions/>
        <the-military/>
        <correlated-events/>
        <beginning-of-the-end/>
    </main>
</template>

<script setup>
import {reactive} from "vue";
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

</script>

<style scoped>
main {
    -ms-overflow-style: none; /* Internet Explorer 10+ */
    scrollbar-width: none; /* Firefox */
}

main::-webkit-scrollbar {
    display: none; /* Safari and Chrome */
}
</style>
