<template>
    <main
        :style="{height: height + 'px'}"
        class="w-screen overscroll-none leading-7 shrink-0  overflow-y-auto overflow-x-hidden flex items-center flex-col">
        <div class="fixed right-20 top-6 flex z-20 items-center justify-center">
            <div class="absolute w-10 h-10 flex items-center justify-center">
                <svg :id="'header-'+separateWordByDash(header.name)" :style="{zIndex: index}" class="absolute"
                     v-for="(header,index) in headers" width="60"
                     height="60" viewBox="0 0 60 60">
                    <circle stroke-dashoffset="160"
                            stroke-dasharray="160"
                            r="25"
                            fill="none" stroke-width="8"
                            :stroke="header.secondaryColor" cx="30"
                            cy="30"></circle>
                </svg>
            </div>
            <div class="relative w-7 h-7 overflow-hidden">
                    <span class="w-full header-icon h-full absolute" :style="{transform: `translateY(${index * 100}%)`}"
                          v-for="(header,index) in headers" v-html="header.icon"></span>
            </div>
        </div>
        <chronicle/>
        <the-election/>
        <prominent-events/>
        <!--        <party-actions/>-->
        <!--        <the-military/>-->
        <!--        <correlated-actions/>-->
        <!--        <beginning-of-the-end/>-->
        <!--        [Home → Chronicles → The Election → Prominent events → Party reactions → The Military → Correlated events → Beginning of The End] Comment end-->
    </main>
</template>

<script setup>
import {reactive, onMounted, onDeactivated, onActivated} from "vue";
import Chronicle from "./chronicle.vue";
import TheElection from "./the-election.vue";
import ProminentEvents from "./prominent-events/prominent-events.vue";
import PartyActions from "./party-actions/party-actions.vue";
import TheMilitary from "./the-military/the-military.vue";
import CorrelatedActions from "./correlated-actions/correlated-actions.vue";
import BeginningOfTheEnd from "./beginning-of-the-end/beginning-of-the-end.vue";

import route, {headers} from "../../api/route.js";
import {separateWordByDash} from "../../api/helpers.js";


const props = defineProps([]);

const data = reactive({})

const height = window.innerHeight;

let currentScrollOffset = 0;

onDeactivated(() => {
    currentScrollOffset = document.querySelector('main').scrollTop;
})

onActivated(() => {
    document.querySelector('main').scrollTop = currentScrollOffset;
})
</script>

<style scoped>

</style>
