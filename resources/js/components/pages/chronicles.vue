<template>
    <div id="chronicles-trigger" :style="{background: headers[0].primaryColor}"
         class="w-full flex relative py-6 flex-col items-center">
        <div class="sticky ml-[4%] sm:!ml-[8%] self-start top-3 md:!top-6 z-[10002]">
            <h1 class="text-xl md:text-3xl font-bold">Chronicles</h1>
        </div>
        <div id="chronicles-introduction"
             :style="{height: height - 100 + 'px'}"
             class="text-center gap-y-10 w-11/12 md:!w-8/12 flex flex-col items-center justify-center">
            <h1 class="text-4xl opacity-0 font-semibold">Golden land, with a rich history of regime changes</h1>
            <p class="text-gray-700 opacity-0 w-11/12">Since gaining independence in 1948, Myanmar has grappled with
                chronic state
                instability and
                struggled to
                shape a stable nation. Its aspirations for a taste of freedom have repeatedly been dashed by the
                military, pushing the country closer to the brink of a failed state.</p>
        </div>
        <div id="chronicles"
             class="w-11/12 pt-10 items-center md:!items-start md:!w-9/12 md:!flex-row flex-col flex justify-between">
            <div class="w-11/12 md:!w-5/12 h-[50vh] md:!h-[60vh] sticky top-24 left-0">
                <div class="relative w-full h-full chronicle-illustration-container">
                    <div class="justify-between chronicle-illustration flex flex-col w-full absolute h-full"
                         :style="{ opacity: i === 0 ? 1 : 0 }"
                         style="transform-origin: top left;"
                         v-for="(datum, i) in data">
                        <div
                            :style="{visibility: i === 0 && j === 0? 'visible': 'hidden'}"
                            v-for="(illustration,j) in datum.illustrations"
                            class="h-5/6 absolute w-full flex justify-center items-center" :id="datum.title + '-'+ j">
                            <img class="h-full" :src="illustration"
                                 :alt="datum.title + '-'+ j"/>
                        </div>
                    </div>
                </div>
                <svg id="timeline" class="absolute top-0 overflow-visible">

                </svg>
            </div>
            <div class="w-full md:!w-5/12 flex flex-col z-10">
                <div class="shrink-0 h-[50vh]  md:!h-[100vh] w-full">
                </div>
                <div
                    class="flex chronicles-content rounded border shrink-0 gap-y-4 px-4 py-6 md:!px-8 md:!py-12 bg-white  flex-col w-full"
                    :style="{ marginBottom: index !== data.length - 1 ? '60vh' : '0' }"
                    v-for="(datum, index) in data">
                    <p class="w-full text-black">{{ datum.description }}</p>
                </div>
                <div class="shrink-0 md:h-[60vh] h-[30vh]">
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineAsyncComponent, onMounted} from "vue";
import AnimeScrollTrigger from 'anime-scrolltrigger'
import anime from "animejs";
import route, {headers} from "../../api/route.js";
import {axisBottom, easeQuadOut, scaleUtc, select, utcYear} from 'd3';
import settings from "../../api/settings.js";

const props = defineProps([]);
const height = window.innerHeight;
const data = [{
    title: '1958',
    bg: 'bg-red-300',
    illustrations: [
        'assets/illustrations/chronicles/1958/1958_Frame_1.svg',
        'assets/illustrations/chronicles/1958/1958_Frame_2.svg',
        'assets/illustrations/chronicles/1958/1958_NW_frame_1.svg',
        'assets/illustrations/chronicles/1958/1958_NW_frame_2.svg',
        'assets/illustrations/chronicles/1958/1958_NW_frame_3.svg',
        'assets/illustrations/chronicles/1958/1958_NW_frame_4.svg',
    ],
    description: 'The story starts with the military coup-as-per-the-constitution that took place in 1958 when the military pressured a civilian government, which was dealing with divisions within the ruling party, to relinquish state power to the military. Prime Minister U Nu and his cabinet resigned on October 28, 1958, and handed over power to General Ne Win, who formed a caretaker government to preserve the country.'
}, {
    title: '1962',
    bg: 'bg-blue-300',
    illustrations: [
        'assets/illustrations/chronicles/1962/1962_frame_1.svg',
        'assets/illustrations/chronicles/1962/1962_frame_2.svg',
    ],
    description: 'On March 2, 1962, General Ne Win and a group of military officers overthrew the Government of Premier U Nu in a swift bloodless coup d\'etat and established the period of direct military rule and held power for the next twenty-six years. After the coup, General Ne Win formed Revolutionary Council to act as interim government, and the RC has declared that it intends to continue a "neutral" foreign policy.'
}, {
    title: '1988',
    bg: 'bg-gray-300',
    illustrations: [
        'assets/illustrations/chronicles/1988/1988_Frame_1.svg',
        'assets/illustrations/chronicles/1988/1988_Frame_2.svg',
    ],
    description: 'After the 8888 national uprising aka the People Power Uprising against the Burma Socialist Programme Party government, the third military coup occurred on September 18, 1988. The uprising ended with a bloody military coup by the State Law and Order Restoration Council. During the uprising, thousands of people were killed.'
}, {
    title: '1990',
    bg: 'bg-orange-300',
    illustrations: [
        'assets/illustrations/chronicles/1990/1990.svg',
        'assets/illustrations/chronicles/1990/1990_reject_stamp.svg',
    ],
    description: 'The National League for Democracy formed on September 27, 1988, a week after the formation of the State Law and Order Restoration Council, and won 392 of 492 parliamentary seats in the General elections of 1990, but the military council didn\'t handover power to winning party and canceled the election result. After that, it changed its name to State Peace and Development Council in 1997 and ruled until 2010.'
}, {
    title: '2021',
    illustrations: [
        'assets/illustrations/chronicles/2021/2021_frame1.svg',
        'assets/illustrations/chronicles/2021/2021_frame2.svg',
    ],
    bg: 'bg-orange-300',
    description: 'On February 1, 2021, the military led by Min Aung Hlaing seized state power from a democratically elected government, by announcing a one-year state of emergency period under the pretext of vote fraud. People resisted the coup with protests and rallies across the country, but faced violent repression by the military, resulting the formation of a parallel government and allied with armed groups to fight the junta.'
}];

