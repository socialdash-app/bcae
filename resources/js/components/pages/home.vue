<template>
    <div id="home"
         :style="{height: height + 'px'}"
         class="flex relative items-center bg-[#111827] overflow-y-auto overflow-x-hidden shrink-0 flex-col w-screen">
        <div id="home-container"
             class="w-full sticky z-20 shrink-0 top-0 left-0 py-10 md:py-0 overflow-hidden tracking-wide h-full leading-relaxed text-gray-800 justify-between md:!justify-center flex md:!flex-row flex-col items-center">
            <div id="home-text" class="w-11/12 md:w-6/12 relative h-4/6 flex flex-col overflow-hidden">
                <div class="h-32 w-full shrink-0">

                </div>
                <h1 class="sticky title whitespace-nowrap top-0 bg-[#111827] z-10 uppercase text-[#E8544E] font-bold text-4xl xl:text-7xl">
                    <span class="home-title inline-block pr-4 opacity-0 ">Before </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">the </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">coup </span> <br>
                    <span class="home-title inline-block pr-4 opacity-0 ">After </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">the </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">election</span>
                </h1>
                <div class="h-4/6 w-full shrink-0"></div>
                <div class="flex flex-col relative h-5/6 w-full leading-relaxed md:leading-8 tracking-wider">
                    <p class="description w-full text-gray-700">On the 1st of February 2021 when Vice President Myint
                        Swe became an Acting President and declared on state-owned media that the results of the
                        November 2020 general election were invalid, instating a one-year state of emergency, and
                        handing control of the executive, legislative, and judicial branches of government to the
                        commander in chief of the armed forces, Senior General Min Aung Hlaing. After years of living
                        under military rule, the people's hopes for democracy that had been glowing since 2010 were
                        dashed. The coup has also brought economic turmoil, wiping out modest gains in poverty reduction
                        made over the past decade. But, this coup was not the first time for Myanmar; it was preceded by
                        many military coups since 1958.
                        <br>
                        Before the coup d'état, the military and other political parties repeatedly announced that the
                        election was unfair. Do you think the 2020 general election is not fair? Do you want to know the
                        incidents that happened during the period before the coup and after the election?
                        In BCAE, you can explore election results, actions of related organizations or parties,
                        prominent events, and other announcements both before the coup and after the election. BCAE
                        covered data from social media pages of officials and newsrooms.
                    </p>
                    <h1 class="font-semibold text-xl mt-40 description">Interaction and navigation guide</h1>
                    <p class="description w-full mt-4 text-gray-700">BCAE story is linear and you can scroll vertically
                        to walk through the story. You can jump to any section in carousel page which can be accessed by
                        clicking on the section icon in the top-right corner. You can also interact with different
                        elements in the page. A blinking (i) icon indicates that you can interact with an element, and
                        it will disappear once you do so. You can click on a static (i) icon to see more information
                        about an element. Interactable texts are enclosed in [text-box] and you can see more information
                        by clicking on them.</p>
                </div>
            </div>
            <div class="w-11/12 md:w-5/12 h-2/6 md:h-full flex items-end justify-end ">
                <img style="transform-origin: center bottom; transform: scale(1);"
                     class="h-[80vh] z-10 home-illustration opacity-0"
                     src="assets/vote_hand.png" alt="vote"/>
                <img style="transform-origin: center bottom; transform: scale(0.8);"
                     class="h-[70vh] home-illustration opacity-0"
                     src="assets/protest_hand.png" alt="protest"/>
            </div>
            <div id="scroll-down-indicator" class="fixed  bottom-8 opacity-0 gap-y-6 flex flex-col items-center">
                <h1 class="text-xl">Scroll Down</h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-mouse">
                    <rect x="5" y="2" width="14" height="20" rx="7"/>
                    <path d="M12 6v4"/>
                </svg>
            </div>
            <div class="absolute bottom-0 z-20">
                <svg class="h-[50vh] overflow-visible transform translate-y-full" id="Ballot" width="687" height="839"
                     viewBox="0 0 687 839" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <g id="Ballot initial 1">
                        <g id="Clip path group">
                            <mask id="mask0_11_2455" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0"
                                  y="219" width="687" height="620">
                                <g id="ArtboardFrame">
                                    <path id="Vector" d="M687 219H0V839H687V219Z" fill="white"/>
                                </g>
                            </mask>
                            <g mask="url(#mask0_11_2455)">
                                <g id="Layer-1">
                                    <g id="Group">
                                        <g id="Group_2">
                                            <path id="Vector_2" d="M30 316.5L470.85 354.24V839L30 801.27V316.5Z"
                                                  fill="#3395FF" stroke="black" stroke-miterlimit="10"
                                                  stroke-linejoin="round"/>
                                            <path id="Vector_3"
                                                  d="M470.85 354.24L657.07 262.95V747.72L470.85 839V354.24Z"
                                                  fill="#3395FF" stroke="black" stroke-miterlimit="10"
                                                  stroke-linejoin="round"/>
                                        </g>
                                        <g id="Group_3">
                                            <path id="Vector_4" d="M204 219L687 260.4L483 360.4L0 319L204 219Z"
                                                  fill="#3395FF" stroke="black" stroke-miterlimit="10"
                                                  stroke-linejoin="round"/>
                                            <path id="Vector_5" d="M0 319L483 360.4V419L0 377.6V319Z" fill="#3395FF"
                                                  stroke="black" stroke-miterlimit="10" stroke-linejoin="round"/>
                                            <path id="Vector_6" d="M483 360.4L687 260.4V319L483 419V360.4Z"
                                                  fill="#3395FF" stroke="black" stroke-miterlimit="10"
                                                  stroke-linejoin="round"/>
                                        </g>
                                        <path id="Vector_7"
                                              d="M248.001 279.72L446.871 296.76L439.411 299.68L240.135 282.61L248.001 279.72Z"
                                              fill="#3395FF" stroke="black" stroke-miterlimit="10"
                                              stroke-linejoin="round"/>
                                    </g>
                                </g>
                            </g>
                        </g>
                        <mask id="mask1_11_2455" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="-657" y="-813"
                              width="2207" height="1113">
                            <path id="card mask"
                                  d="M208.5 260L253.5 283L437 298.5L525.5 260L1055 271.5L1347 181L1548.5 -197L1469 -620.5L991.5 -812.5H54.5L-656.5 -731V-394V-43L-541 217L-208 260H120H208.5Z"
                                  fill="#D9D9D9" stroke="black"/>
                        </mask>
                        <g mask="url(#mask1_11_2455)">
                            <rect
                                @click="route.changeTo('navigation')"
                                style="cursor: pointer; -webkit-transform: rotateY(45deg); transform: rotateY(45deg); -webkit-transform-origin: center; transform-origin: center"
                                id="card1" x="268" y="400" width="175" height="220"
                                fill="#6BCAFF"/>
                            <rect
                                @click="route.changeTo('story')"
                                style="cursor: pointer; -webkit-transform: rotateY(45deg); transform: rotateY(45deg); -webkit-transform-origin: center; transform-origin: center"
                                id="card2" x="263" y="420" width="175" height="220"
                                fill="#FF7474"/>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
        <div class="w-full h-[300vh] shrink-0">

        </div>
        <div id="home-trigger" class="w-full absolute h-[500vh] shrink-0">

        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted, onDeactivated, onActivated} from "vue";
