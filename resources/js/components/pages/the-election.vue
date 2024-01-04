<template>
    <div id="the-election" class="w-full bg-[#F9E2F0] py-10 items-center flex flex-col relative">
        <div class="w-full flex relative justify-evenly">
            <div class="w-4/12 h-[85vh] sticky top-24 left-0 flex flex-col overflow-hidden">
                <svg id="map">
                    <g class="map" fill="#b3b3b3" stroke="black" stroke-width="0.01"></g>
                    <g class="details" fill="orange" stroke="black" stroke-width="0.01"></g>
                </svg>
                <div class="flex flex-col absolute bottom-0 left-0 gap-y-4">
                    <button @click="data.currentHluttaw = 'PyiThu'"
                            class="w-48 h-12 rounded border bg-[#F2B5B4]">Pyithu Hlutaw
                    </button>
                    <button @click="data.currentHluttaw = 'Amyotha'"
                            class="w-48 h-12 rounded border bg-[#F788BF]">Amyotha Hlutaw
                    </button>
                </div>
            </div>
            <div class="w-1/2 gap-y-24 flex flex-col z-10">
                <div class="trigger w-full border rounded-lg bg-[#FFC3E0] h-[40vh]"></div>
                <div class="trigger w-full border rounded-lg bg-[#FFC3E0] h-[40vh] relative">
                    <button @click="data.showChart = true"
                            class="rounded-full absolute top-4 left-4 w-12 h-12 bg-[#F788BF]"></button>
                </div>
                <div class="trigger w-full border rounded-lg bg-[#FFC3E0] h-[40vh]"></div>
            </div>
        </div>
        <pop-over v-show="data.showChart" @click-outside="data.showChart = false">
            <div class="w-[50vw] h-[50vh] rounded bg-white">

            </div>
        </pop-over>
    </div>

</template>

<script setup>
import {onMounted, reactive} from 'vue';
import * as d3 from 'd3';
import {PopOver} from "vue-common-components";
import AnimeScrollTrigger from "anime-scrolltrigger";
import route from "../../api/route.js";

let zoomIntoRegion, resetZoom;

const data = reactive({
    showChart: false,
    currentHluttaw: 'PyiThu',
});
const init = () => {
    const svg = d3.select('svg#map');
    const width = svg.node().parentNode.getBoundingClientRect().width;
    const height = svg.node().parentNode.getBoundingClientRect().height;
    svg.attr('width', width);
    svg.attr('height', height);
    Promise.all([
        d3.json('/assets/states-and-regions.json'),
        d3.json('/assets/subregions.json'),
        d3.json('/assets/amyotha-upperhouse.json'),
    ]).then(([all, subregions, amyothaData]) => {
        var projection = d3.geoEquirectangular().fitSize([width, height], all)
        var path = d3.geoPath().projection(projection);

        let zoom = d3.zoom();

        const g = d3.select('#map g.map');
        const g1 = d3.select('#map g.details');


        zoom.on('zoom', (e) => {
            svg.attr('transform', e.transform)
        })

        resetZoom = () => {
            svg.transition().duration(750).call(zoom.transform,
                d3.zoomIdentity.translate(0, 0).scale(1))
            if (g1.selectAll('null')) {
                g1.selectAll('path').remove();
            }
        }

        svg.on('click', (e, d) => {
            if (e.target === svg.node()) {
                resetZoom();
            }
        })

        zoomIntoRegion = (region) => {
            var features = amyothaData.features.filter((feature) => feature.properties.ST.includes(region));
            let regions = g1.selectAll('null');
            const [[x0, y0], [x1, y1]] = d3.geoBounds({
                type: 'FeatureCollection',
                features: features,
            })
            if (regions) {
                g1.selectAll('path').remove();
            }
            let center = projection(d3.geoCentroid({
                type: 'FeatureCollection',
                features: features,
            }));
            let scale = 1.5;
            svg.transition().duration(750).call(
                zoom.transform,
                d3.zoomIdentity.translate((width / 2 - center[0]) * scale, (height / 2 - center[1]) * scale).scale(scale))
            g1.selectAll('path')
                .data(features)
                .enter()
                .append('path')
                .style('cursor', 'pointer')
                .attr('d', (d) => {
                    return path(d)
                })
                .style("fill", "#ffffff")
                .style("stroke-width", "1");
        }

        g.selectAll('path')
            .data(all.features)
            .enter()
            .append('path')
            .style('cursor', 'pointer')
            .attr('d', (d) => {
                return path(d)
            })
            .style("fill", "#ffffff")
            .style("stroke-width", "1")
            .style("stroke", "#313131")
            .on('click', (e, d) => {
                zoomIntoRegion(d.properties.ST)
            });
    });
}
onMounted(() => {
    setTimeout(() => {
        init()
        let container = document.getElementById('the-election')
        let divs = container.querySelectorAll('.trigger');
        let triggers = [
            {
                targets: divs[1],
                easing: 'linear',
                scrollTrigger: {
                    trigger: divs[1],
                    start: 'top 40%',
                    end: 'bottom center',
                    lerp: true,
                    onEnter: () => {
                        console.log('enter')
                        zoomIntoRegion('Kachin')
                    },
                    onEnterBack: () => console.log('enter back'),
                    onLeaveBack: () => {
                        resetZoom();
                    }
                }
            },
            {
                targets: '#header-the-election circle',
                strokeDashoffset: 0,
                scrollTrigger: {
                    trigger: container,
                    start: 'top top',
                    end: 'bottom top',
                    lerp: true,
                    smooth: true,
                    onEnter: () => {
                        route.changeSectionHeader(1)
                        console.log('enter election')
                    },
                    onEnterBack: () => {
                        route.changeSectionHeader(1)
                        console.log('enter back election');
                    },
                }
            }
        ]


        new AnimeScrollTrigger(document.querySelector('main'), triggers);
    }, 2000)

})

</script>

<style scoped>

</style>