const run = function (fn, intervalInMilliseconds = 1000, autostart = false, maxSteps = null, onComplete = null) {
    let shouldRun = autostart;
    let interval = null;
    let step = 0;
    let _intervalInMilliseconds = intervalInMilliseconds;
    let _maxSteps = maxSteps;
    let _onComplete = onComplete;

    let _fn = () => {
        if (!shouldRun) {
            return
        }
        if (_maxSteps && step >= _maxSteps) {
            clearInterval(interval);
            if (_onComplete && typeof _onComplete === 'function') _onComplete();
            return;
        }
        fn(step);
        step++;
    }
    if (autostart) {
        interval = setInterval(_fn, _intervalInMilliseconds)
    }

    return {
        start: () => {
            shouldRun = true
            if (!interval) {
                _fn();
                interval = setInterval(_fn, _intervalInMilliseconds)
            }
        },
        pause: () => shouldRun = false,
        stop: () => {
            if (interval) clearInterval(interval);
            interval = null;
            step = 0;
            shouldRun = false;
        },
        update: (intervalInMilliseconds = null, autostart = null, maxSteps = null, onComplete = null) => {
            clearInterval(interval);
            if (intervalInMilliseconds) {
                _intervalInMilliseconds = intervalInMilliseconds;
            }
            if (autostart) {
                shouldRun = autostart;
            }
            if (maxSteps) {
                _maxSteps = maxSteps;
            }
            if (onComplete) {
                _onComplete = onComplete;
            }
            interval = setInterval(_fn, _intervalInMilliseconds);
        },
        restart: () => {
            if (interval) clearInterval(interval)
            step = 0;
            shouldRun = true;
            _fn();
            interval = setInterval(_fn, _intervalInMilliseconds);
        },
        get step() {
            return step;
        },
    }
}

