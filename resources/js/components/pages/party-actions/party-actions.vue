<template>
    <party-accusations-facebook-posts/>
    <media-facebook-posts/>
    <youtube-video/>
    <uec-accusation/>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import MediaFacebookPosts from "./media-facebook-posts.vue";
import YoutubeVideo from "./youtube-video.vue";
import UecAccusation from "./uec-accusation.vue";
import PartyAccusationsFacebookPosts from "./party-accusations-facebook-posts.vue";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {

})
</script>

<style scoped>

</style>
