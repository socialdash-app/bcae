<template>
    <div id="disinformation" class="w-full p-12 flex-col items-center flex relative">
        <div class="w-7/12 flex flex-col gap-y-4 items-center text-center h-screen justify-center">
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
        <div class="w-10/12 h-screen sticky top-24" id="disinformation-container">
        </div>
        <div class="flex flex-col relative w-full items-center" id="disinformation-trigger">
            <div
                class="disinformation-content-box z-10 my-64 w-6/12 text-gray-900 p-12 flex flex-col items-center rounded bg-[#65958A]"
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
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import * as d3 from 'd3';
import AnimeScrollTrigger from 'anime-scrolltrigger';

const props = defineProps([]);

let disinformationData = [];

const data = reactive({});

const visualization = {
    data: [],
    settings: {
        svg: null,
        total: null,
        radius: 12,
        gap: 5,
        width: null,
        height: null,
        columns: null,
        margin: {
            top: 20,
            right: 30,
            bottom: 30,
            left: 40,
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

        const approximateCircleWidth = 12 * 2 + this.settings.gap + 1;
        this.settings.columns = Math.round(this.settings.width / approximateCircleWidth);
        let color = d3.interpolateRgb("purple", "orange")

        let rowIndex = 0;
        let currentItemIndex = 0;
        let maxCount = this.data[0].count;
        do {
            for (let j = 0; j < this.settings.columns; j++) {
                let currentItem = this.data[currentItemIndex];
                currentItemIndex++;
                this.settings.svg.append('circle')
                    .attr('r', this.settings.radius)
                    .attr('stroke', 'black')
                    .attr('data-count', currentItem.count)
                    .attr('fill', color(currentItem.count / maxCount))
                    .attr('cx', (j * this.settings.radius * 2) + this.settings.margin.left + j * this.settings.gap)
                    .attr('cy', this.settings.height)
                    .style('opacity', 0);
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
            .attr('cy', (_, i) => {
                return (Math.floor(i / this.settings.columns) * this.settings.radius * 2) + Math.floor(i / this.settings.columns) * this.settings.gap + this.settings.margin.top
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
    highlightCount: function (count) {
        count = count.toString()
        this.settings.svg.selectAll('circle').filter(function () {
            return d3.select(this).attr('data-count') !== count;
        }).transition().duration(500)
            .delay((_, i) => Math.max(i * 1, 50))
            .style('opacity', 0.4).easeVarying((_) => d3.easeExpIn)
    },
    resetHighlight: function () {
        this.settings.svg.selectAll('circle')
            .transition()
            .duration(500)
            .delay((_, i) => Math.max(i * 1, 50))
            .style('opacity', 1)
            .easeVarying((_) => d3.easeExpIn)
    },
}

axios.post('/correlated-actions/disinformation').then((res) => {
    Object.keys(res.data.validPropagandists).forEach((propagandist) => {
        visualization.data.push({
            id: propagandist,
            count: res.data.validPropagandists[propagandist].length,
            contents: res.data.validPropagandists[propagandist],
        })
    });
    visualization.data.sort((a, b) => a.count >= b.count ? -1 : 1) // sort descending
})

onMounted(() => {
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
            }
        }
    }];
    let highlights = [7, 3, null, 1, null]
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
                    visualization.highlightCount(highlightCount)
                },
                onEnterBack: () => {
                    let highlightCount = highlights[index];
                    if (!highlightCount) {
                        visualization.resetHighlight()
                        return;
                    }
                    visualization.highlightCount(highlightCount)
                }
            }
        })
    })
    setTimeout(() => {
        new AnimeScrollTrigger(main, animations)
    }, 2000)
})
</script>

<style scoped>

</style>