const initialiseIllustrationAnimations = () => {
    /*
    Section 1 - 1956: hide other sections and show section 1 and show handshake animation
    Section 2 - 1962: hide handshake animation, start walk animation and then hide other sections and show section 2.
    Section 3 - 1988: hide other sections and show section 3.
    Section 4 - 1990: hide other sections and show section 4.
    Section 5 - 2021: hide other sections and show section 5 and start animation.
     */
    const chronicleIllustrations = document.querySelectorAll('.chronicle-illustration')
    const handshakeFrame1 = document.getElementById(`${data[0].title}-0`)
    const handshakeFrame2 = document.getElementById(`${data[0].title}-1`);
    const turnFrame1 = document.getElementById(`${data[0].title}-2`)
    const turnFrame2 = document.getElementById(`${data[0].title}-3`);
    const walkFrame1 = document.getElementById(`${data[0].title}-4`);
    const walkFrame2 = document.getElementById(`${data[0].title}-5`);

    // need to place walk frames at higher z index
    walkFrame1.style.zIndex = 10;
    walkFrame2.style.zIndex = 10;

    const protest1962Frame1 = document.getElementById(`${data[1].title}-0`);
    const protest1962Frame2 = document.getElementById(`${data[1].title}-1`);

    const illustration1988Frame1 = document.getElementById(`${data[2].title}-0`);
    const illustration1988Frame2 = document.getElementById(`${data[2].title}-1`);

    const illustration1990 = document.getElementById(`${data[3].title}-0`);
    const illustration1990Stamp = document.getElementById(`${data[3].title}-1`);

    const protest2021Frame1 = document.getElementById(`${data[4].title}-0`);
    const protest2021Frame2 = document.getElementById(`${data[4].title}-1`);


    const hideVisibility = (elements, condition) => {
        elements.forEach((element, index) => {
            if (condition && !condition(element, index)) {
                return;
            }
            element.style.visibility = 'hidden';
        })
    }

    const showVisibility = (elements, condition) => {
        elements.forEach((element, index) => {
            if (condition && !condition(element, index)) {
                return;
            }
            element.style.visibility = 'visible';
        })
    }

    const handshakeAnimation = run((step) => {
        handshakeFrame1.style.visibility = step % 2 === 0 ? 'hidden' : 'visible';
        handshakeFrame2.style.visibility = step % 2 === 0 ? 'visible' : 'hidden';
    }, 400)

    handshakeAnimation.start();

    const protest1962Animation = run((step) => {
        protest1962Frame1.style.visibility = step % 2 === 0 ? 'hidden' : 'visible';
        protest1962Frame2.style.visibility = step % 2 === 0 ? 'visible' : 'hidden';
    }, 400)


    const protest1988Animation = run((step) => {
        illustration1988Frame1.style.visibility = step % 2 === 0 ? 'hidden' : 'visible';
        illustration1988Frame2.style.visibility = step % 2 === 0 ? 'visible' : 'hidden';
    }, 600)

    const protest2021Animation = run((step) => {
        protest2021Frame1.style.visibility = step % 2 === 0 ? 'hidden' : 'visible';
        protest2021Frame2.style.visibility = step % 2 === 0 ? 'visible' : 'hidden';
    }, 400)

    let NWTurnFrames = [turnFrame1, turnFrame2]

    let walkFrames = [walkFrame1, walkFrame2];

    const walk = run((step) => {
        let currentFrame = step % walkFrames.length;
        walkFrames.forEach((walkFrame, index) => {
            walkFrame.style.visibility = index === currentFrame ? 'visible' : 'hidden';
        })
    }, 600)

    let protest1962Timeout = null;

    const turnAnimation = run((step) => {
        let currentFrame = step % NWTurnFrames.length;
        NWTurnFrames.forEach((turnFrame, index) => {
            turnFrame.style.visibility = index === currentFrame ? 'visible' : 'hidden';
        })
    }, 600, false, 2, () => {
        hideVisibility(NWTurnFrames)
        walk.start();
        protest1962Timeout = setTimeout(() => {
            protest1962Animation.start();
            anime({
                targets: chronicleIllustrations[1],
                easing: 'easeOutQuart',
                duration: 1500,
                scale: [0.2, 0.7],
                // translateX: ['0%', '-25%'],
                // translateY: ['0%', '-10%'],
                begin: () => {
                    chronicleIllustrations[1].style.opacity = 1;
                },
            })
        }, 1200)
    })

    return [{
        onEnter: () => {
            if (protest1962Timeout) clearTimeout(protest1962Timeout);
            turnAnimation.pause();
            walk.pause();
            protest1962Animation.pause();
            anime({
                targets: chronicleIllustrations,
                easing: 'easeOutQuart',
                duration: 1000,
                opacity: [{
                    value: (_, index) => {
                        return index === 0 ? 1 : 0;
                    },
                    delay: 1000 / 3,
                }],
            })
            hideVisibility([turnFrame1, turnFrame2, walkFrame1, walkFrame2, protest1962Frame1, protest1962Frame2])
            handshakeAnimation.start();
        },
    }, {
        onEnter: () => {
            anime({
                targets: chronicleIllustrations,
                opacity: [{
                    value: (_, index) => {
                        return index === 0 ? 1 : 0;
                    },
                    delay: 1000 / 3,
                }],
            })
            // stop other animation
            protest2021Animation.pause();
            handshakeAnimation.pause();
            protest1988Animation.pause();
            walk.pause();
            hideVisibility([handshakeFrame1, handshakeFrame2, protest2021Frame1, protest2021Frame2, ...walkFrames])
            turnAnimation.restart();
        }
    }, {
        onEnter: () => {
            if (protest1962Timeout) clearTimeout(protest1962Timeout)
            walk.stop();
            protest1962Animation.pause();
            hideVisibility([illustration1990, protest1962Frame1, protest1962Frame2])
            anime({
                targets: chronicleIllustrations,
                easing: 'easeOutQuart',
                opacity: [{
                    value: (_, index) => {
                        return index === 2 ? 1 : 0;
                    },
                    delay: 1000 / 3,
                }]
            })
            illustration1990Stamp.style.opacity = 0;
            protest1988Animation.start();
        }
    }, {
        onEnter: () => {
            anime({
                targets: chronicleIllustrations,
                easing: 'easeOutQuart',
                opacity: [{
                    value: (_, index) => {
                        return index === 3 ? 1 : 0;
                    },
                    duration: 400,
                }]
            })
            protest1988Animation.pause();
            protest2021Animation.pause();
            hideVisibility([illustration1988Frame1, illustration1988Frame2, protest2021Frame1, protest2021Frame2])
            showVisibility([illustration1990, illustration1990Stamp])
            anime({
                targets: illustration1990Stamp,
                opacity: [0, 1],
                scale: [0.8, 0.4],
                duration: 1000,
                easing: 'easeOutBack',
                delay: 1000,
            })
        }
    }, {
        onEnter: () => {
            anime({
                targets: chronicleIllustrations,
                easing: 'easeOutQuart',
                opacity: [{
                    value: (_, index) => {
                        return index === 4 ? 1 : 0;
                    },
                    duration: 400,
                }]
            })
            protest2021Animation.start()
        }
    }]
}

