<template>
    <div id="disinformation" class="w-full p-4 md:p-12 flex-col items-center flex relative">
        <div class="w-11/12 md:!w-7/12 flex flex-col gap-y-4 items-center md:!text-center h-screen justify-center">
            <h1 class="font-semibold text-3xl mb-4">Title</h1>
            <p class="tracking-wider leading-relaxed text-gray-700">Lorem Ipsum is simply dummy text of the printing and
                typesetting
                industry. Lorem
                Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                leap
                into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                the
                release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        </div>
        <div
            class="w-full md:!w-10/12 2xl:!w-9/12 flex items-center justify-center z-10 h-screen sticky top-16 md:top-24"
            id="disinformation-container">
        </div>
        <div class="flex flex-col relative w-full items-center" id="disinformation-trigger">
            <div
                class="disinformation-content-box z-10 my-64 w-full md:!w-6/12 text-gray-900 p-6 md:p-12 flex flex-col items-center rounded bg-[#65958A]"
                v-for="(i,index) in [1,2,3,4,5]">
                <h1 class="font-semibold text-2xl mb-6"> Hey {{ i }}</h1>
                <p class="tracking-wider leading-relaxed text-md">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting
                    industry. Lorem
                    Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and
                    scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap
                    into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                    the
                    release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                    publishing
                    software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>
            </div>
        </div>
        <div id="disinformation-detail-viewer"
             class="fixed -translate-x-full bg-white gap-y-4 overflow-y-auto flex flex-col py-8 px-6 shadow-2xl left-0 top-0 z-[1000] border border-gray-300 w-[80vw] md:!w-[40vw] 2xl:!w-[30vw]"
             :style="{height: height+'px'}">
            <!--            <button @click="toggleDetailViewerVisibility" class="outline-none self-end">-->
            <!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
            <!--                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
            <!--                     class="lucide w-8 h-8 lucide-x-circle">-->
            <!--                    <circle cx="12" cy="12" r="10"/>-->
            <!--                    <path d="m15 9-6 6"/>-->
            <!--                    <path d="m9 9 6 6"/>-->
            <!--                </svg>-->
            <!--            </button>-->
            <div class="flex items-center w-full gap-x-2">
                <h1 class="font-semibold w-8/12 truncate overflow-hidden text-xl">{{ data.username ?? data.id }}</h1>
                <span class="text-sm px-2 py-1 text-white rounded"
                      :class="data.type === 'page' ? 'bg-blue-400': 'bg-red-400'">{{ data.type }}</span>
            </div>
            <div class="p-4 rounded border border-2 my-2 bg-gray-100 flex flex-col" v-for="content in data.contents">
                <a target="_blank" :href="content.url"
                   class="font-semibold text-blue-400 underline text-lg">{{ content.title }}</a>
                <h2 class="text-gray-500">Fact checked on {{ content.date }}</h2>
                <div class="flex flex-wrap gap-2 mt-2">
                    <button class="text-sm px-2 py-1 text-white rounded bg-gray-400"
                            @click="visualization.highlight('fact_checkers',content.fact_checker)">
                        Fact checked by: {{ content.fact_checker }}
                    </button>
                    <button class="text-sm px-2 py-1 text-white rounded bg-gray-400"
                            @click="visualization.highlight('topics',content.topic)">
                        Topic: {{ content.topic }}
                    </button>
                </div>
            </div>
            <button @click="toggleDetailViewerVisibility"
                    class="px-4 py-2 rounded justify-self-end bg-gray-700 text-white border self-end w-5/12">
                Close
            </button>
        </div>
    </div>
</template>

<script setup>
import {onMounted, reactive} from "vue";
import * as d3 from 'd3';
import {PopOver} from "vue-common-components";
import AnimeScrollTrigger from 'anime-scrolltrigger';
import anime from "animejs";
import {onClickOutside} from "js-utils";

const props = defineProps([]);

