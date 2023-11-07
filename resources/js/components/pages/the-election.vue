<template>
    <div id="container" class="w-full h-full flex p-10 items-start overflow-auto">
        <div class="w-1/2 self-center h-5/6 fixed flex flex-col items-center">
            <svg id="map" class="w-full h-full">
                <g class="map" fill="#b3b3b3" stroke="black" stroke-width="0.01"></g>
                <g class="details" fill="orange" stroke="black" stroke-width="0.01"></g>
            </svg>
            <div class="flex flex-col absolute bottom-0 left-0 gap-y-4">
                <button class="w-64 h-16 border bg-amber-300"></button>
                <button class="w-64 h-16 border bg-blue-300"></button>
            </div>
        </div>
        <div class="w-1/2"></div>
        <div class="w-1/2 gap-y-24 flex flex-col">
            <div class="trigger w-full border rounded bg-gray-200 h-[40vh]"></div>
            <div class="trigger w-full border rounded bg-gray-200 h-[40vh]"></div>
            <div class="trigger w-full border rounded bg-gray-200 h-[40vh]"></div>
        </div>
    </div>

</template>

<script setup>
import {onMounted, reactive} from 'vue';
import * as d3 from 'd3';
import anime from "animejs";

const data = reactive({});
const init = () => {
    const svg = d3.select('svg#map');
    const width = svg.node().getBoundingClientRect().width;
    const height = svg.node().getBoundingClientRect().height;
    svg.attr('width', width);
    svg.attr('height', height);
    Promise.all([
        d3.json('/assets/states-and-regions.json'),
    ]).then(([json]) => {
        var projection = d3.geoEquirectangular().fitSize([width, height], json)
        var path = d3.geoPath().projection(projection);

        const g = d3.select('#map g.map');
        g.selectAll('path')
            .data(json.features)
            .enter()
            .append('path')
            .attr('d', (d) => {
                return path(d)
            })
            .style("fill", "#e3e3e3")
            .style("stroke-width", "1")
            .style("stroke", "#313131");
    });


}
onMounted(() => {
    init()

    let prevRatio = 0.0;

    const intersectionCallback = (entries) => {
        entries.forEach((entry) => {
            prevRatio = entry.intersectionRatio;
            console.log(entry, entry.intersectionRatio)
        });
    }
    let container = document.getElementById('container')
    let divs = container.querySelectorAll('.trigger');
    let triggers = [
        {
            targets: divs[0],
            backgroundColor: '#000',
            scrollTrigger: {
                trigger: divs[0],
                start: 'top 3%',
                end: 'bottom 30%',
            }
        },
        {
            targets: divs[1],
            backgroundColor: '#a993ff',
            scrollTrigger: {
                trigger: divs[1],
                start: 'top 40%',
                end: 'bottom center'
            }
        },
        {
            targets: divs[2],
            backgroundColor: '#02cdf1',
            scrollTrigger: {
                trigger: divs[2],
                start: 'top 60%',
                end: 'bottom 80%',
            }
        }
    ]

    function getScrollOffset(position) {
        if (position.includes('%')) return parseInt(position.substring(0, position.length - 1)) / 100;
        if (parseInt(position)) return parseInt(position);
        switch (position) {
            case 'top' :
                return 0;
            case 'bottom':
                return 1;
            case 'center':
                return 0.5;
            default:
                return null;
        }
    }

    function createMarker(height, width, color, top, right = null, position = 'absolute') {
        let marker = document.createElement('div');
        marker.style.height = height;
        marker.style.width = width;
        marker.style.backgroundColor = color;
        marker.style.position = position;
        marker.style.top = top;
        if (right) marker.style.right = right;
        return marker;
    }

    let scrollTrigger = (element, triggers) => {
        triggers.forEach((trigger) => {
            trigger.animations = {};
            trigger.hasTriggered = false;
            trigger.isTriggering = false;
            trigger.isActive = false;
            trigger.scrollTrigger.actions ??= 'play none none reset';
            trigger.scrollTrigger.actions = trigger.scrollTrigger.actions.split(' ');
            if (trigger.scrollTrigger.actions.length < 4) {
                throw new Error('Actions attribute should have four values. e.g, "play none none none"');
            }
            Object.keys(trigger).forEach((key) => {
                if (!['targets', 'scrollTrigger', 'animations'].includes(key)) {
                    trigger.animations[key] = trigger[key]
                }
            })
            trigger.anime = anime({
                targets: trigger.targets,
                ...trigger.animations,
                autoplay: false,
                begin: (_) => {
                    trigger.isTriggering = true;
                },
            })

            const triggerAction = (action) => {
                // console.log(action)
                switch (action) {
                    case 'play':
                        if (trigger.anime.reversed) trigger.anime.reverse();
                        return trigger.anime.play();
                    case 'pause':
                        return trigger.anime.pause();
                    case 'reverse':
                        if (!trigger.anime.reversed) trigger.anime.reverse();
                        return trigger.anime.play();
                    case 'restart':
                        if (trigger.anime.reversed) trigger.anime.reverse()
                        return trigger.anime.restart();
                    case 'reset':
                        if (trigger.anime.reversed) trigger.anime.reverse();
                        return trigger.anime.reset();
                    default:
                        return null;
                }
            }

            trigger._onEnter = (a) => {
                console.log('enter')
                if (trigger.scrollTrigger.onEnter) trigger.scrollTrigger.onEnter(a);
                triggerAction(trigger.scrollTrigger.actions[0])
            }
            trigger._onLeave = (a) => {
                console.log('leave')
                if (trigger.scrollTrigger.onLeave) trigger.scrollTrigger.onLeave(a);
                triggerAction(trigger.scrollTrigger.actions[1])
            }

            trigger._onEnterBack = (a) => {
                console.log('enter back')
                if (trigger.scrollTrigger.onEnterBack) trigger.scrollTrigger.onEnterBack(a);
                triggerAction(trigger.scrollTrigger.actions[2])
            }
            trigger._onLeaveBack = (a) => {
                console.log('leave back')
                if (trigger.scrollTrigger.onLeaveBack) trigger.scrollTrigger.onLeaveBack(a);
                triggerAction(trigger.scrollTrigger.actions[3])
            }

            let triggerRect = trigger.scrollTrigger.trigger.getBoundingClientRect();
            // start trigger offset and scroll offset
            let start = trigger.scrollTrigger.start ?? 'top center';
            start = start.split(' ');
            if (start.length < 2) {
                throw new Error('Start must be in the format of "triggerOffset scrollOffset"')
            }
            trigger.startTriggerOffset = triggerRect.top + triggerRect.height * getScrollOffset(start[0]);
            trigger.startScrollPosition = start[1];
            let end = trigger.scrollTrigger.end ?? 'bottom center';
            end = end.split(' ');
            if (end.length < 2) {
                throw new Error('end must be in the format of "triggerOffset scrollOffset"')
            }
            trigger.endScrollPosition = end[1];
            trigger.endTriggerOffset = triggerRect.top + triggerRect.height * getScrollOffset(end[0]);


            // debug offsets
            if (trigger.scrollTrigger.debug) {
                element.style.position = 'relative';
                trigger.scrollTrigger.startOffsetMarker = createMarker('5px', '20px', '#ff4949', trigger.startTriggerOffset + 'px');
                trigger.scrollTrigger.endOffsetMarker = createMarker('5px', '20px', '#49deff', trigger.endTriggerOffset + 'px');
                trigger.scrollTrigger.trigger.appendChild(trigger.scrollTrigger.startOffsetMarker)
                trigger.scrollTrigger.trigger.appendChild(trigger.scrollTrigger.endOffsetMarker)
                trigger.scrollTrigger.startScrollerOffsetMarker = createMarker('5px', '24px', '#ff4949', element.clientHeight * getScrollOffset(trigger.startScrollPosition) + 'px', '0px', 'absolute');
                trigger.scrollTrigger.endScrollerOffsetMarker = createMarker('5px', '24px', '#49deff', element.clientHeight * getScrollOffset(trigger.endScrollPosition) + 'px', '0px', 'absolute');
                trigger.scrollTrigger.trigger.appendChild(trigger.scrollTrigger.startScrollerOffsetMarker)
                trigger.scrollTrigger.trigger.appendChild(trigger.scrollTrigger.endScrollerOffsetMarker)
            }
        })
        let currentScroll = 0;
        let isVerticalScrolling = false;
        element.addEventListener('scroll', (e) => {
            isVerticalScrolling = element.scrollTop > currentScroll;
            currentScroll = element.scrollTop;
            triggers.forEach((trigger) => {
                let startScrollerOffset = element.scrollTop + element.clientHeight * getScrollOffset(trigger.startScrollPosition);
                let endScrollerOffset = element.scrollTop + element.clientHeight * getScrollOffset(trigger.endScrollPosition);
                if (trigger.scrollTrigger.debug) {
                    trigger.scrollTrigger.startScrollerOffsetMarker.style.top = startScrollerOffset + 'px';
                    trigger.scrollTrigger.endScrollerOffsetMarker.style.top = endScrollerOffset + 'px';
                }
                // console.log([startScrollerOffset, endScrollerOffset], [trigger.startTriggerOffset, trigger.endTriggerOffset], trigger.isActive)
                if (startScrollerOffset >= trigger.startTriggerOffset && !trigger.isActive && endScrollerOffset < trigger.endTriggerOffset) {
                    isVerticalScrolling ? trigger._onEnter(trigger) : trigger._onEnterBack(trigger);
                    trigger.isActive = true
                    return;
                }
                if (endScrollerOffset >= trigger.endTriggerOffset && trigger.isActive) {
                    trigger._onLeave(trigger);
                    trigger.isActive = false;
                    return;
                }

                if (startScrollerOffset < trigger.startTriggerOffset && trigger.isActive) {
                    trigger.isActive = false;
                    trigger._onLeaveBack(trigger)
                }

            })
        })
    }

    scrollTrigger(container, triggers);
})

</script>

<style scoped>

</style>
