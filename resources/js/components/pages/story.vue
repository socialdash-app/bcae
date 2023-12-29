<template>
    <main
        class="w-screen h-screen shrink-0  overflow-y-auto overflow-x-hidden flex items-center flex-col">
        <chronicle/>
        <the-election/>
        <prominent-events/>
        <party-actions/>
        <the-military/>
        <correlated-actions/>
        <beginning-of-the-end/>
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

const props = defineProps([]);

const data = reactive({})

const headers = [{
    name: 'chronicle',
    primaryColor: '#fff562',
    secondaryColor: '#FF7F00',
    icon: '',
}]

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
