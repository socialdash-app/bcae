<template>
    <div id="trigger" class="flex relative flex-col w-10/12 items-center">
        <div id="home"
             class="w-full sticky top-0 z-[-10] py-10 md:py-0 left-0 overflow-hidden tracking-wide h-screen leading-relaxed text-gray-800 justify-between md:justify-center flex md:!flex-row flex-col items-center">
            <div id="home-text" class="w-11/12 md:w-5/12 relative h-4/6 flex flex-col overflow-hidden">
                <div class="h-2/6 w-full shrink-0"></div>
                <h1 class="title sticky top-0 bg-white z-10 uppercase font-bold text-4xl xl:text-7xl">
                    Before the coup <br> After the election
                </h1>
                <div class="h-3/6 w-full shrink-0"></div>
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
                    <h1 class="font-semibold text-xl mt-40">Another Subtitle</h1>
                    <p class="description w-full mt-4 text-gray-600">Sed ut perspiciatis unde omnis iste natus error sit
                        voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                        inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                        voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                        eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia
                        dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
                        labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                        exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?
                        Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae
                        consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
            <div class="w-11/12 md:w-5/12 h-2/6 md:h-full bg-gray-700">
            </div>
            <div class="absolute bottom-0">
                <div id="card1"
                     style="z-index: 1;transform: perspective(1000px) rotateY(-45deg) translateY(300px) translateX(-90%);"
                     class="absolute opacity-0 w-16 h-28 left-1/2 border bg-emerald-300"></div>
                <div id="card2"
                     style="z-index: 1;transform: perspective(1000px) rotateY(-45deg) translateY(320px) translateX(-100%);"
                     class="absolute opacity-0 w-16 h-28 left-1/2 border bg-red-400"></div>
                <svg id="box" width="559" class="transform"
                     height="482"
                     viewBox="0 0 559 482"
                     preserveAspectRatio="xMidYMin slice"
                     style="overflow: visible"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path id="front" d="M0 61.5L308 107V482L0 436.5V61.5Z" fill="#C5C5C5"/>
                        <path id="right" d="M308 107.5L559 45.5L558.5 420.5L308 481V107.5Z" fill="#5D5D5D"/>
                        <path id="top" d="M251 0L559 45.5L308.5 107.5L0 61.5L251 0Z" fill="#E9E9E9"/>
                        <path id="hole" d="M259 41L309.5 48.5L299 52L247 44.5L259 41Z" fill="#C2C2C2"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="w-full h-[300vh]">

        </div>

    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import anime from "animejs";
import AnimeScrollTrigger from 'anime-scrolltrigger';

const props = defineProps([]);

const data = reactive({});

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

function lerp(start, end, current) {
    let distance = Math.abs(end - start);
    let currentDist = Math.max(end - current, 0);
    return 1 - Math.min(currentDist / distance, 1);
}

const trigger = () => {
    const body = document.getElementById('home-text');
    const bodyHeight = body.getBoundingClientRect().height;
    const bodyScrollHeight = body.scrollHeight;
    new AnimeScrollTrigger(document.querySelector('main'), [
        {
            scrollTrigger: {
                trigger: '#trigger',
                start: 'top top',
                end: '50% bottom',
                lerp: true,
                onUpdate: (_, progress) => {
                    body.scrollTop = progress * (bodyHeight + bodyScrollHeight);
                }
            }
        },
        {
            targets: '#box',
            translateY: ['100%', '50%'],
            // translateX: ['-50%', '-50%'],
            opacity: 1,
            duration: 1000,
            scrollTrigger: {
                trigger: '#trigger',
                start: '30% bottom',
                end: 'bottom bottom',
                lerp: true,
            }
        }, {
            targets: ['#card1', '#card2'],
            translateY: '-50px',
            opacity: [0, 1],
            rotateY: '180deg',
            translateX: [{
                value: (el, index) => {
                    return index ? -90 : 180;
                },
                delay: 500,
            }],
            width: {
                value: '25%',
                delay: 500,
            },
            height: {
                value: '40%',
                delay: 500,
            },
            duration: 1000,
            scrollTrigger: {
                trigger: '#trigger',
                start: '60% bottom',
                end: 'bottom bottom',
                lerp: true,
            }
        },
    ]);
}

onMounted(() => {
    trigger();
})
</script>

<style scoped>

</style>
