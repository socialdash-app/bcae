<template>
    <main class="w-screen font-poppins overflow-y-scroll overflow-x-hidden h-screen flex items-center flex-col">
        <!--        <component :is="component"></component>-->
        <home/>
        <chronicle/>
        <the-election/>
        <the-military/>
        <prominent-events/>
        <party-actions/>
        <correlated-actions/>
        <beginning-of-the-end/>
    </main>
</template>

<script setup>
import {reactive, onMounted, shallowRef} from "vue";
import TheElection from "./pages/the-election.vue";
import Chronicle from "./pages/chronicle.vue";
import ProminentEvents from "./pages/prominent-events/prominent-events.vue";
import Home from "./pages/home.vue";
import TheMilitary from "./pages/the-military/the-military.vue";
import CorrelatedActions from "./pages/correlated-actions/correlated-actions.vue";
import PartyActions from "./pages/party-actions/party-actions.vue";
import BeginningOfTheEnd from "./pages/beginning-of-the-end/beginning-of-the-end.vue";

const props = defineProps([]);

const component = shallowRef('beginning-of-the-end');

const data = reactive({});


onMounted(() => {
    // setTimeout(() => {
    //     component.value = 'accusation';
    //     setTimeout(() => {
    //         component.value = 'navigation';
    //     }, 4000)
    // }, 4000)
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
