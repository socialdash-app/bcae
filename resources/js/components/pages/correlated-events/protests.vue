<template>
    <div id="protests" class="w-10/12 flex md:!flex-row flex-col items-center md:!items-start relative justify-evenly">
        <div id="protests-map-container"
             :style="{height: height * 0.90 - 24 + 'px'}"
             class="w-11/12 pb-12 md:pb-0 md:w-5/12 sticky top-24 flex flex-col items-center overflow-hidden">
            <svg id="protests-map" class="w-full h-full">
                <g class="map" fill="#b3b3b3" stroke="black" stroke-width="0.01"></g>
                <g class="protests" fill="orange" stroke="black" stroke-width="0.01"></g>
            </svg>
            <div v-show="!data.loading"
                 class="flex flex-col absolute bottom-4 left-0 gap-y-4">
                <p>{{ data.currentDateRange }}</p>
                <div class="flex gap-x-2 items-center">
                    <span class="w-4 h-4 bg-black rounded-full"></span>
                    <span>Unknown People</span>
                </div>
                <div class="w-64 h-4 bg-gradient-to-r from-[#084CFB] to-[#F99500]"></div>
                <div class="w-full flex justify-between text-sm font-medium text-gray-700">
                    <p>1 person</p>
                    <p>3000 people</p>
                </div>
            </div>
        </div>
        <div id="protest-detail"
             class="fixed md:!w-[40vw] w-[80vw] border-gray-800 z-[10000] bg-[#fab3a2] p-4 rounded border"
             v-show="data.hoverTownship">
            <h1 class="font-semibold text-lg">{{ data.details.title }}</h1>
            <p> {{ data.details.content }}</p>
        </div>
        <div class="w-11/12 md:w-1/2 py-10 gap-y-24 flex flex-col z-10">
            <div class="protest-map-trigger mb-[90%] md:!mb-[50%] w-full rounded-lg h-[100vh]"></div>
            <div class="mb-[90%] md:!mb-[50%] w-full border rounded bg-white h-[40vh]"></div>
            <div class="mb-[90%] md:!mb-[50%] w-full border rounded bg-white h-[40vh] relative">

            </div>
            <div class="mb-[90%] md:!mb-[50%] w-full h-[40vh] relative">

            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import * as d3 from "d3";
import {PopOver} from "vue-common-components";
import AnimeScrollTrigger from 'anime-scrolltrigger'
import anime from "animejs";
import settings from "../../../api/settings.js";
import {placeElementRelativeToScreen} from "../../../api/helpers.js";

const height = window.innerHeight;
const props = defineProps([]);

let protests = [];

const data = reactive({
    hoverTownship: null,
    details: {
        title: '',
        content: '',
    },
    loading: true,
    currentDateRange: '',
});


let protestPoints = null;
let projection = null;
let colors = null;
let startDate = new Date('2020-11-10');
let endDate = new Date('2021-01-30');
let diffInDays = 5;
let dateIntervals = (() => {
    let start = (new Date(startDate))
    start.setDate(startDate.getDate() - 1);
    let end = (new Date(endDate))
    end.setDate(endDate.getDate() + 1);
    return d3.timeDays(start, end, diffInDays);
})();
let currentIndex = 0;

console.log(dateIntervals)

data.currentDateRange = `from ${startDate.toDateString()} to ${endDate.toDateString()}`

const init = () => {
    const svg = d3.select('svg#protests-map');
    const width = svg.node().getBoundingClientRect().width;
    const height = svg.node().getBoundingClientRect().height;
    svg.attr('width', width);
    svg.attr('height', height);
    Promise.all([
        d3.json('assets/states-and-regions.json'),
    ]).then(([all]) => {
        projection = d3.geoEquirectangular().fitSize([width, height], all)

        svg.on('mousemove', (e, d) => {
            if (e.target === svg.node() && data.hoverTownship) {
                data.hoverTownship = null;
            }
        })

        document.querySelector('main').addEventListener('scroll', () => {
            if (data.hoverTownship) {
                data.hoverTownship = null;
            }
        })
        const path = d3.geoPath().projection(projection);
        const g = svg.select('g.map');
        protestPoints = svg.select('g.protests');
        g.selectAll('path')
            .data(all.features)
            .enter()
            .append('path')
            .attr('d', path)
            .style("fill", "#ffffff")
            .style("stroke-width", "1")
            .style("stroke", "#313131");

        plotPoints(new Date(dateIntervals[0]), new Date(dateIntervals[1]))

        data.loading = false;
    });
}


