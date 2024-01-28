<template>
    <div id="protests"
         class="w-full md:!w-10/12 flex md:!flex-row flex-col items-center md:!items-start relative justify-evenly">
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
                    <span class="text-sm">Unknown People</span>
                </div>
                <div class="w-10/12 md:!w-7/12 h-4 bg-gradient-to-r from-[#084CFB] to-[#F99500]"></div>
                <div class="w-10/12 md:!w-7/12 flex justify-between text-sm font-medium text-gray-700">
                    <p>1 person</p>
                    <p>3000 people</p>
                </div>
            </div>
        </div>
        <div id="protest-detail"
             class="fixed border-gray-800 z-[10000] bg-[#fab3a2] p-4 rounded border"
             v-show="data.hoverTownship">
            <h1 class="font-semibold text-lg border-b border-black">{{ data.details.title }}</h1>
            <table>
                <tbody>
                <tr class=" flex items-center text-sm"
                    v-for="content in data.details.contents">
                    <td class="p-2 w-6/12" v-for="(c,i) in content">{{ c }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="w-11/12 md:w-1/2 py-10 gap-y-24 flex flex-col ">
            <div class="protest-map-trigger mb-[90%] md:!mb-[50%] w-full rounded-lg h-[50vh] md:!h-screen"></div>
            <div class="mb-[90%] p-4 md:!p-10 z-10 md:!mb-[50%] w-full border rounded bg-white">
                Starting with the protest from the Union Solidarity and Development Party (USDP) supporters outside the
                Hlegu Union Election Commission on November 10, 2020, Myanmar witnessed a chain reaction of dissent that
                swept through the nation. Fueled by claims of election irregularities and simmering frustration with the
                outcome, the initial spark in Hlegu ignited a nationwide wave of demonstrations (some protested for
                unknown reasons, thus not all of them would give rise to the coup). Most of those protests, demanding
                accountability and transparency, would ultimately culminate in a military coup, dramatically altering
                the country's trajectory.
            </div>
            <div class="mb-[90%] p-4 md:!p-10 z-10 md:!mb-[50%] w-full border rounded bg-white relative">
                While Yangon and Naypyidaw became the flashpoints, the spirit of dissent quickly spread, igniting over
                87 protests across the nation. Fueled by allegations of election fraud and a deep-seated frustration
                with the results, these demonstrations drew a diverse spectrum of participants. USDP supporters,
                emboldened by their initial spark in Helgu, marched alongside pro-military groups, while a wave of
                saffron-robed monks added their voices to the call for transparency and accountability. The sheer
                number, exceeding 20,000 individuals, showcased the depth of public discontent and the growing momentum
                of the movement, foreshadowing the dramatic events that would soon unfold.

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
import {Carbon} from "js-utils";

const height = window.innerHeight;
const props = defineProps([]);

let protests = [];

const data = reactive({
    hoverTownship: null,
    details: {
        title: '',
        contents: [],
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

data.currentDateRange = `from ${(new Carbon(startDate)).toHumanReadable()} to ${(new Carbon(endDate)).toHumanReadable()}`

const init = () => {
    const svg = d3.select('svg#protests-map');
    const width = svg.node().getBoundingClientRect().width;
    const height = svg.node().getBoundingClientRect().height;
    svg.attr('width', width);
    svg.attr('height', height);
    d3.json('assets/states-and-regions.json').then((all) => {
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
    let _startDateClone = new Date(startDate)
    _startDateClone.setDate(_startDateClone.getDate() - 1)
    let protestsBetween = protests.filter((protest) => {
        let date = new Date(protest.date)
        return date >= _startDateClone && date <= endDate
    })

    const onClick = (e, d) => {
        let hoverTownship = d.date + d.township;
        if (hoverTownship === data.hoverTownship) {
            return;
        }
        data.details.contents = [];
        data.details.title = d.township + ` (${d.date})`

        data.details.contents.push(['Number of People', d.numberOfPeople !== 'NA' ? `Approximately ${d.numberOfPeople}` : 'Unknown'])

        let affiliations = [];
        Object.keys(d).filter((t) => /^affiliation/.test(t)).forEach((affiliation) => {
            if (!affiliations.includes(d[affiliation])) {
                affiliations.push(d[affiliation]);
            }
        })

        data.details.contents.push(['Affiliations', affiliations.join(', ')])


        data.details.contents.push(['Place', d.place])
        data.hoverTownship = hoverTownship;
        detailBox.style.top = e.clientY + 'px';
        detailBox.style.left = e.clientX + 'px';
        detailBox.style.opacity = 0;
        setTimeout(() => {
            placeElementRelativeToScreen(detailBox).then((element) => {
                element.style.opacity = 1;
            });
        }, 100)
    }

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

            e.on('touchstart', onClick)
            e.on('mouseover', onClick)
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
            ])[1]),
        exit => exit.attr('r', 0)
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
                        data.currentDateRange = `from ${(new Carbon(startDateClone)).toHumanReadable()} to ${(new Carbon(endDate)).toHumanReadable()}`
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
