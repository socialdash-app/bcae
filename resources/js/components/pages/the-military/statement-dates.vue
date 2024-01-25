<template>
    <div class="w-full pt-10 md:!w-7/12 px-6 md:!px-10 flex items-center" :style="{height: height + 'px'}">
        <Calendar
            v-if="!data.loading"
            :attributes="data.attributes"
            :columns="columns"
            :max-date="new Date('2021-01-31')"
            :min-date="new Date('2020-11-30')"
            :rows="2" expanded>
            <template #day-popover="{ day, dayTitle, attributes }">
                <div class="px-2">
                    <div class="text-xs relative text-gray-50 font-semibold text-center">
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
    </div>
</template>

<script setup>
import {reactive, onMounted} from "vue";
import {Calendar} from "v-calendar";

import {useScreens} from 'vue-screen-utils';

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
    background: white;
}
</style>