const plotPoints = (startDate, endDate) => {
    let detailBox = document.getElementById('protest-detail');

    startDate.setDate(startDate.getDate() - 1)
    let protestsBetween = protests.filter((protest) => {
        let date = new Date(protest.date)
        return date >= startDate && date <= endDate
    })
    let points = protestPoints.selectAll('.point').data(protestsBetween);
    points.join(
        enter => {
            let e = enter.append("circle")
                .attr('class', 'point cursor-pointer')
                .attr('fill', (d) => {
                    if (d.numberOfPeople === 'NA') {
                        return '#040404';
                    }
                    return colors(parseInt(d.numberOfPeople));
                })
                .attr("r", 0)
                .attr('cx', d => projection([
                    parseFloat(d.lon), // long
                    parseFloat(d.lat) // lat
                ])[0])
                .attr('cy', d => projection([
                    parseFloat(d.lon), // long
                    parseFloat(d.lat) // lat
                ])[1])
            e.style('cursor', 'pointer')
            e.transition()
                .duration(400)
                .attr('r', 5)

            e.on('touchstart', (e, d) => {
                let hoverTownship = d.date + d.township;
                if (hoverTownship === data.hoverTownship) {
                    return;
                }
                data.details.content = '';
                data.details.title = d.township + ` (${d.date})`

                if (d.numberOfPeople !== 'NA') {
                    data.details.content += `Approximately ${d.numberOfPeople} of `
                }
                data.details.content += `people from `;
                Object.keys(d).filter((t) => /^affiliation/.test(t)).forEach((affiliation) => {
                    if (d[affiliation] !== 'NA') {
                        data.details.content += ` ${d[affiliation]}`
                    }
                })

                data.details.content += ` protested`

                if (d.against !== 'NA') {
                    data.details.content += ` against ${d.against}`
                }

                data.details.content += ` at ${d.place} on ${d.date}`;
                data.hoverTownship = hoverTownship;
                detailBox.style.top = e.clientY + 'px';
                detailBox.style.left = e.clientX + 'px';
                detailBox.style.opacity = 0;
                setTimeout(() => {
                    placeElementRelativeToScreen(detailBox).then((element) => {
                        element.style.opacity = 1;
                    });
                }, 100)
            })
            e.on('mouseover', (e, d) => {
                let hoverTownship = d.date + d.township;
                if (hoverTownship === data.hoverTownship) {
                    return;
                }
                data.details.content = '';
                data.details.title = d.township + ` (${d.date})`

                if (d.numberOfPeople !== 'NA') {
                    data.details.content += `Approximately ${d.numberOfPeople} of `
                }
                data.details.content += `people from `;
                Object.keys(d).filter((t) => /^affiliation/.test(t)).forEach((affiliation) => {
                    if (d[affiliation] !== 'NA') {
                        data.details.content += ` ${d[affiliation]}`
                    }
                })

                data.details.content += ` protested`

                if (d.against !== 'NA') {
                    data.details.content += ` against ${d.against}`
                }

                data.details.content += ` at ${d.place} on ${d.date}`;
                data.hoverTownship = hoverTownship;
                detailBox.style.top = e.clientY + 'px';
                detailBox.style.left = e.clientX + 'px';
                detailBox.style.opacity = 0;
                setTimeout(() => {
                    placeElementRelativeToScreen(detailBox).then((element) => {
                        element.style.opacity = 1;
                    });
                }, 100)
            })
            return e;
        },

        update => update.transition().duration(500).attr('fill', (d) => {
            if (d.numberOfPeople === 'NA') {
                return '#040404';
            }
            return colors(parseInt(d.numberOfPeople));
        }).attr('cx', d => projection([
            parseFloat(d.lon), // long
            parseFloat(d.lat) // lat
        ])[0])
            .attr('cy', d => projection([
                parseFloat(d.lon), // long
                parseFloat(d.lat) // lat
            ])[1])
        ,
        exit => exit.transition().duration(500).attr('r', 0)
    )

    points.exit().transition().duration(400).attr('r', 0).remove();
}

const listenTriggers = () => {
    let container = document.getElementById('protests')
    const mapContainer = document.getElementById('protests-map-container');
    const mapContainerRect = mapContainer.getBoundingClientRect();
    const mapTranslateXWidth = (window.innerWidth * 0.5) - mapContainerRect.left - (0.5 * mapContainerRect.width);
    anime({
        targets: mapContainer,
        translateX: mapTranslateXWidth,
        duration: 0,
    })
    let triggers = [
        {
            scrollTrigger: {
                trigger: '.protest-map-trigger',
                start: 'bottom 60%',
                end: 'bottom -10%',
                debug: true,
                onEnter: () => {
                    anime({
                        targets: mapContainer,
                        translateX: [mapTranslateXWidth, 0],
                        duration: 1500,
                        easing: 'easeOutExpo',
                    })
                },
                onLeaveBack: () => {
                    anime({
                        targets: mapContainer,
                        translateX: [0, mapTranslateXWidth],
                        duration: 1500,
                        easing: 'easeOutExpo',
                    })
                },
            }
        },
        {
            scrollTrigger: {
                trigger: '#protests',
                start: 'top top',
                end: 'bottom bottom',
                lerp: true,
                onUpdate: (_, progress) => {
                    let index = Math.round(progress * (dateIntervals.length - 1));
                    const endDate = dateIntervals[index]
                    const startDateClone = new Date(startDate);
                    if (index !== currentIndex && startDateClone !== endDate) {
                        plotPoints(startDateClone, endDate)
                        currentIndex = index;
                        data.currentDateRange = `from ${startDateClone.toDateString()} to ${endDate.toDateString()}`
                    }

                }
            }
        },
    ];
    new AnimeScrollTrigger(document.querySelector('main'), triggers)
}

onMounted(() => {
    fetch('assets/data/protests.json').then(async (res) => {
        protests = await res.json();
        let range = [d3.min(protests, (protest) => parseInt(protest.numberOfPeople)), d3.max(protests, (protest) => parseInt(protest.numberOfPeople))];
        colors = d3.scaleLinear()
            .domain(range)
            .range(["#084CFB", "#F99500"]);
        setTimeout(() => {
            init();
            listenTriggers()
        }, settings.animationDuration)
    })
})
</script>

<style scoped>

</style>
