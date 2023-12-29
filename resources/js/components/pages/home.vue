<template>
    <div id="home"
         :style="{height: height + 'px'}"
         style="background-color: #111827"
         class="flex relative overflow-y-auto overflow-x-hidden shrink-0 flex-col w-screen">
        <div id="home-container"
             class="w-full sticky z-20 shrink-0 top-0 left-0 py-10 md:py-0 overflow-hidden tracking-wide h-full leading-relaxed text-gray-800 justify-between md:justify-center flex md:!flex-row flex-col items-center">
            <div id="home-text" class="w-11/12 md:w-5/12 relative h-4/6 flex flex-col overflow-hidden">
                <div class="h-32 w-full shrink-0">

                </div>
                <h1 class="sticky title top-0 bg-[#111827] z-10 uppercase text-[#E8544E] font-bold text-4xl xl:text-7xl">
                    <span class="home-title inline-block pr-4 opacity-0 ">Before </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">the </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">coup </span> <br>
                    <span class="home-title inline-block pr-4 opacity-0 ">After </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">the </span>
                    <span class="home-title inline-block pr-4 opacity-0 ">election</span>
                </h1>
                <div class="h-4/6 w-full shrink-0"></div>
                <div class="flex flex-col relative h-5/6 w-full leading-relaxed md:leading-8 tracking-wider">
                    <p class="description w-full text-gray-600">Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                        1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen
                        book. It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                        sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like
                        Aldus PageMaker including versions of Lorem Ipsum. Sed ut perspiciatis unde omnis iste natus
                        error sit
                        voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                        inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                        voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                        eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia
                        dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
                        labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                        exercitationem ullam corporis suscipit laboriosam</p>
                    <h1 class="font-semibold text-xl mt-40">Interaction and navigation guide</h1>
                    <p class="description w-full mt-4 text-gray-600">BCAE story is linear and you can scroll vertically
                        to walk through the story. You can jump to any section in carousel page which can be accessed by
                        clicking on the section icon in the top-right corner. You can also interact with different
                        elements in the page. A blinking (i) icon indicates that you can interact with an element, and
                        it will disappear once you do so. You can click on a static (i) icon to see more information
                        about an element. Interactable texts are enclosed in [text-box] and you can see more information
                        by clicking on them.</p>
                </div>

            </div>
            <div class="w-11/12 md:w-5/12 h-2/6 md:h-full flex items-end justify-end ">
                <img class="h-[80vh] z-10 home-illustration opacity-0" src="assets/vote_hand.png" alt="vote"/>
                <img class="h-[70vh] -ml-40 home-illustration opacity-0" src="assets/protest_hand.png" alt="protest"/>
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
import * as rive from "@rive-app/canvas";

const props = defineProps([]);

const data = reactive({});

const height = window.innerHeight;

const descriptions = [{
    title: 'We are the one',
    description: ''
}, {
    title: 'We are the two',
    description: 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. '
},
    {
        title: 'We are the three',
        description: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.'
    }, {
        title: 'We are the four',
        description: '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"'
    }];

