<template>
    <main class="w-screen h-screen flex items-center">
        <Transition name="fade" mode="out-in">
            <keep-alive>
                <component :is="component"></component>
            </keep-alive>
        </Transition>
    </main>
</template>

<script setup>
import {reactive, onMounted, shallowRef} from "vue";

const props = defineProps([]);

const component = shallowRef('navigation');

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
