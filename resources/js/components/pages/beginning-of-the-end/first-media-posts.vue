<template>
    <div id="beginning-of-the-end-media-posts"
         class="w-full overflow-visible text-white relative flex flex-col items-center"
         :style="{height: `${boxHeight * (articles.length)}px`}">
        <div id="beginning-of-the-end-media-posts-pinner"
             :style="{height: height + 'px'}"
             class="z-10 shrink-0 w-10/12 sticky justify-center top-0 md:w-6/12 flex flex-col">
            <div
                :id="'beginning-of-the-end-media-post-'+index"
                v-for="(article,index) in articles"
                class="beginning-of-the-end-media-post w-full flex-col  flex absolute overflow-visible"
                style="will-change: transform"
                :style="{
                    zIndex: -index,
                    height: boxHeight +'px',
                    transform: `translateX(${index * translateDistance}px) translateY(${index * translateDistance}px)`}">
                <h1 class="beginning-of-the-end-media-post-title mb-4 font-semibold  text-xl md:text-2xl"
                    :style="{color: headers[6].secondaryColor,opacity: index === 0 ? 1: 0}">
                    {{ article.title }}
                </h1>
                <div
                    :style="{borderColor: headers[6].secondaryColor}"
                    class="border flex-col  bg-gray-800 flex w-full h-full p-4 md:p-10 justify-between">
                    <div class="flex justify-between w-full">
                        <div class="flex">
                            <div v-html="avatar" class="w-12 h-12 mr-6"></div>
                            <div class="flex flex-col">
                                <p class="text-lg md:text-xl font-semibold">{{ article.author }}</p>
                                <div class="flex items-center gap-x-2">
                                    <time>{{ article.dateTime }}</time>
                                    <div v-html="earth" class="w-5 h-5 mb-1 text-white"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div :title="article.description" class="h-4/6 border-b text-ellipsis">
                        {{ truncate(article.description, width > 768 ? 600 : 300) }}
                    </div>
                    <div class="flex h-1/6 items-center w-full justify-between">
                        <a :href="article.url" target="_blank" class="flex items-center justify-center w-4/12 gap-x-2">
                            <div v-html="like" class="w-5 h-5 2xl:!w-8 md:!h-8"></div>
                            <span>Like</span>
                        </a>
                        <a :href="article.url" target="_blank" class="flex items-center justify-center w-4/12 gap-x-2">
                            <div v-html="comment" class="w-5 h-5 2xl:!w-8 md:!h-8"></div>
                            <span>Comment</span>
                        </a>
                        <a :href="article.url" target="_blank" class="flex items-center justify-center w-4/12 gap-x-2">
                            <div v-html="share" class="w-5 h-5 2xl:!w-8 md:!h-8"></div>
                            <span>Share</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import truncate from "../../../api/truncate.js";
import AnimeScrollTrigger from "anime-scrolltrigger";
import anime from "animejs";
import {avatar, comment, earth, like, more, share} from "../../../assets/icons.js";
import settings from "../../../api/settings.js";
import {headers} from "../../../api/route.js";

const props = defineProps([]);


const width = window.innerWidth;
const height = window.innerHeight;

const boxHeight = width > 1300 ? height * 0.6 : height * 0.8;
const translateDistance = width > 768 ? 20 : 10;

