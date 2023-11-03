<template>
    <div class="w-full p-12 h-full flex relative">
        <div class="w-7/12 h-full fixed" id="container">
        </div>
        <div class="w-7/12 h-full">
        </div>
        <div class="w-5/12 h-full flex items-center flex-col gap-y-12">
            <div class="w-full flex items-center flex-col h-[100vh] gap-y-6 shrink-0 content" v-for="i in [1,2,3,4,5]">
                <h1 class="font-semibold text-2xl mb-4">Title</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and
                    scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap
                    into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                    the
                    release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                    publishing
                    software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and
                    scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap
                    into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                    the
                    release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                    publishing
                    software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import * as d3 from 'd3';
import scrollama from 'scrollama'

const props = defineProps([]);

const data = reactive({});

const scroller = new scrollama();

const init = (element, data) => {
    let validPropagandists = data.validPropagandists;
    let total = Object.keys(validPropagandists).length;
    let radius = 12;
    let gapThreshold = 1.2;
    let columns = 30;

    // Declare the chart dimensions and margins.
    const width = element.getBoundingClientRect().width;
    const height = element.getBoundingClientRect().height;
    const marginTop = 20;
    const marginRight = 30;
    const marginBottom = 30;
    const marginLeft = 40;


    // Create the SVG container.
    const svg = d3.create("svg")
        .attr("width", width + marginLeft + marginRight)
        .attr("height", height + marginTop + marginBottom)
        .attr("viewBox", [0, 0, width, height])
        .attr("style", "max-width: 100%; height: auto; position: absolute;")

    let color = d3.interpolateRgb("purple", "orange")

    let rowIndex = 0;
    let currentItemIndex = 0;
    do {
        for (let j = 0; j < columns; j++) {
            currentItemIndex++;
            svg.append('circle')
                .attr('r', radius)
                .attr('stroke', 'black')
                .attr('fill', color(rowIndex / 10))
                .attr('cx', (j * radius * 2 * gapThreshold) + marginLeft)
                .attr('cy', height)
                .style('opacity', 0)
                .transition()
                // .delay(currentItemIndex * 15)
                .duration(200)
                .delay(rowIndex * 100)
                .style('opacity', 1)
                .attr('cy', (rowIndex * radius * 2 * gapThreshold) + marginTop)
                .easeVarying((_) => d3.easeExpOut);
            if (currentItemIndex === total) {
                break;
            }
        }
        if (currentItemIndex === total) {
            break;
        }
        rowIndex++;
    } while (true)
    // Append the SVG element.
    element.append(svg.node());

    let isInitial = true;

    const steps = {
        0: {
            onStepEnter: (data) => {
                svg.selectAll('circle').transition().style('opacity', 1)
            },
        }, 1: {
            onStepEnter: (data) => {
                svg.selectAll('circle').transition().style('opacity', (_, index) => {
                    return Math.floor(Math.random() * 2) ? 0.2 : 1
                })
            }
        },
        2: {
            onStepEnter: (data) => {
                svg.selectAll('circle').transition().style('opacity', (_, index) => {
                    return Math.floor(Math.random() * 2) ? 0.2 : 1
                })
            }
        },
        3: {
            onStepEnter: (data) => {
                svg.selectAll('circle').transition().style('opacity', (_, index) => {
                    return Math.floor(Math.random() * 2) ? 0.2 : 1
                })
            }
        },
        4: {
            onStepEnter: (data) => {
                svg.selectAll('circle').transition().style('opacity', (_, index) => {
                    return Math.floor(Math.random() * 2) ? 0.2 : 1
                })
            }
        }
    }

    scroller
        .setup({
            step: ".content",
            progress: true,
        }).onStepProgress((response) => {
        // console.log('step', response)
    }).onStepEnter((response) => {
        if (isInitial) {
            isInitial = false;
            return;
        }
        steps[response.index].onStepEnter(response);
    })
}

onMounted(() => {
    axios.post('/correlated-actions/disinformation').then((res) => {
        init(document.getElementById('container'), res.data)
    })

})
</script>

<style scoped>

</style>