let disinformationData = [];

const height = window.innerHeight

const data = reactive({
    contents: [],
    type: null,
    username: null,
    id: null,
});

let showViewer = false;
let currentHighlightAttribute, currentHighlightValue = null;

const toggleDetailViewerVisibility = () => {
    anime({
        targets: '#disinformation-detail-viewer',
        translateX: showViewer ? ['0%', '-100%'] : ['-100%', '0%'],
        easing: 'easeOutQuart',
        duration: 600,
    })
    showViewer = !showViewer;
}

const visualization = {
    data: [],
    settings: {
        svg: null,
        total: null,
        radius: window.innerWidth > 768 ? 12 : 8,
        gap: 5,
        width: null,
        height: null,
        columns: null,
        margin: {
            top: 20,
            right: 0,
            bottom: 30,
            left: 0,
        }
    },
    init: function (container) {
        this.settings.total = Object.keys(this.data).length;

        // Declare the chart dimensions and margins.
        this.settings.width = container.getBoundingClientRect().width;
        this.settings.height = container.getBoundingClientRect().height;

        this.settings.svg = d3.create("svg")
            .attr("width", this.settings.width + this.settings.margin.left + this.settings.margin.right)
            .attr("height", this.settings.height + this.settings.margin.top + this.settings.margin.bottom)
            .attr("viewBox", [0, 0, this.settings.width, this.settings.height])
            .attr("style", "max-width: 100%; height: auto;")
            .attr('id', 'disinformation-viewer')

        const approximateWidthInARow = this.settings.radius * 2 + this.settings.gap;
        this.settings.columns = Math.round(this.settings.width / approximateWidthInARow);
        const extraSpace = this.settings.width - (approximateWidthInARow * this.settings.columns)
        let color = d3.interpolateRgb("purple", "orange")

        let rowIndex = 0;
        let currentItemIndex = 0;
        let maxCount = this.data[0].count;
        do {
            for (let j = 0; j < this.settings.columns; j++) {
                let currentItem = this.data[currentItemIndex];
                this.settings.svg.append('circle')
                    .attr('r', this.settings.radius)
                    .attr('stroke', 'black')
                    .attr('id', currentItem.id)
                    .attr('data-count', currentItem.count)
                    .attr('data-topics', [...new Set(currentItem.contents.map((content) => content.topic))].join(', '))
                    .attr('data-fact_checkers', [...new Set(currentItem.contents.map((content) => content.fact_checker))].join(', '))
                    .attr('data-cy', Math.floor(currentItemIndex / this.settings.columns) * this.settings.radius * 2 + Math.floor(currentItemIndex / this.settings.columns) * this.settings.gap + this.settings.margin.top)
                    .attr('fill', color(currentItem.count / maxCount))
                    .attr('cx', (j * this.settings.radius * 2) + extraSpace * .5 + this.settings.radius + j * this.settings.gap)
                    .attr('cy', this.settings.height)
                    .style('opacity', 0)
                    .style('cursor', 'pointer')
                    .on('click', () => {
                        data.contents = currentItem.contents;
                        data.id = currentItem.id;
                        data.type = currentItem.type;
                        if (!showViewer) {
                            setTimeout(() => {
                                toggleDetailViewerVisibility();
                            }, 100)
                        }
                    });
                currentItemIndex++;
                if (currentItemIndex === this.settings.total) {
                    break;
                }
            }
            if (currentItemIndex === this.settings.total) {
                break;
            }
            rowIndex++;
        } while (true)
        container.append(this.settings.svg.node());
        this.start();
    },
    start: function () {
        // return;
        this.settings.svg.selectAll('circle')
            .transition()
            .duration(200)
            .delay((_, i) => Math.floor(i / this.settings.columns) * 100)
            .style('opacity', 1)
            .attr('cy', function () {
                return d3.select(this).attr('data-cy')
                // return (Math.floor(i / this.settings.columns) * this.settings.radius * 2) + Math.floor(i / this.settings.columns) * this.settings.gap + this.settings.margin.top
            })
            .easeVarying((_) => d3.easeExpOut)
    },
    reverse: function () {
        this.settings.svg.selectAll('circle')
            .transition()
            .duration(200)
            .delay((_, i) => Math.floor((this.settings.total - i) / this.settings.columns) * 100)
            .style('opacity', 0)
            .attr('cy', () => this.settings.height)
            .easeVarying((_) => d3.easeExpIn)
    },
    highlight: function (attribute, value) {
        // need to reset because if it is already filtered, there is a bug where it selects all circles
        this.resetHighlight();
        value = value.toString()
        this.settings.svg.selectAll('circle')
            .filter(function () {
                let data = d3.select(this).node().dataset[attribute];
                return !(data.includes(value) || data === value);
            })
            .attr('cy', function (_, i) {
                return d3.select(this).attr('data-cy')
                // return (Math.floor(i / this.settings.columns) * this.settings.radius * 2) + Math.floor(i / this.settings.columns) * this.settings.gap + this.settings.margin.top
            })
            .transition()
            .duration(500)
            .delay((_, i) => Math.max(i * 1, 50))
            .style('opacity', 0.4).easeVarying((_) => d3.easeExpIn)
    },
    resetHighlight: function () {
        this.settings.svg.selectAll('circle')
            .attr('cy', function () {
                return d3.select(this).attr('data-cy')
            })
            .transition()
            .duration(500)
            .delay((_, i) => Math.max(i * 1, 50))
            .style('opacity', 1)
            .easeVarying((_) => d3.easeExpIn)
    },
}

