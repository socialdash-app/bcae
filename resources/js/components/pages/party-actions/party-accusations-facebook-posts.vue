<template>
    <div class="w-7/12 py-10 h-screen relative flex-col flex items-center justify-center">
        <h1 class="font-semibold text-2xl mb-4">Parties post election complaints on Facebook</h1>
        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore
            magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
        <div id="party-accusations-facebook-posts" class="w-full md:px-0 px-2 flex h-full items-center justify-center">
        </div>
        <div id="party-accusations-tooltip" style="visibility: hidden; display: none; position: fixed"
             class="border p-2 border-gray-600 w-96 bg-white rounded">

        </div>
    </div>
</template>

<script setup>
import packedbubble from 'highcharts/highcharts-more';

packedbubble(Highcharts);

import {reactive, onMounted} from "vue";
import settings from "../../../api/settings.js";
import {convertHex, placeElementRelativeToScreen} from "../../../api/helpers.js";
import getPartyColor from "../../../api/getPartyColor.js";
import * as d3 from "d3";
import truncate from "../../../api/truncate.js";

const props = defineProps([]);

let isHovering = false;

const init = (data) => {
    let container = document.getElementById('party-accusations-facebook-posts');

    const tooltip = d3.select('#party-accusations-tooltip');

    const width = container.getBoundingClientRect().width;
    const height = container.getBoundingClientRect().height;

    let margin = {
        left: 10,
        right: 10,
        top: 10,
        bottom: 10,
    }

    const svg = d3.create("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .attr("viewBox", [0, 0, width, height])
        .attr("style", "max-width: 100%; height: auto;")
    // Give the data to this cluster layout:
    var root = d3.hierarchy(data).sum(function (d) {
        return d.value
    }) // Here the size of each leave is given in the 'value' field in input data
    // Then d3.treemap computes the position of each element of the hierarchy
    d3.treemap()
        .size([width, height])
        .padding(2)
        (root)

    svg.on('mousemove', function (e) {
        if (e.target.tagName !== 'rect' && isHovering) {
            tooltip.style('display', 'none')
                .style('visibility', 'hidden')
            isHovering = false;
        }
    })
    // use this information to add rectangles:
    svg
        .selectAll("rect")
        .data(root.leaves())
        .enter()
        .append("rect")
        .attr('x', function (d) {
            return d.x0;
        })
        .attr('y', function (d) {
            return d.y0;
        })
        .attr('width', function (d) {
            return d.x1 - d.x0;
        })
        .attr('height', function (d) {
            return d.y1 - d.y0;
        })
        .style("stroke", "black")
        .style("fill", function (d) {
            return d.data.color
        })
        .style('cursor', 'pointer')
        .on('mouseenter', function (e, d) {
            tooltip
                .text(truncate(d.data.message, 100))
                .style('display', 'initial')
                .style('top', e.clientY + 'px')
                .style('left', e.clientX + 'px')

            placeElementRelativeToScreen(tooltip.node(), true).then(() => {
                tooltip.style('visibility', 'initial')
                isHovering = true;
            })
        })

    svg
        .selectAll(".titles")
        .data(root.descendants().filter(function (d) {
            return d.depth == 1
        }))
        .enter()
        .append("foreignObject")
        .style('pointer-events', 'none')
        .attr("x", function (d) {
            return d.x0 + 5;
        })
        .attr("y", function (d) {
            return d.y0 + 5;
        })
        .attr('width', function (d) {
            return d.x1 - d.x0;
        })
        .attr('height', function (d) {
            return d.y1 - d.y0;
        })
        .append('xhtml:div')
        .style("font-size", (d) => {
            let height = d.y1 - d.y0;
            return height > 100 ? '15px' : '10px';
        })
        .style("color", 'white')
        .text(function (d) {
            return d.data.name
        })


    container.append(svg.node());
}

onMounted(() => {
    fetch('assets/data/party-accusations-fb-posts.json').then(async (res) => {
        let data = await res.json();
        let formattedData = {
            name: 'root',
            children: [],
        };
        Object.keys(data).forEach((party) => {
            console.log(party)
            let color = getPartyColor(party);
            let d = data[party].map((datum) => {
                datum.value = 1;
                datum.color = color;
                return datum;
            })
            formattedData.children.push({
                name: party,
                children: d,
                color: color,
            })
        })
        init(formattedData)
    })
})
</script>

<style scoped>

</style>