import anime from "animejs";
import AnimeScrollTrigger from 'anime-scrolltrigger';
import route from "../../api/route.js";

const props = defineProps([]);

const data = reactive({});

const height = window.innerHeight;

const trigger = () => {
    const body = document.getElementById('home-text');
    const bodyHeight = body.getBoundingClientRect().height;
    const bodyScrollHeight = body.scrollHeight;
    let timeout = null;
    new AnimeScrollTrigger(document.getElementById('home'), [
        {
            targets: '.home-illustration',
            // translateX: [{
            //     value: (_, index) => index === 0 ? 300 : -200,
            //     delay: 1000,
            // }],
            scale: [{
                value: (_, index) => index === 0 ? 0.7 : 1.1,
                // delay: 1000,
            }],
            // zIndex: (_, index) => index === 0 ? -10 : 10,
            translateY: [0, 0],
            scrollTrigger: {
                trigger: '#home-trigger',
                start: '1% top',
                end: '70% bottom',
                lerp: true,
                onLeaveBack: () => {
                    anime({
                        targets: '#scroll-down-indicator',
                        easing: 'easeOutQuart',
                        opacity: 1,
                        translateY: [100, 0],
                        duration: 1000,
                    })
                },
                onEnter: () => {
                    anime({
                        targets: '#scroll-down-indicator',
                        easing: 'easeOutQuart',
                        opacity: 0,
                        translateY: [0, 100],
                        duration: 1000,
                    })
                },
                onLeave: () => {
                    anime({
                        targets: ['.home-illustration', '.description'],
                        filter: `blur(2px)`,
                        easing: 'easeOutQuart',
                        duration: 500,
                        update: function (anim) {
                            console.log(anim)
                            // targetElm.style.filter = 'blur(' + 20 * anim.progress / 100 + 'px)'
                        }
                    })
                },
                onEnterBack: () => {
                    anime({
                        targets: ['.home-illustration', '.description'],
                        filter: `blur(0px)`,
                        easing: 'easeOutQuart',
                        duration: 500,
                        update: function (anim) {
                            console.log(anim)
                            // targetElm.style.filter = 'blur(' + 20 * anim.progress / 100 + 'px)'
                        }
                    })
                },
                onUpdate: (_, progress) => {
                    anime({
                        targets: body,
                        scrollTop: progress * (bodyHeight + bodyScrollHeight),
                        easing: 'easeOutQuart',
                        duration: 400,
                    })
                }
            }
        },
        {
            targets: '#Ballot',
            translateY: ['100%', '30%'],
            scrollTrigger: {
                trigger: '#home-trigger',
                start: '40% bottom',
                end: 'bottom bottom',
                lerp: true,
                // smooth: true,
            }
        }, {
            targets: ['#card1', '#card2'],
            rotateY: [{
                value: 180,
                delay: 1000,
            }],
            y: -300,
            x: [{
                value: (el, index) => {
                    return index ? -200 : 600;
                },
                delay: 1000,
            }],
            height: [{
                value: 350,
                delay: 1000,
            }],
            width: [{
                value: 300,
                delay: 1000,
            }],
            scrollTrigger: {
                trigger: '#home-trigger',
                start: '60% bottom',
                end: 'bottom bottom',
                lerp: true,

                // smooth: true,
            },
        },
    ]);
}
let currentScrollOffset = 0;

