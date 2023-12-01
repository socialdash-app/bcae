<template>
    <div class="t" style="margin-top: 10px;">
        <election-incidents/>
        <complaint-events/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import ElectionIncidents from "./election-incidents.vue";
import ComplaintEvents from "./complaint-events.vue";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {

})
</script>

<style scoped>

</style>
