<template>
    <div id="party-reactions"
         :style="{background: headers[3].primaryColor}"
         class="w-full flex-col flex items-center py-2 relative">
        <div class="sticky pl-4 md:pl-14 top-4 md:!top-6 w-11/12 z-[100]">
            <h1 class="text-xl md:text-3xl font-bold">Party Reactions</h1>
        </div>
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
import route, {headers} from "../../../api/route.js";
import PartySignatures from "./party-signatures.vue";

const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: '#header-party-reactions circle',
            strokeDashoffset: 0,
            scrollTrigger: {
                trigger: '#party-reactions',
                start: 'top top',
                end: 'bottom top',
                lerp: true,
                onEnter: () => {
                    route.changeSectionHeader(3)
                },
                onEnterBack: () => {
                    route.changeSectionHeader(3)
                },
            }
        }])
    }, 2000);
})
</script>

<style scoped>

</style>
