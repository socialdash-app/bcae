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

import Sankey from 'highcharts/modules/sankey';

Sankey(Highcharts);
const props = defineProps([]);

const data = reactive({})

onMounted(() => {
    axios.post('party-actions/uec-accusations').then((res) => {
        let data = [];
        let nodes = [];
        Object.keys(res.data).forEach((partyName, key) => {
            data.push(...res.data[partyName].map((r) => {
                r.color = getPartyColor(r.from)
                r.from = key;
                return r;
            }))
            nodes.push({
                id: key,
                name: partyName,
                color: getPartyColor(partyName)
            })
        })
        // console.log(data, nodes)
        Highcharts.chart('uec-accusations', {
            chart: {
                height: '800px',
                backgroundColor: '#EBFFE0',
            },
            title: {
                text: 'Complaint to UEC'
            },
            accessibility: {
                point: {
                    valueDescriptionFormat: '{index}. {point.from} to {point.to}, {point.weight}. '
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        // x: -10
                        // textPath: {enabled: false}
                    },
                    stickyTracking: false
                }
            },
            tooltip: {
                useHTML: true,
            },
            series: [{
                keys: ['from', 'to', 'weight', 'color'],
                name: '',
                type: 'sankey',
                data: data.sort((a, b) => b.weight > a.weight ? 1 : -1),
                nodes: nodes,
            }],
            credits: {
                enabled: false,
            }

        });
    })
})
</script>

<style scoped>

</style>
