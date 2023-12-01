<template>
    <div id="container" class="w-10/12 flex py-10 relative justify-evenly">
        <div class="w-4/12 h-[90vh] sticky top-0 left-0 flex flex-col items-center overflow-hidden">
            <svg id="map">
                <g class="map" fill="#b3b3b3" stroke="black" stroke-width="0.01"></g>
                <g class="details" fill="orange" stroke="black" stroke-width="0.01"></g>
            </svg>
            <div class="flex flex-col absolute bottom-0 left-0 gap-y-4">
                <button class="w-48 h-12 rounded border bg-amber-300"></button>
                <button class="w-48 h-12 rounded border bg-blue-300"></button>
            </div>
        </div>
        <div class="w-1/2 gap-y-24 flex flex-col z-10">
            <div class="trigger w-full border rounded bg-gray-200 h-[40vh]"></div>
            <div class="trigger w-full border rounded bg-gray-200 h-[40vh] relative">
                <button @click="data.showChart = true"
                        class="rounded-full absolute top-4 left-4 w-12 h-12 bg-pink-300"></button>
            </div>
            <div class="trigger w-full border rounded bg-gray-200 h-[40vh]"></div>
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

let zoomIntoRegion, resetZoom;

const data = reactive({
    showChart: false,
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
                .attr('d', (d) => {
                    return path(d)
                })
                .style("fill", "#e3e3e3")
                .style("stroke-width", "1");
        }

        g.selectAll('path')
            .data(all.features)
            .enter()
            .append('path')
            .attr('d', (d) => {
                return path(d)
            })
            .style("fill", "#e3e3e3")
            .style("stroke-width", "1")
            .style("stroke", "#313131")
            .on('click', (e, d) => {
                zoomIntoRegion(d.properties.ST)
            });
    });


}
onMounted(() => {
    init()
    let container = document.getElementById('container')
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
    ]


    new AnimeScrollTrigger(document.querySelector('main'), triggers);
})

</script>

<style scoped>

</style>
