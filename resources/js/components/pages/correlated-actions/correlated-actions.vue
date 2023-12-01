<template>
    <protests/>
    <disinformation/>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import Protests from "./protests.vue";
import Disinformation from "./disinformation.vue";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {

})
</script>

<style scoped>

</style>
