<template>
    <div id="parent" class="flex font-poppins flex-col w-full">
        <!--        <navigation/>-->
        <Transition name="fade" mode="out-in">
            <KeepAlive>
                <component :is="route.data.component"/>
            </KeepAlive>
        </Transition>
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
    transition: all 0.8s cubic-bezier(0.33, 1, 0.68, 1);
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
