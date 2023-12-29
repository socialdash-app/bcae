<template>
    <div id="parent" class="flex font-poppins flex-col w-full">
        <!--        <navigation/>-->
        <!--        <Transition name="fade" mode="out-in">-->
        <KeepAlive>
            <component :is="route.data.component"/>
        </KeepAlive>
        <!--        </Transition>-->
    </div>

</template>

<script setup>
import {reactive, onMounted, shallowRef} from "vue";
import route from "../api/route.js";

const props = defineProps([]);

const data = reactive({
    height: '400',
});

const paddingBottom = screen.height - window.innerHeight

const height = window.innerHeight

onMounted(() => {
    // data.height = window.innerHeight + '';
    // alert(window.visualViewport.height + window.innerHeight + ' ' + +' ' + window.screen.availHeight + ' ' + window.screen.height + ' ' + document.getElementById('navigation-container').getBoundingClientRect().height)
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.8s cubic-bezier(0.65, 0, 0.35, 1);
}

.fade-enter-from {
    transform: scale(0.8) translateY(-120%);
}

.fade-leave-to {
    transform: scale(0.8) translateY(-120%);
}
</style>