const carousel = (elements, initialIndex = 0, duration = 3000) => {
    let stop = false;
    if (elements.length === 0) throw new Error('Empty items')
    let currentIndex = initialIndex ?? 0;

    let timeout = null;

    const computePosition = (elements, index) => {
        // if currentIndex, default 0;
        if (index === currentIndex) {
            return 0;
        }

        let beforeIndex = (currentIndex - 1 + elements.length) % elements.length;
        // if before current index
        if (index === beforeIndex) {
            return -elements[index].getBoundingClientRect().height;
        }
        let nextIndex = (currentIndex + 1) % elements.length
        // if next index,
        if (index === nextIndex) {
            return elements[currentIndex].getBoundingClientRect().height;
        }

        let el = elements[index];
        let styles = window.getComputedStyle(el);
        let matrix = new WebKitCSSMatrix(styles.transform);
        return matrix.m42 - elements[currentIndex].getBoundingClientRect().height;
    }
    const computePositions = () => {
        let positions = [];

        elements.forEach((element, index) => {
            positions.push(computePosition(elements, index))
        })

        return positions;
    }

    const animate = function (duration) {
        let positions = computePositions();
        anime({
            targets: elements,
            duration: duration ?? 1000,
            easing: 'easeOutQuart',
            translateY: (el, index) => {
                return positions[index];
            },
            opacity: [
                {
                    value: (el, index) => {
                        if (currentIndex === index) {
                            return 1;
                        }
                        return 0;
                    },
                    easing: 'linear',
                    duration: 50,
                },
            ]
        })
        currentIndex = (currentIndex + 1) % elements.length;
    }

    animate(0);

    const loop = () => {
        if (!timeout) {
            timeout = setTimeout(() => {
                animate();
                timeout = null;
            }, duration)
        }
        requestAnimationFrame(loop.bind(this))
    };

    loop();
    return this;
}

const trigger = () => {
    // const r = new rive.Rive({
    //     src: "assets/test.riv",
    //     // Or the path to a public Rive asset
    //     // src: '/public/example.riv',
    //     canvas: document.getElementById("canvas"),
    //     autoplay: true,
    //     shouldDisableRiveListeners: false,
    //     animations: 'Timeline 1',
    //     stateMachines: 'State Machine 1',
    //     automaticallyHandleEvents: true,
    //     onLoad: () => {
    //         r.resizeDrawingSurfaceToCanvas();
    //         r.on(rive.EventType.RiveEvent, (riveEvent) => {
    //             switch (riveEvent.data.name) {
    //                 case "hover_exit":
    //                     document.body.style.cursor = 'default';
    //                     break;
    //                 case "hovering":
    //                     document.body.style.cursor = 'pointer';
    //                     break;
    //                 case "click_navigation":
    //                     route.changeTo('navigation');
    //                     break;
    //                 case "click_get_started":
    //                     route.changeTo('story');
    //                     break;
    //             }
    //         })
    //     },
    // });

    const body = document.getElementById('home-text');
    const bodyHeight = body.getBoundingClientRect().height;
    const bodyScrollHeight = body.scrollHeight;
    let timeout = null;
    new AnimeScrollTrigger(document.getElementById('home'), [
        // {
        //     scrollTrigger: {
        //         trigger: '#home-trigger',
        //         start: 'top top',
        //         end: 'bottom bottom',
        //         pin: '#home-container'
        //     }
        // },
        {
            scrollTrigger: {
                trigger: '#home-trigger',
                start: 'top top',
                end: '70% bottom',
                lerp: true,
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
            targets: ['#card2', '#card1'],
            rotateY: 0,
            y: -300,
            x: [{
                value: (el, index) => {
                    return index ? -200 : 600;
                },
                delay: 1000,
            }],
            height: [{
                value: 400,
                delay: 1000,
            }],
            width: [{
                value: 350,
                delay: 1000,
            }],
            scrollTrigger: {
                trigger: '#home-trigger',
                start: '60% bottom',
                end: 'bottom bottom',
                lerp: true,
                // smooth: true,
            }
        },
    ]);
}
let currentScrollOffset = 0;
onMounted(() => {

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
                color: '#131313',
                easing: 'easeOutQuart',
                duration: 1000,
            })

            anime({
                targets: '.home-illustration',
                opacity: 1,
                delay: 400,
                easing: 'easeOutQuart',
                duration: 1000,
            })

            trigger();
        }
    })
})

onDeactivated(() => {
    currentScrollOffset = document.querySelector('#home').scrollTop;
})

onActivated(() => {
    document.querySelector('#home').scrollTop = currentScrollOffset;
})
</script>

<style scoped>

.home-title {
    transform: translateY(100%);
}
</style>
