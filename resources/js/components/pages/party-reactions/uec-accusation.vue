<template>
    <div class="w-full py-4 flex-col md:!w-7/12 relative flex items-center justify-center">
                <span
                    class="absolute top-1/2 -left-6 md:text-md text-sm md:-left-12 z-10 -rotate-90 transform -translate-y-full">Complaint</span>
        <span
            class="absolute top-1/2 -right-6 md:text-md text-sm md:-right-12 z-10 -rotate-90 transform -translate-y-full">Defendant</span>
        <h1 class="px-4 md:px-0 font-semibold text-2xl mb-12">Parties and voters sent 287 objection letters to UEC</h1>
        <div :style="{height: height + 'px'}" id="uec-accusations"
             class="w-full md:px-0 px-2 flex items-center justify-center">
        </div>
        <div class="shrink-0 w-full h-[20vh]">

        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import getPartyColor from "../../../api/getPartyColor.js";
import Sankeyy from 'highcharts/modules/sankey';
import Highcharts from 'highcharts'
import * as Sankey from "d3-sankey-circular";
import * as d3 from "d3";
import {headers} from "../../../api/route.js";

Sankeyy(Highcharts);

const height = window.innerHeight;
const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    // axios.post('party-actions/uec-accusations').then((res) => {
    //     let data = [];
    //     let nodes = [];
    //     console.log(res.data)
    //     Object.keys(res.data).forEach((partyName, key) => {
    //         data.push(...res.data[partyName].map((r) => {
    //             let t = {};
    //             t.color = getPartyColor(r.from)
    //             if (nodes.filter((node) => node.name === r.from).length === 0) {
    //                 nodes.push({
    //                     name: r.from,
    //                     color: getPartyColor(r.from)
    //                 })
    //             }
    //             if (nodes.filter((node) => node.name === r.to).length === 0) {
    //                 nodes.push({
    //                     name: r.to,
    //                     color: getPartyColor(r.to)
    //                 })
    //             }
    //             t.source = r.from;
    //             t.target = r.to;
    //             t.value = r.weight.toString();
    //             return t;
    //         }))
    //
    //     })
    //     console.log(JSON.stringify({
    //         links: data,
    //         nodes: nodes,
    //     }))
    // });
    fetch('assets/data/party-reactions/uec-accusations.json').then(async (res) => {
        let data = await res.json();
        let links = [];
        data.links.sort((a, b) => a.value > b.value ? -1 : 1).forEach((link) => {
            link.description = `${link.value} complaints from ${link.source} to ${link.target} `
            if (links.filter((d) => d.source === link.target || d.target === link.source).length !== 0) {
                let temp = link.source;
                link.source = link.target;
                link.target = temp;
            }
            // populate gradient color if it doesn't exist
            link.gradientColors = [getPartyColor(link.source) ?? '#848eff', getPartyColor(link.target) ?? '#848eff'];
            links.push(link)
        })
        // const tooltip = d3.select('#party-accusations-tooltip');

        let container = document.getElementById('uec-accusations')
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
            .attr("style", "max-width: 100%; height: auto; overflow: visible")
        let current = {
            nodes: data.nodes.map(d => Object.assign({}, d)),
            links: links.map(d => Object.assign({}, d))
        };
        const sankey = Sankey.sankeyCircular()
            .nodeId(d => d.name)
            .nodeWidth(36)
            .nodePadding(10)
            .size([width, height])(current)

        var g = svg.append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")

        var linkG = g.append("g")
            .attr("class", "links")
            .attr("fill", "none")
            .selectAll("path");

        var nodeG = g.append("g")
            .attr("class", "nodes")
            .attr("font-family", "sans-serif")
            .attr("font-size", 10)
            .selectAll("g");

        var node = nodeG.data(sankey.nodes)
            .enter()
            .append("g");

        node.append("rect")
            .attr("x", function (d) {
                return d.x0;
            })
            .attr("y", function (d, i) {
                return d.y0;
            })
            .attr("height", function (d) {
                return d.y1 - d.y0;
            })
            .attr("width", function (d) {
                return d.x1 - d.x0;
            })
            .style("fill", function (d) {
                return getPartyColor(d.name) ?? '#848eff';
            })
            .style("opacity", 1)

        node.append("text")
            .attr("x", function (d) {
                return (d.x0 + d.x1) / 2;
            })
            .attr("y", function (d) {
                return d.y0 - 12;
            })
            .attr("dy", "0.35em")
            .attr("text-anchor", "middle")
            .text(function (d) {
                return d.name;
            });
        var link = linkG.data(sankey.links)
            .enter()
            .append("g")
        // .style('transform', (d, i) => `translate(0px,${i * 4}px)`)


        var linearGradient = link.append('linearGradient')
            .attr('id', (d, i) => `gradient-${i}`)
        // .attr('x1', (d) => d.x0)
        // .attr('y1', (d) => d.y1)
        // .attr('x2', (d) => d.x2)
        // .attr('y2', (d) => d.y2)


        linearGradient.append('stop')
            .attr('offset', '0%')
            .attr('style', (d) => `stop-color: ${d.gradientColors[0]};  stop-opacity: 1`)

        linearGradient.append('stop')
            .attr('offset', '100%')
            .attr('style', (d) => `stop-color: ${d.gradientColors[1]};  stop-opacity: 1`)


        link.append("path")
            .attr("class", "sankey-link")
            .attr("d", function (link) {
                return link.path;
            })
            .style("stroke-width", function (d) {

                return Math.max(1, d.width);
            })
            .style("opacity", 0.6)
            .style("stroke", (d, i) => {
                return `url(#gradient-${i})`;
                return getPartyColor(d.source.name) ?? '#848eff';
            })
            .on('mouseover', function (e) {
                d3.select(this).transition().style('opacity', 0.8)
            })
            .on('mouseout', function (e) {
                d3.select(this).transition().style('opacity', 0.6)
            });


        link.append("title")
            .text(function (d) {
                return d.description;
            });
        container.append(svg.node())
    })
    // console.log(data, nodes)

    // })
})
</script>

<style scoped>

</style>