const init = () => {
    anime({
        targets: ['#chronicles-introduction h1', '#chronicles-introduction p'],
        delay: (_, i) => i * 400,
        easing: 'easeOutQuart',
        opacity: 1,
        scale: [1.2, 1],
    })
    const illustrationAnimations = initialiseIllustrationAnimations()
    let chroniclesContents = document.querySelectorAll('.chronicles-content');
    let animations = [{
        scrollTrigger: {
            smooth: true,
            trigger: '#chronicles-trigger',
            start: 'top top',
            end: 'bottom top',
            lerp: true,
            onEnter: () => {
                route.changeSectionHeader(0)
                anime({
                    targets: '#section-indicator-section',
                    background: headers[0].primaryColor,
                    duration: 300,
                    easing: 'linear'
                })
            },
            onEnterBack: () => {
                route.changeSectionHeader(0)
                anime({
                    targets: '#section-indicator-section',
                    background: headers[0].primaryColor,
                    duration: 300,
                    easing: 'linear'
                })
            },
            onUpdate: (_, progress) => {
                anime({
                    targets: '#header-chronicles circle',
                    strokeDashoffset: 160 - progress * 160,
                    easing: 'easeOutQuart',
                    duration: 400,
                })
            }
        }
    }];

    // init year indicator
    const illustrationRect = document.querySelector('.chronicle-illustration-container').getBoundingClientRect();
    const width = illustrationRect.width;
    const height = illustrationRect.height;
    const svg = select('svg#timeline');
    svg.attr('width', data.length * width)
    svg.attr('height', height);
    const x = scaleUtc()
        .domain([new Date('1956'), new Date()])
        .range([10, data.length * width * 4]);
    const initialTranslateX = x(new Date('1958'));
    const gx = svg.append("g")
        .attr("transform", `translate(-${initialTranslateX},${height})`)
        .call(axisBottom(x).ticks(utcYear).tickPadding(10).tickFormat((d, i) => {
            if (data.filter((datum) => d.getFullYear().toString() === datum.title).length > 0) {
                return d.getFullYear();
            }
            return null;
        }));

    gx.selectAll('text').attr('font-size', '20px').attr('font-weight', 'bold')
    gx.selectAll("g.tick line")
        .attr("y2", function (d) {
            if (data.filter((datum) => d.getFullYear().toString() === datum.title).length > 0) {
                return 10;
            }
            return 5;
        })
        .attr('stroke-width', function (d) {
            if (data.filter((datum) => d.getFullYear().toString() === datum.title).length > 0) {
                return 4;
            }
            return 1;
        });

    for (let i = 0; i <= data.length - 1; i++) {
        let translateX = x(new Date(data[i].title));
        let illustrationAnimation = illustrationAnimations[i];
        animations.push({
            scrollTrigger: {
                trigger: chroniclesContents[i],
                start: 'top center',
                end: 'bottom 20%',
                onEnter: () => {
                    illustrationAnimation.onEnter();
                    gx.transition().duration(750).ease(easeQuadOut).attr('transform', `translate(-${translateX},${height})`)
                },
                onLeave: () => {
                    if (illustrationAnimation.onLeave) {
                        illustrationAnimation.onLeave();
                    }
                },
                onEnterBack: () => {
                    illustrationAnimation.onEnterBack ? illustrationAnimation.onEnterBack() : illustrationAnimation.onEnter();
                    gx.transition().duration(750).ease(easeQuadOut).attr('transform', `translate(-${translateX},${height})`)
                },
            }
        })
    }
    new AnimeScrollTrigger(document.querySelector('main'), animations)
}

onMounted(() => {
    setTimeout(() => {
        init()
    }, settings.animationDuration)

})
</script>

<style scoped></style>
