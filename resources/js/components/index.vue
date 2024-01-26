<template>
    <div id="main-container" class="flex font-poppins antialiased flex-col w-full">
        <Transition :name="currentAnimationName">
            <KeepAlive>
                <component :key="route.data.component" :is="route.data.component"/>
            </KeepAlive>
        </Transition>
    </div>

</template>

<script setup>
import {reactive, onMounted, shallowRef, computed} from "vue";
import route, {headers} from "../api/route.js";

const props = defineProps([]);

const data = reactive({
    height: '400',
});

const currentAnimationName = computed(() => {
    return route.data.component === 'story' ? 'switch' : 'switch';
})

const paddingBottom = screen.height - window.innerHeight

const height = window.innerHeight

onMounted(() => {
})
</script>

<style scoped>
.load-carousel-enter-active,
.load-carousel-leave-active {
    position: absolute;
    transition: all 1s cubic-bezier(0.25, 1, 0.5, 1);
}

.load-carousel-enter-from,
.load-carousel-leave-to {
    opacity: 0;
    transform: translateY(100%);
}

.switch-enter-active {
    position: absolute;
    animation: enter 2s cubic-bezier(0.25, 1, 0.5, 1);
}

.switch-leave-active {
    position: absolute;
    animation: leave 2s cubic-bezier(0.5, 0, 0.75, 0);
}

@keyframes enter {
    0% {
        opacity: 0.0;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes leave {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        opacity: 0;
        transform: scale(1.8);
    }
}
</style>
