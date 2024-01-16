<template>
    <div id="party-actions"
         class="w-full flex-col flex items-center py-2 bg-[#EBFFE0]">
        <party-accusations-facebook-posts/>
        <media-facebook-posts/>
        <youtube-video/>
        <uec-accusation/>
        <party-signatures/>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import MediaFacebookPosts from "./media-facebook-posts.vue";
import YoutubeVideo from "./youtube-video.vue";
import UecAccusation from "./uec-accusation.vue";
import PartyAccusationsFacebookPosts from "./party-accusations-facebook-posts.vue";
import AnimeScrollTrigger from "anime-scrolltrigger";
import route from "../../../api/route.js";
import PartySignatures from "./party-signatures.vue";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#header-party-actions circle',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#party-actions',
                start: 'top top',
                end: 'bottom top',
                lerp: true,
                onEnter: () => {
                    route.changeSectionHeader(3)
                    console.log('enter prominent')
                },
                onEnterBack: () => {
                    route.changeSectionHeader(3)
                    console.log('enter back prominent');
                },
            }
        }])
    }, 2000);
})
</script>

<style scoped>

</style>
