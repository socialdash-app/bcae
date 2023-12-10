<template>
    <div class="w-7/12 py-10 h-full relative flex items-center justify-center">
        <div id="party-accusations-facebook-posts" class="w-full md:px-0 px-2 flex h-full items-center justify-center">
        </div>
    </div>
</template>

<script setup>
import packedbubble from 'highcharts/highcharts-more';

packedbubble(Highcharts);

import {reactive, onMounted} from "vue";
import settings from "../../../api/settings.js";
import {convertHex} from "../../../api/helpers.js";
import getPartyColor from "../../../api/getPartyColor.js";

const props = defineProps([]);

const data = reactive({})


onMounted(() => {
    axios.post('party-actions/party-accusations').then((res) => {
        let series = [];
        Object.keys(res.data).forEach((party) => {
            let color = getPartyColor(party);
            let d = res.data[party].map((datum) => {
                datum.value = 1;
                datum.color = color;
                return datum;
            })
            series.push({
                name: party,
                color: color ? convertHex(color, 0.3) : null, // we will focus on NLD and USDP.
                data: d,
            })
        })
        Highcharts.chart('party-accusations-facebook-posts', {
            chart: {
                type: 'packedbubble',
                height: '800px',
                backgroundColor: '#EBFFE0',
            },
            title: {
                text: 'Parties post election complaints on Facebook',
            },
            tooltip: {
                useHTML: true,
                formatter: function () {
                    if (!this.key) {
                        return `<b>${this.series.name}</b>`
                    }
                    return `<b>${this.key}</b><br/> ${settings.data.locale === 'en' ? this.point.message_en : this.point.message}`
                }
            },
            credits: {
                enabled: false,
            },
            legend: {
                enabled: true,
                layout: 'horizontal',
            },
            plotOptions: {
                packedbubble: {
                    minSize: '30%',
                    maxSize: '90%',
                    zMin: 0,
                    zMax: 1000,
                    layoutAlgorithm: {
                        gravitationalConstant: 0.05,
                        splitSeries: true,
                        seriesInteraction: false,
                        dragBetweenSeries: false,
                        enableSimulation: false,
                        parentNodeLimit: true
                    },
                    dataLabels: {
                        enabled: false,
                        format: '{point.name}',
                    }
                }
            },
            series: series,
        });
    })


})
</script>

<style scoped>

</style>