fetch('assets/data/disinformation.json').then(async (res) => {
    visualization.data = await res.json();
})

onMounted(() => {
    onClickOutside(document.getElementById('disinformation-detail-viewer'), (e) => {
        if (showViewer && e.target.tagName !== 'circle') {
            toggleDetailViewerVisibility();
            if (currentHighlightAttribute && currentHighlightValue) {
                visualization.highlight(currentHighlightAttribute, currentHighlightValue)
            } else {
                visualization.resetHighlight();
            }
        }
    })
    let main = document.querySelector('main');
    let disinformationContainer = document.getElementById('disinformation-container');
    let animations = [{
        scrollTrigger: {
            trigger: disinformationContainer,
            start: 'top center',
            end: 'bottom bottom',
            onEnter: () => {
                if (!visualization.settings.svg) {
                    visualization.init(disinformationContainer)
                }
                visualization.start()
            },
            onLeaveBack: () => {
                visualization.reverse();
                currentHighlightAttribute = null;
                currentHighlightValue = null;
            }
        }
    }];
    // initialise highlight triggers.
    let highlights = [1, 7, null, 1, null]
    let disinformationContentBoxes = document.querySelectorAll('.disinformation-content-box');
    disinformationContentBoxes.forEach((box, index) => {
        animations.push({
            scrollTrigger: {
                trigger: box,
                start: 'top center',
                end: 'bottom 30%',
                onEnter: () => {
                    let highlightCount = highlights[index];
                    if (!highlightCount) {
                        visualization.resetHighlight()
                        return;
                    }
                    currentHighlightAttribute = 'count';
                    currentHighlightValue = highlightCount;
                    visualization.highlight('count', highlightCount)
                },
                onEnterBack: () => {
                    let highlightCount = highlights[index];
                    if (!highlightCount) {
                        visualization.resetHighlight()
                        return;
                    }
                    currentHighlightAttribute = 'count';
                    currentHighlightValue = highlightCount;
                    visualization.highlight('count', highlightCount)
                }
            }
        })
    })
    // setTimeout(() => {
    new AnimeScrollTrigger(main, animations)
    // }, 2000)
})
</script>

<style scoped>

</style>
