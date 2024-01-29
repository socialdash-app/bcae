<template>
    <div id="main-container" class="flex font-poppins antialiased flex-col w-full">
        <Transition :name="currentAnimationName">
            <!--            <KeepAlive>-->
            <component :key="route.data.component" :is="route.data.component"/>
            <!--            </KeepAlive>-->
        </Transition>
        <div id="cookies"
             class="fixed bottom-4 gap-y-4 right-4 pt-6 pb-4 px-8 border bg-white rounded shadow-2xl flex flex-col"
             v-show="shouldShowCookie">
            <div class="flex gap-x-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="w-5 h-5 lucide lucide-cookie">
                    <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/>
                    <path d="M8.5 8.5v.01"/>
                    <path d="M16 15.5v.01"/>
                    <path d="M12 12v.01"/>
                    <path d="M11 17v.01"/>
                    <path d="M7 14v.01"/>
                </svg>
                <p class="font-bold">Let us record how you interact on our website</p>
            </div>
            <button @click="acceptCookie" class="px-4 self-end py-2 border rounded bg-gray-800 text-white">Okey!!
            </button>
        </div>
    </div>

</template>

<script setup>
import {reactive, onMounted, shallowRef, computed} from "vue";
import route, {headers} from "../api/route.js";

const props = defineProps([]);

const data = reactive({
    height: '400',
    hasAcceptedCookie: window.localStorage.getItem('cookie-accepted') === 'true',
});

const currentAnimationName = computed(() => {
    return route.data.component === 'story' ? 'switch' : 'switch';
})

const paddingBottom = screen.height - window.innerHeight

const height = window.innerHeight;

const shouldShowCookie = computed(() => route.data.hasHomeRendered && !data.hasAcceptedCookie)

const acceptCookie = () => {
    window.localStorage.setItem('cookie-accepted', 'true');
    data.hasAcceptedCookie = true;
}

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