const init = () => {
    anime({
        targets: '.home-title',
        delay: anime.stagger(100),
        duration: 1000,
        opacity: 1,
        translateY: ['100%', '0%'],
        easing: 'easeOutQuart',
        complete: () => {
            anime({
                targets: '#home',
                background: '#fff',
                easing: 'easeOutQuart',
                duration: 1000,
            })

            anime({
                targets: '.title',
                background: '#fff',
                easing: 'easeOutQuart',
                duration: 1000,
            })

            anime({
                targets: '.home-title',
                color: '#111827',
                easing: 'easeOutQuart',
                duration: 1000,
            })

            anime({
                targets: '#scroll-down-indicator',
                easing: 'easeOutQuart',
                opacity: 1,
                translateY: [100, 0],
                duration: 100,
            })

            anime({
                targets: '.home-illustration',
                opacity: 1,
                translateY: [100, 0],
                delay: (_, index) => index * 400,
                easing: 'easeOutQuart',
                duration: 1000,
            })
            trigger();
        }
    })
}
onMounted(() => {
    init();
})

onDeactivated(() => {
    currentScrollOffset = document.querySelector('#home').scrollTop;
})

onActivated(() => {
    document.querySelector('#home').scrollTo({
        top: currentScrollOffset,
        behavior: "smooth"
    });
})
</script>

<style scoped>

.home-title {
    transform: translateY(100%);
}
</style>
