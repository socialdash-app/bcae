<template>
    <div id="party-reactions"
         :style="{background: headers[3].primaryColor}"
         class="w-full flex-col flex pt-4 md:!pt-6 items-center relative">
        <div class="sticky ml-[4%] sm:!ml-[8%] self-start top-3 md:!top-6 z-[10002]">
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
import settings from "../../../api/settings.js";
import anime from "animejs";

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
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[3].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
                onEnterBack: () => {
                    route.changeSectionHeader(3)
                    anime({
                        targets: '#section-indicator-section',
                        background: headers[3].primaryColor,
                        duration: 300,
                        easing: 'linear'
                    })
                },
            }
        }])
    }, settings.animationDuration);
})
</script>

<style scoped>

</style>