const data = reactive({})
const articles = [{
    dateTime: '2/1/2021 2:51:25',
    author: 'Myo Yan Naung Thein',
    title: 'First Post Related To Coup',
    url: 'https://www.facebook.com/MyoYanNaungThein/photos/a.10153281836274241/10159104155624241/?type=3',
    description: '"Emergency Tip" If your Internet connection is down, you can use your phone to connect to each other through a mesh network. Available Mesh Network Apps are: "FireChat" for android and apple iOS; "The Serval Mesh" for android; "Signal Offline Messenger" for android; "Vojer" for apple iOS; "Bridgefy" for android and apple iOS; and "Briar" for android. Here is an example of "Bridgefy" app. You can use the "Bridgefy" app in case of sudden internet outage. This app was used by pro-revolutionaries during the Hong Kong protests. Its advantage is that it can send text messages via bluetooth without internet connection, which is very useful. The Chinese Government\'s advanced technology could not prevent the use of this apk during the protests in Hong Kong. Using this apk, you can connect up to 100 meters (about 330 feet) from one phone to another. If there is a telephone within every 100 meters, and by connecting, it can be connect to even the most distant places. You can use this apk to send individual messages or you can share your message to everyone nearby with the Broadcast function. That app can be used on both iPhone and Android. We encourage you to download and install it because it need internet connection for first time to log in. You can easily search and download it in Play Store or App Store by typing "Bridgefy". (Note: We want you to start using it while you have access to use the internet). Here is the link: https://www.facebook.com/100005014158392/posts/1763764217134033/?d=n',
}, {
    dateTime: '2/1/2021 3:43:03',
    author: 'လူငယ့်အသံလူငယ့်ဟန်',
    title: 'First Post About Coup',
    url: 'https://www.facebook.com/529864767534927/posts/1019468761907856',
    description: "Shan State Planning and Finance Minister U Soe Nyunt Lwin was reportedly taken away; Cann't contact with Government offices in Nay Pyi Taw; Phone lines have been cut off."
}, {
    dateTime: '2/1/2021 5:44:52',
    author: 'DVB TV News',
    title: 'First Media Post About Coup',
    url: 'https://www.facebook.com/DVBTVNews/posts/3984924851545985',
    description: 'Tatmadaw seizes power, detains all the chief ministers of states and regions. The Tatmadaw seized power earlier this morning and detained all the chief ministers of the states and regions, including the Yangon Region chief minister.',
},]

onMounted(() => {
    let container = document.getElementById('beginning-of-the-end-media-posts')
    let articles = document.querySelectorAll('.beginning-of-the-end-media-post');
    let articleRect = articles[0].getBoundingClientRect();
    let articleTitles = document.querySelectorAll('.beginning-of-the-end-media-post-title');
    let postTranslateX = [0, 0, translateDistance, translateDistance * 2];
    let postTranslateY = [-articleRect.height + container.getBoundingClientRect().top - articleRect.top - 96, 0, translateDistance, translateDistance * 2];
    let startIndex = 1;

    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            targets: articles,
            translateX: [{
                value: (el, index) => {
                    return postTranslateX[Math.max(index + startIndex - 0, 0)]
                },
            }, {
                value: (el, index) => {
                    return postTranslateX[Math.max(index + startIndex - 1, 0)]
                },
                delay: 400
            }, {
                value: (el, index) => {
                    return postTranslateX[Math.max(index + startIndex - 2, 0)]
                },
                delay: 400,
            }],
            translateY: [{
                value: (el, index) => postTranslateY[Math.max(index + startIndex - 0, 0)],
            }, {
                value: (el, index) => postTranslateY[Math.max(index + startIndex - 1, 0)],
                delay: 400,
            }, {
                value: (el, index) => postTranslateY[Math.max(index + startIndex - 2, 0)],
                delay: 400,
            }],
            scrollTrigger: {
                trigger: document.querySelector('#beginning-of-the-end-media-posts'),
                lerp: true,
                start: 'top top',
                end: 'bottom bottom',
            }
        }, {
            targets: articleTitles,
            opacity: [{
                value: (el, index) => {
                    return index === 0 ? 1 : 0;
                },
            }, {
                value: (el, index) => {
                    return index <= 1 ? 1 : 0;

                },
                delay: 400,
            }, {
                value: (el, index) => {
                    return index <= 2 ? 1 : 0;
                },
                delay: 400,
            }],
            scrollTrigger: {
                trigger: document.querySelector('#beginning-of-the-end-media-posts'),
                lerp: true,
                start: 'top top',
                end: 'bottom bottom',
            }
        }])
    }, settings.animationDuration)
})
</script>

<style scoped>

</style>
