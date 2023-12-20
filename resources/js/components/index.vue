<template>
    <main
        class="w-screen overscroll-none h-screen  font-poppins overflow-y-auto overflow-x-hidden flex items-center flex-col">
        <navigation/>
        <home/>
        <chronicle/>
        <!--    <the-election/>-->
        <!--    <prominent-events/>-->
        <!--        <party-actions/>-->
        <!--        <the-military/>-->
        <!--    <correlated-actions/>-->
        <!--    <beginning-of-the-end/>-->
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
import Navigation from "./pages/navigation.vue";

const props = defineProps([]);

const component = shallowRef('beginning-of-the-end');

const data = reactive({
    height: '400',
});

const paddingBottom = screen.height - window.innerHeight

const height = window.innerHeight

onMounted(() => {
    // data.height = window.innerHeight + '';
    // alert(window.visualViewport.height + window.innerHeight + ' ' + +' ' + window.screen.availHeight + ' ' + window.screen.height + ' ' + document.getElementById('navigation-container').getBoundingClientRect().height)
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
