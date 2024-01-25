<template>
    <div id="party-facebook-media-posts-trigger"
         class="w-full relative flex flex-col items-center" :style="{height: articles.length * 600 + 'px'}">
        <div class="w-full flex flex-col py-4 overflow-hidden sticky top-24 items-center"
             :style="{height: height + 'px'}"
             id="party-facebook-media-posts">
            <h1 class="px-4 md:px-0 font-semibold text-2xl mb-4">Some of their activities and arguments appeared on
                local news </h1>
            <div class="w-full absolute h-full flex items-center justify-center">
                <a v-for="(article, index) in articles"
                   style="will-change: transform; "
                   :id="`party-facebook-media-post-${index}`"
                   :href="article.url"
                   target="_blank"
                   class="party-facebook-media-post text-[#240824] cursor-pointer absolute bg-white rounded p-4 md:!p-10 w-10/12 md:!w-5/12"
                   :style="{opacity: index === 0 ? 1 : 0, zIndex: index}">
                    <h1 class="md:text-lg font-semibold">{{ article.title }}</h1>
                </a>
            </div>
        </div>
        <div :style="{height: articles.length * 600 + 'px'}"></div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import truncate from "../../../api/truncate.js";
import AnimeScrollTrigger from "anime-scrolltrigger";
import settings from "../../../api/settings.js";

const props = defineProps([]);

const data = reactive({})

const width = window.innerWidth;

const height = window.innerHeight;

const randomTranslateValue = (min, max) => {
    return min + Math.random() * (max + 1)
}

const articles = [{
    title: 'USDP in Tachileik District demands letter to UEC to hold a new election on the grounds that the election was not fair',
    url: 'https://www.facebook.com/DVBTVNews/posts/3756377697734036',
}, {
    title: 'The USDP chairman said that the election results were not final as they were controversial',
    url: 'https://www.facebook.com/LivingColorMediaCoLtd/posts/739450853322862',
}, {
    title: 'The USDP confirms that it has been instructed to members not to sign the election results form (19)',
    url: 'https://www.facebook.com/DVBTVNews/posts/3756496257722180',
}, {
    title: 'USDP calls on UEC to hold elections again in collaboration with the Tatmadaw',
    url: 'https://www.facebook.com/onenewsmyan/posts/2697855577195638',
}, {
    title: 'The NDF considers the 2020 election ‌as an unfair election',
    url: 'https://www.facebook.com/epnmediagroup/posts/1676614415845537',
}, {
    title: '"I can see some cases of stealing votes in the list," said Maw Tun Aung, who represented the SNLD and ran in the Amyotha Hluttaw constituency No.5 in Muse District',
    url: 'https://www.facebook.com/BBCnewsBurmese/posts/3588512284537964',
}, {
    title: 'SNLD does not sign the election results form (19) due to the Shan Amyotha Hluttaw No.1 vote count is uncertain',
    url: 'https://www.facebook.com/shannewsburmese/posts/3500392473386504',
}, {
    title: 'DNP left Aye Thayar town for Taunggyi town to protest against UEC',
    url: 'https://www.facebook.com/kanbawzatai/posts/1448525925355069',
}]

onMounted(() => {
    let duration = 2000;
    let posts = document.querySelectorAll('.party-facebook-media-post');
    posts.forEach((post, index) => {
        if (index === 0) return;
        let x = randomTranslateValue(index % 2 ? 0 : -width / 2, index % 2 ? width / 2 : 0)
        let y = randomTranslateValue(index % 2 ? 0 : -height / 2, index % 2 ? height / 2 : 0)
        post.style.transform = `translateX(${x}px) translateY(${y}px)`
    })
    let animations = [{
        targets: posts,
        translateX: [{
            value: 0,
            duration: duration,
            delay: (el, index) => index * duration,
        }],
        opacity: [{
            value: 1,
            duration: duration * 0.4,
            delay: (el, index) => index * duration,
        }],
        translateY: [{
            value: 0,
            duration: duration,
            delay: (el, index) => index * duration,
        }],
        scrollTrigger: {
            trigger: document.querySelector('#party-facebook-media-posts-trigger'),
            lerp: true,
            start: 'top top',
            end: 'bottom bottom',
        }
    }];

    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), animations)
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
