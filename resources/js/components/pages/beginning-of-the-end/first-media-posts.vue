<template>
    <div id="beginning-of-the-end-media-posts"
         class="w-full overflow-visible text-white relative flex flex-col items-center"
         :style="{height: `${height * articles.length}px`}">
        <div id="beginning-of-the-end-media-posts-pinner"
             class="z-10 shrink-0 w-10/12 sticky top-24 md:w-6/12 flex flex-col">
            <div v-for="(article,index) in articles"
                 class="beginning-of-the-end-media-post-title absolute font-semibold  text-xl md:text-2xl"
                 style="color:#E8544E; -webkit-text-fill-color: #E8544E; transform-origin: 0 0; text-align: right"
                 :style="{width: boxHeight + 'px', transform : `translateX(-${translateDistance * 3}px) translateY(${(index + 1) * boxHeight}px) rotate(-90deg)`, opacity: index === 0 ? 1: 0.4}">
                {{ article.title }}
            </div>
            <div
                :id="'beginning-of-the-end-media-post-'+index"
                v-for="(article,index) in articles"
                class="beginning-of-the-end-media-post w-full justify-between p-4 md:p-10 border-[#E8544E] border flex-col  bg-gray-800 flex absolute overflow-visible"
                style="will-change: transform"
                :style="{
                    zIndex: -index,
                    height: boxHeight +'px',
                    transform: `translateX(${index * translateDistance}px) translateY(${index * translateDistance}px)`}">
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
                    <div class="justify-self-end w-8 h-8" v-html="more">

                    </div>
                </div>
                <div :title="article.description" class="h-4/6 border-b">
                    {{ truncate(article.description, width > 768 ? 600 : 300) }}
                </div>
                <div class="flex h-1/6 items-center w-full justify-between">
                    <div class="flex items-center justify-center w-4/12 gap-x-2">
                        <div v-html="like" class="w-8 h-8"></div>
                        <span>Like</span>
                    </div>
                    <div class="flex items-center justify-center w-4/12 gap-x-2">
                        <div v-html="comment" class="w-8 h-8"></div>
                        <span>Comment</span>
                    </div>
                    <div class="flex items-center justify-center w-4/12 gap-x-2">
                        <div v-html="share" class="w-8 h-8"></div>
                        <span>Share</span>
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

const props = defineProps([]);


const width = window.innerWidth;
const height = window.innerHeight;

const boxHeight = width > 768 ? height * 0.6 : height * 0.8;
const translateDistance = width > 768 ? 20 : 10;

const data = reactive({})
const articles = [{
    dateTime: '2/1/2021 2:51:25',
    author: 'Myo Yan Naung Thein',
    title: 'First Post Related To Coup',
    description: '"Emergency Tip" If your Internet connection is down, you can use your phone to connect to each other through a mesh network. Available Mesh Network Apps are: "FireChat" for android and apple iOS; "The Serval Mesh" for android; "Signal Offline Messenger" for android; "Vojer" for apple iOS; "Bridgefy" for android and apple iOS; and "Briar" for android. Here is an example of "Bridgefy" app. You can use the "Bridgefy" app in case of sudden internet outage. This app was used by pro-revolutionaries during the Hong Kong protests. Its advantage is that it can send text messages via bluetooth without internet connection, which is very useful. The Chinese Government\'s advanced technology could not prevent the use of this apk during the protests in Hong Kong. Using this apk, you can connect up to 100 meters (about 330 feet) from one phone to another. If there is a telephone within every 100 meters, and by connecting, it can be connect to even the most distant places. You can use this apk to send individual messages or you can share your message to everyone nearby with the Broadcast function. That app can be used on both iPhone and Android. We encourage you to download and install it because it need internet connection for first time to log in. You can easily search and download it in Play Store or App Store by typing "Bridgefy". (Note: We want you to start using it while you have access to use the internet). Here is the link: https://www.facebook.com/100005014158392/posts/1763764217134033/?d=n',
}, {
    dateTime: '2/1/2021 3:43:03',
    author: 'လူငယ့်အသံလူငယ့်ဟန',
    title: 'First Post About Coup',
    description: "Shan State Planning and Finance Minister U Soe Nyunt Lwin was reportedly taken away; Cann't contact with Government offices in Nay Pyi Taw; Phone lines have been cut off."
}, {
    dateTime: '2/1/2021 5:44:52',
    author: 'DVB TV News',
    title: 'First Media Post About Coup',
    description: 'Tatmadaw seizes power, detains all the chief ministers of states and regions. The Tatmadaw seized power earlier this morning and detained all the chief ministers of the states and regions, including the Yangon Region chief minister.',
},]

onMounted(() => {
    let duration = 1000;
    let articles = document.querySelectorAll('.beginning-of-the-end-media-post');
    let articleRect = articles[0].getBoundingClientRect();
    let articleTitles = document.querySelectorAll('.beginning-of-the-end-media-post-title');
    let titleTranslateY = [0, boxHeight, boxHeight * 2, boxHeight * 3];
    let postTranslateX = [0, 0, translateDistance, translateDistance * 2];
    let postTranslateY = [-document.querySelector('main').scrollTop - articleRect.top - articleRect.height - 10, 0, translateDistance, translateDistance * 2];
    let animations = [];
    let divider = Math.round(100 / articles.length);
    let stopPercentages = [];
    let startIndex = 1;
    for (let i = 0; i < articles.length; i++) {
        animations.push([
            {
                targets: articles,
                duration: duration,
                easing: 'easeOutQuart',
                translateX: (el, index) => {
                    return postTranslateX[Math.max(index + startIndex - i, 0)];
                },
                translateY: (el, index) => {
                    return postTranslateY[Math.max(index + startIndex - i, 0)];
                }
            }, {
                targets: articleTitles,
                duration: duration,
                easing: 'easeOutQuart',
                opacity: (el, index) => {
                    return index === i ? 1 : 0.4;
                },
                translateY: (el, index) => {
                    return titleTranslateY[Math.max(index + startIndex - i, 0)]
                }
            }
        ])
        stopPercentages.push(i * divider);
        // let animation = {
        //     titles: {
        //         translateY: [],
        //     },
        //     posts: {
        //         translateX: [],
        //         translateY: [],
        //     }
        // };
        // articles.forEach((article, index) => {
        //     animation.titles.translateY.push(titleTranslateY[Math.max(index + startIndex - i, 0)]);
        //     animation.posts.translateY.push(postTranslateY[Math.max(index + startIndex - i, 0)])
        //     animation.posts.translateX.push(postTranslateX[Math.max(index + startIndex - i, 0)])
        // })
        // animations.push(animation)
    }

    let currentIndex = -1;

    let timeout = null;

    setTimeout(() => {
        new AnimeScrollTrigger(document.querySelector('main'), [{
            scrollTrigger: {
                trigger: document.querySelector('#beginning-of-the-end-media-posts'),
                lerp: true,
                onUpdate: (_, progress) => {
                    if (timeout) clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        let percentage = Math.round(progress * 100);
                        let ps = stopPercentages.filter((p) => percentage > p);
                        if (ps.length > 0) {
                            let index = ps.length - 1;
                            if (index !== currentIndex) {
                                currentIndex = index;
                                let animes = animations[currentIndex];
                                anime(animes[0])
                                anime(animes[1])
                            }
                        }
                    }, 10)

                },
                start: 'top top',
                end: 'bottom bottom',
            }
        }])
    }, 2000)
})
</script>

<style scoped>

</style>
