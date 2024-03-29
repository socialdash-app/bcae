<template>
    <div class="w-full pt-10 md:!w-7/12 py-12 px-6 flex-col md:!px-10 flex items-center">
        <h1 class="w-full text-center font-bold text-xl mb-12 md:text-2xl">
            Calendar of Military activities in response to the Election Dispute
        </h1>
        <div style="background-color: rgb(255 237 218);"
             class="w-full items-center flex flex-col p-4 md:!p-12 rounded">
            <Calendar
                v-if="!data.loading"
                :attributes="data.attributes"
                :columns="columns"
                :max-date="new Date('2021-01-31')"
                :min-date="new Date('2020-11-30')"
                :rows="2" expanded>
                <template #day-popover="{ day, dayTitle, attributes }">
                    <div class="px-2">
                        <div class="text-xs relative text-gray-50 text-center">
                            <p>{{ dayTitle }}</p>
                        </div>
                        <ul class="mt-1 mb-1">
                            <li
                                v-for="{key, customData} in attributes"
                                :key="key"
                                class="cursor-pointer w-64">
                                {{ customData.find((d) => d.date.toDateString() === day.date.toDateString()).message }}
                            </li>
                        </ul>
                    </div>
                </template>
            </Calendar>
            <div class="flex flex-col justify-center gap-4 pt-8">
                <div class="flex items-center gap-x-2">
                    <span style="background: red" class="p-2 rounded-full"></span>
                    <span class="text-sm">Statements related to the election</span>
                </div>
                <div class="flex items-center gap-x-2">
                    <span style="background: blue" class="p-2 rounded-full"></span>
                    <span class="text-sm">Findings in scrutiny of voter lists</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import {Calendar} from "v-calendar";

import {useScreens} from 'vue-screen-utils';
import {headers} from "../../../api/route.js";

const {mapCurrent} = useScreens({xs: '0px', sm: '640px', md: '768px', lg: '1024px'});
const columns = mapCurrent({lg: 2}, 1);
const height = window.innerHeight;

const props = defineProps([]);

const data = reactive({
    importantStatements: [],
    regularStatements: [],
    attributes: [],
    loading: true,
})

fetch('assets/data/statements.json').then(async (res) => {
    let json = await res.json();
    json.importantStatements = json.importantStatements.map((d) => {
        d.date = new Date(d.date);
        return d;
    });
    json.regularStatements = json.regularStatements.map((d) => {
        d.date = new Date(d.date);
        return d;
    })
    data.importantStatements = json.importantStatements
    data.regularStatements = json.regularStatements
    data.attributes = [
        {
            dot: 'red',
            popover: {
                visibility: 'hover',
                isInteractive: true,
            },
            dates: json.importantStatements.map((d) => d.date),
            customData: json.importantStatements
        },
        {
            dot: 'blue',
            popover: {
                visibility: 'hover',
                isInteractive: true,
            },
            dates: json.regularStatements.map((d) => d.date),
            customData: json.regularStatements
        }
    ]

    data.loading = false;
})

onMounted(() => {
})
</script>

<style scoped>
:deep(.vc-container) {
    background: transparent;
    border: none;
}
</style>
