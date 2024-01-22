<template>
    <div class="w-7/12 h-screen py-10 mt-10 relative flex items-center justify-center">
        <span
            class="absolute top-1/2 -left-6 md:text-md text-sm md:-left-12 z-10 -rotate-90 transform -translate-y-full">Complaint</span>
        <span
            class="absolute top-1/2 -right-6 md:text-md text-sm md:-right-12 z-10 -rotate-90 transform -translate-y-full">Defendant</span>
        <div id="uec-accusations" class="w-full md:px-0 px-2 flex h-full items-center justify-center">
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import getPartyColor from "../../../api/getPartyColor.js";
import * as Sankey from "d3-sankey-circular";
import * as d3 from "d3";
// import Sankey from 'highcharts/modules/sankey';

// Sankey(Highcharts);
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
        let container = document.getElementById('uec-accusations');

        let test = {
            "nodes": [
                {"name": "start"},
                {"name": "bt"},
                {"name": "pb"},
                //{ "name": "end" },
                {"name": "pg"},
                {"name": "sd"},
                {"name": "s"}
            ],
            "links": [{
                "source": "s",
                "target": "s",
                "value": 16879,
                "id": "start_search_0",
                "control": true
            }, {
                "source": "sd",
                "target": "s",
                "value": 22305,
                "id": "suggestionDetails_search_0",
                "control": true
            }, {
                "source": "bt",
                "target": "s",
                "value": 22305,
                "id": "browseTitles_search_0",
                "control": true
            }, {
                "source": "pb",
                "target": "s",
                "value": 16879,
                "id": "playback_search_0",
                "control": true
            }, {
                "source": "s",
                "target": "sd",
                "value": 6690,
                "id": "start_suggestionDetails_0",
                "control": true
            }, {
                "source": "pb",
                "target": "bt",
                "value": 19207,
                "id": "playback_browseTitles_0",
                "control": true
            }, {
                "source": "s",
                "target": "bt",
                "value": 16393,
                "id": "search_browseTitles_0",
                "control": true
            }, {
                "source": "start",
                "target": "bt",
                "value": 19207,
                "id": "start_browseTitles_0",
                "control": true
            }, {
                "source": "pg",
                "target": "bt",
                "value": 12442,
                "id": "profilesGate_browseTitles_0",
                "control": true
            }, {
                "source": "start",
                "target": "pb",
                "value": 3107,
                "id": "start_playback_0",
                "control": true
            }, {
                "source": "bt",
                "target": "pb",
                "value": 3107,
                "id": "browseTitles_playback_0",
                "control": true
            }, {"source": "bt", "target": "pg", "value": 401, "id": "browseTitles_profilesGate_0", "control": true}]
        };

        // const tooltip = d3.select('#party-accusations-tooltip');

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
        let current = {
            nodes: test.nodes.map(d => Object.assign({}, d)),
            links: test.links.map(d => Object.assign({}, d))
        };
        const sankey = Sankey.sankeyCircular()
            .nodeId(d => d.name)
            .nodeWidth(36)
            .nodePadding(40)
            .size([width, height])(current)

        console.log(current)

        var g = svg.append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")

        var linkG = g.append("g")
            .attr("class", "links")
            .attr("fill", "none")
            .attr("stroke-opacity", 0.2)
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
            .attr("y", function (d) {
                return d.y0;
            })
            .attr("height", function (d) {
                return d.y1 - d.y0;
            })
            .attr("width", function (d) {
                return d.x1 - d.x0;
            })
            .style("fill", function (d) {
                return '#ff5d5d';
            })
            .style("opacity", 0.5)

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

        link.append("path")
            .attr("class", "sankey-link")
            .attr("d", function (link) {
                return link.path;
            })
            .style("stroke-width", function (d) {
                return Math.max(1, d.width);
            })
            .style("opacity", 0.7)
            .style("stroke", function (link, i) {
                return link.circular ? "red" : "black"
            })

        link.append("title")
            .text(function (d) {
                return d.source.name + " → " + d.target.name;
            });
        container.append(svg.node());
    })
    // console.log(data, nodes)
    // Highcharts.chart('uec-accusations', {
    //     chart: {
    //         height: '800px',
    //         backgroundColor: '#EBFFE0',
    //     },
    //     title: {
    //         text: 'Complaint to UEC'
    //     },
    //     accessibility: {
    //         point: {
    //             valueDescriptionFormat: '{index}. {point.from} to {point.to}, {point.weight}. '
    //         }
    //     },
    //     plotOptions: {
    //         series: {
    //             dataLabels: {
    //                 enabled: true,
    //                 // x: -10
    //                 // textPath: {enabled: false}
    //             },
    //             stickyTracking: false
    //         }
    //     },
    //     tooltip: {
    //         useHTML: true,
    //     },
    //     series: [{
    //         keys: ['from', 'to', 'weight', 'color'],
    //         name: '',
    //         type: 'sankey',
    //         data: data.sort((a, b) => b.weight > a.weight ? 1 : -1),
    //         nodes: nodes,
    //     }],
    //     credits: {
    //         enabled: false,
    //     }
    //
    // });
    // })
})
</script>

<style scoped>

</style>
