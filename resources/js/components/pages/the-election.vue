<template>
    <svg id="map" height="560" width="340">
        <g class="map" fill="#b3b3b3" stroke="black" stroke-width="0.01"></g>
        <g class="details" fill="orange" stroke="black" stroke-width="0.01"></g>
    </svg>
</template>

<script setup>
import {onMounted, reactive} from 'vue';
import * as d3 from 'd3';

const data = reactive({});
const init = ()=>{
    const svg = d3.select('svg#map');
    const width = +svg.attr('width');
    const height = +svg.attr('height');
    const options = {
        x: -7.92 * width,
        y: height + 290,
        scale: 1700,
    };
    Promise.all([
        d3.json( '/assets/states-and-regions.json'),
    ]).then(([json]) => {

        var projection = d3.geoEquirectangular().scale(options.scale).translate([options.x,options.y]);
        var path = d3.geoPath().projection(projection);

        const g = d3.select('#map g.map');
        g.selectAll('path')
            .data(json.features)
            .enter()
            .append('path')
            .attr('d',(d)=>{
                return path(d)})
            .style("fill", "gray")
            .style("stroke-width", "1")
            .style("stroke", "black");
    });
}
onMounted(()=>{
  init()
})
</script>

<style scoped>

</style>
