<template>
    <div class="w-full md:!w-7/12 py-10 gap-y-4 relative flex-col flex items-center justify-center">
        <h1 class="px-4 md:px-0 font-semibold text-2xl mb-4">The dispute continues on social media
        </h1>
        <p class="px-4 md:px-0 text-gray-700">Many of the political parties that contested the election posted on their
            Facebook pages about the arguments of fraudulence accusations during the election. USDP posted the highest
            number of posts on this topic followed by NLD with mostly defending posts.
        </p>
        <div id="party-accusations-facebook-posts"
             :style="{height: height + 'px'}"
             class="w-full mt-4 md:px-0 px-2 flex items-center justify-center">
        </div>
        <div :class="{'cursor-pointer': rdata.url}" @click="openUrl" id="party-accusations-tooltip"
             style="visibility: hidden; display: none; position: fixed"
             class="border text-sm p-2 border-gray-600 w-96 bg-white rounded">

        </div>
        <div class="shrink-0 w-full h-32 md:!h-[10vh]">

        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import settings from "../../../api/settings.js";
import {convertHex, placeElementRelativeToScreen} from "../../../api/helpers.js";
import getPartyColor from "../../../api/getPartyColor.js";
import * as d3 from "d3";
import truncate from "../../../api/truncate.js";

const props = defineProps([]);

const height = window.innerHeight;

let isHovering = false;

const rdata = reactive({
    url: '',
})

const openUrl = () => {
    if (!rdata.url) return;
    window.open(rdata.url, '_blank')
}

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

    document.querySelector('main').addEventListener('scroll', () => {
        if (isHovering) {
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
                .text(truncate(d.data.message_en ?? d.data.message, 100))
                .style('display', 'initial')
                .style('top', e.clientY + 'px')
                .style('left', e.clientX + 'px')

            rdata.url = d.data.postUrl;

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
        .style("color", (d) => ['#ddeb17', '#fffc1f'].includes(d.data.color) ? 'black' : 'white')
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

<style scoped></style>
