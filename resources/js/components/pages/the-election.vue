<template>
    <div :style="{background: headers[1].primaryColor}" id="the-election"
         class="w-full pt-10 items-center flex flex-col relative">
        <div class="sticky pl-4 md:pl-14 top-4 md:!top-6 w-11/12 z-[10000]">
            <h1 class="text-xl md:text-3xl font-bold">The Election</h1>
        </div>
        <div class="w-full flex md:!flex-row flex-col items-center md:!items-start relative justify-evenly">
            <div id="map-container"
                 class="w-11/12 md:!w-4/12 sticky top-24 z-[1001] flex flex-col overflow-hidden">
                <button @click="resetZoom" v-show="data.isDrilldown"
                        class="absolute flex z-10 items-center gap-x-2 top-4 left-4 px-4 py-2 border rounded bg-white">
                    <span> Reset Map</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide w-4 h-4 lucide-undo-2">
                        <path d="M9 14 4 9l5-5"/>
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"/>
                    </svg>
                </button>
                <svg id="map">
                </svg>
                <div v-show="!data.loading" class="flex flex-col absolute bottom-0 left-0 gap-y-4">
                    <button @click="switchHluttawType('PyiThu')"
                            :class="data.currentHluttaw === 'PyiThu'?'bg-[#f788bf]':'bg-[#ffbfdf]'"
                            class="w-48 h-12 rounded hover:shadow-2xl">Pyithu
                        Hluttaw
                    </button>
                    <button @click="switchHluttawType('Amyothar')"
                            :class="data.currentHluttaw === 'Amyothar'?'bg-[#f788bf]':'bg-[#ffbfdf]'"
                            class="w-48 h-12 rounded hover:shadow-2xl">
                        Amyothar
                        Hluttaw
                    </button>
                </div>
            </div>
            <div id="election-result-detail" class="fixed border-gray-800 z-[1002] bg-[#FFC3E0] p-4 rounded border"
                 v-show="data.hoverRegion">
                <h1 class="font-semibold text-lg">{{ data.details.title }}</h1>
                <table>
                    <tbody>
                    <tr class=" flex items-center text-sm" :class="{ 'font-medium border-b border-black': index === 0 }"
                        v-for="(content, index) in data.details.contents">
                        <td class="p-2 w-4/12" v-for="c in content">{{ c }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-11/12 md:!w-1/2 flex flex-col items-center relative z-[1002]">
                <div class="mb-[50%] w-full rounded-lg h-[50vh] md:!h-screen"></div>
                <div
                    class="trigger p-4 md:!p-8 shadow-xl md:!shadow-none w-full mb-[90%] md:!mb-[50%] border rounded-lg bg-white min-h-[40vh]">
                    Despite the COVID-19 pandemic and other challenges, the third general election was held on November
                    8, 2020, per the 2008 Constitution. The domestic and international election observers also observed
                    the 2020 election and they found some inconsistencies in electoral administration and election
                    administration amid the ongoing pandemic, but they noted the election results credible, reflecting
                    the will of the majority of voters.
                </div>
                <div
                    class="trigger p-4 md:!p-8 shadow-xl md:!shadow-none w-full mb-[90%] md:!mb-[50%] border rounded-lg bg-white min-h-[40vh] relative">
                    National League for Democracy won the majority of constituencies except in some ethnic states with a
                    total of 396 seats in the national legislation Hluttaw, which was upped by 33 seats from its win in
                    the 2015 election. Therefore, the NLD party secured a landslide victory in the election, which was
                    well above the 322 required for a parliamentary majority
                </div>
                <div id="the-election-then-section"
                     class="relative mb-[50vh] w-full flex items-center justify-center">
                    <h1 class="then-title text-center bg-[#ff9ccd] absolute w-screen transform text-5xl md:text-6xl py-10 font-bold">
                        Then</h1>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import {onMounted, reactive} from 'vue';
import * as d3 from 'd3';
import {PopOver} from "vue-common-components";
import AnimeScrollTrigger from "anime-scrolltrigger";
import route, {headers} from "../../api/route.js";
import anime from 'animejs';
import {placeElementRelativeToScreen} from "../../api/helpers.js";
import settings from "../../api/settings.js";

let results = {}, zoomIntoRegion, path, resetZoom, g, g1, amyoThaFeatures, pyiThuFeatures, currentRegion;

const height = window.innerHeight;

const data = reactive({
    showChart: false,
    currentHluttaw: 'PyiThu',
    isDrilldown: false,
    hoverRegion: null,
    details: {
        title: '',
        contents: [],
    },
    loading: true,
});


const getPartyColor = (party) => {
    switch (party) {
        case 'Union Solidarity and Development Party':
            return '#00FF00';
        case 'National League for Democracy':
            return '#FF0000';
        case 'Kachin State People\'s Party ':
            return '#8c510a';
        case 'Kayah State Democratic Party':
            return '#bf812d';
        case 'Zomi Congress for Democracry':
            return '#dfc27d';
        case 'Mon Unity Party':
            return '#f6e8c3';
        case 'Arakan National Party':
            return '#f5f5f5';
        case 'Shan Nationalities League for Democracy':
            return '#c7eae5';
        case 'Ta-Arng (Palaung) National Party':
            return '#80cdc1';
        case 'Pao National Organization (PNO)':
            return '#35978f';
        case 'WA NATIONAL PARTY':
            return '#01665e';
        case 'Arakan Front Party (AFP)':
            return '#003c30';
        case 'Public of Labour Party':
            return '#214198';
        case 'Union Betterment Party':
            return '#f55b65';
        case 'New Democracy Party (Kachin)':
            return '#bc80bd';
        case 'Lisu National Development Party(L.N.D.P)':
            return '#ccebc5';
        case 'တစ်သီးပုဂ္ဂလ':
            return '#FFFFFF';
        case 'Kayin Peoples Party':
            return '#80b1d3';
        case 'Chin National League for Democracy Party':
            return '#fdb462';
        case 'La Hu National Development Party':
            return '#b3de69';
        default:
            return '#121212';
    }
};

const switchHluttawType = (hluttaw) => {
    if (data.currentHluttaw === hluttaw) return;
    data.currentHluttaw = hluttaw;
    if (data.isDrilldown) drawSubregions(getCurrentFeatures())
}

const getCurrentFeatures = () => {
    let features = data.currentHluttaw === 'Amyothar' ? amyoThaFeatures : pyiThuFeatures;
    return features.filter((feature) => feature.properties.ST.includes(currentRegion));
}

const init = () => {
    const svg = d3.select('svg#map');
    const width = svg.node().parentNode.getBoundingClientRect().width;
    const height = svg.node().parentNode.getBoundingClientRect().height;
    let detailBox = document.getElementById('election-result-detail');
    svg.attr('width', width);
    svg.attr('height', height);
    let upperGroup = svg
        .append('g')
        .attr("transform", "translate(" + 0 + "," + 0 + ")")
        .append('g')

    Promise.all([
        d3.json('assets/states-and-regions.json'),
        d3.json('assets/pyithu-lowerhouse.json'),
        d3.json('assets/amyotha-upperhouse.json'),
    ]).then(([all, pyithuData, amyothaData]) => {
        pyiThuFeatures = pyithuData.features;
        amyoThaFeatures = amyothaData.features;
        let projection = d3.geoEquirectangular().fitSize([width, height], all);
        path = d3.geoPath().projection(projection);

        let zoom = d3.zoom();

        g = upperGroup
            .append('g')
            .attr('class', 'map')
            .attr('stroke', 'black')
            .attr('stroke-width', '0.01')
            .attr('fill', '#b3b3b3');
        // class="map" fill = "#b3b3b3" stroke = "black" stroke - width="0.01"
        g1 = upperGroup
            .append('g')
            .attr('class', 'details')
            .attr('stroke', 'black')
            .attr('stroke-width', '0.01')
            .attr('fill', 'orange');

        zoom.on('zoom', (e) => {
            upperGroup.attr('transform', e.transform)
        })

        resetZoom = () => {
            upperGroup.transition().duration(750).call(zoom.transform,
                d3.zoomIdentity.translate(0, 0).scale(1))
            if (g1.selectAll('null')) {
                g1.selectAll('path').remove();
            }
            data.isDrilldown = false;
        }

        svg.on('click', (e, d) => {
            if (e.target === svg.node()) {
                resetZoom();
            }
        }).on('mousemove', (e, d) => {
            if (e.target === svg.node() && data.hoverRegion) {
                data.hoverRegion = null;
            }
        })

        document.querySelector('main').addEventListener('scroll', () => {
            if (data.hoverRegion) {
                data.hoverRegion = null;
            }
        })

        zoomIntoRegion = (region) => {
            currentRegion = region;
            let currentFeatures = getCurrentFeatures()
            let center = projection(d3.geoCentroid({
                type: 'FeatureCollection',
                features: currentFeatures,
            }));
            let scale = 1.5;
            upperGroup.transition().duration(750).call(
                zoom.transform,
                d3.zoomIdentity.translate((width / 2 - center[0] * scale), (height / 2 - center[1] * scale)).scale(scale))
            drawSubregions(currentFeatures)
            data.isDrilldown = true;
            data.hoverRegion = null;
        }
        g.selectAll('path')
            .data(all.features)
            .enter()
            .append('path')
            .style('cursor', 'pointer')
            .attr('d', (d) => {
                return path(d)
            })
            .style("fill", '#f2f2f2')
            .style("stroke-width", "1")
            .style("stroke", "#313131")
            .on('click', (e, d) => {
                zoomIntoRegion(d.properties.ST)
            })
            .on('mouseenter', (e, d) => {
                if (data.isDrilldown || data.hoverRegion === d.properties.ST_PCODE) return;
                let result = results[data.currentHluttaw].mapData.overviewData.filter((datum) => datum.SR_PCode === d.properties.ST_PCODE)[0];
                data.details.title = result.name;
                data.details.contents = [];
                data.details.contents.push(['Party', 'Votes', 'Proportions']);

                Object.entries(result.results).sort((a, b) => a[1].sum > b[1].sum ? -1 : 1).slice(0, 3).forEach((datum) => {
                    data.details.contents.push([datum[0], datum[1].sum.toLocaleString(), Math.round((datum[1].sum / result.sum) * 100) + '%']);
                })
                data.hoverRegion = d.properties.ST_PCODE;
                detailBox.style.top = e.clientY + 'px';
                detailBox.style.left = e.clientX + 'px';
                detailBox.style.opacity = 0;
                setTimeout(() => {
                    placeElementRelativeToScreen(detailBox).then((element) => {
                        element.style.opacity = 1;
                    });
                }, 100)
            });
    });
    data.loading = false;
}


const drawSubregions = (features) => {
    let detailBox = document.getElementById('election-result-detail');
    let regions = g1.selectAll('null');
    if (regions) {
        g1.selectAll('path').remove();
    }
    let attributeCodeName = data.currentHluttaw === 'PyiThu' ? 'TS_PCODE' : 'Constituen';
    g1.selectAll('path')
        .data(features)
        .enter()
        .append('path')
        .style('cursor', 'pointer')
        .attr('d', (d) => {
            return path(d)
        })
        .style("fill", (d) => {
            let result = results[data.currentHluttaw].mapData.detailData.filter((datum) =>
                d.properties[attributeCodeName] === datum.PCode)[0];
            if (!result) return "#ffffff";
            let winnerParty = result.results[0];
            return getPartyColor(winnerParty.partyName)
        })
        .style("stroke-width", "1")
        .on('mouseenter', (e, d) => {
            let result = results[data.currentHluttaw].mapData.detailData.filter((datum) => d.properties[attributeCodeName] === datum.PCode)[0];
            if (!result) {
                data.hoverRegion = null;
                return;
            }
            data.details.title = result.name;
            data.details.contents = [];
            data.details.contents.push(['Party', 'Candidate', 'Votes']);

            for (let i = 0; i < 3; i++) {
                let datum = result.results[i];
                if (!datum) break;
                data.details.contents.push([datum.partyName, datum.candidateName, datum.totalVote.toString().toLocaleString()]);
            }

            detailBox.style.top = e.clientY + 'px';
            detailBox.style.left = e.clientX + 'px';
            detailBox.style.opacity = 0;
            data.hoverRegion = d.properties.ST_PCODE;
            setTimeout(() => {
                placeElementRelativeToScreen(detailBox).then((element) => {
                    element.style.opacity = 1;
                });
            }, 100)
        });
}

const placeThenSection = () => {
    let section = document.getElementById('the-election-then-section');
    let left = section.children[0].getBoundingClientRect().left;
    console.log(section)
    section.children[0].style.transform = `translateX(-${left}px)`
}

onMounted(() => {
    setTimeout(() => {
        placeThenSection();
        const padding = 60;
        const topOffset = 24;
        const mapHeight = height - document.querySelector('#the-election').children[0].getBoundingClientRect().height - topOffset - padding;
        const mapContainer = document.getElementById('map-container');
        mapContainer.style.height = mapHeight + 'px'
        const mapContainerRect = mapContainer.getBoundingClientRect();
        const mapTranslateXWidth = (window.innerWidth * 0.5) - mapContainerRect.left - (0.5 * mapContainerRect.width);
        anime({
            targets: mapContainer,
            translateX: mapTranslateXWidth,
            duration: 0,
        })
        d3.json('assets/bcae-results.json').then((res) => {
            results = res;
            Object.keys(results).forEach((hlutaw) => {
                results[hlutaw].mapData.detailData = [...Object.values(results[hlutaw].mapData.detailData)].flat(1)
            })
            init()
        })
        let container = document.getElementById('the-election')
        let divs = container.querySelectorAll('.trigger');
        let triggers = [
            {
                scrollTrigger: {
                    trigger: container,
                    start: '1% top',
                    end: '30% top',
                    debug: true,
                    onEnter: () => {
                        anime({
                            targets: mapContainer,
                            translateX: [mapTranslateXWidth, 0],
                            duration: 1500,
                            easing: 'easeOutQuart',
                        })
                    },
                    onLeaveBack: () => {
                        anime({
                            targets: mapContainer,
                            translateX: [0, mapTranslateXWidth],
                            duration: 1500,
                            easing: 'easeOutQuart',
                        })
                    },
                }
            },
            {
                scrollTrigger: {
                    trigger: divs[0],
                    start: 'top 40%',
                    end: 'bottom center',
                    lerp: true,
                    onEnter: () => {
                        if (zoomIntoRegion) zoomIntoRegion('Kachin')
                    },
                    onEnterBack: () => {
                        if (zoomIntoRegion) zoomIntoRegion('Kachin')
                    },
                    onLeaveBack: () => {
                        resetZoom();
                    },
                }
            },
            {
                scrollTrigger: {
                    trigger: divs[1],
                    start: 'top 40%',
                    end: 'bottom center',
                    lerp: true,
                    onEnter: () => {
                        if (zoomIntoRegion) zoomIntoRegion('Shan')
                    },
                    onEnterBack: () => {
                        if (zoomIntoRegion) zoomIntoRegion('Shan')
                    }
                }
            },
            {
                scrollTrigger: {
                    trigger: container,
                    start: 'top top',
                    end: 'bottom top',
                    lerp: true,
                    smooth: true,
                    onEnter: () => {
                        route.changeSectionHeader(1)
                    },
                    onEnterBack: () => {
                        route.changeSectionHeader(1)
                    },
                    onLeave: () => {
                        if (data.hoverRegion) data.hoverRegion = null;
                    },
                    onLeaveBack: () => {
                        if (data.hoverRegion) data.hoverRegion = null;
                    },
                    onUpdate: (_, progress) => {
                        anime({
                            targets: '#header-the-election circle',
                            strokeDashoffset: 160 - progress * 160,
                            easing: 'easeOutQuart',
                            duration: 400,
                        })
                    }
                }
            },
            // {
            //     targets: '.then-title',
            //     scale: [1.5, 1],
            //     opacity: [0, 1],
            //     easing: 'easeOutQuart',
            //     duration: 2000,
            //     scrollTrigger: {
            //         trigger: '#the-election-then-section',
            //         start: 'top 40%',
            //         end: 'bottom top',
            //     }
            // },
        ]
        new AnimeScrollTrigger(document.querySelector('main'), triggers);
    }, settings.animationDuration)
})

</script>

<style scoped></style>
