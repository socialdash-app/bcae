<template>
    <div class="w-7/12 p-10 h-screen flex items-center">
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
                        <svg class="top-0 absolute right-0 w-5 h-5 z-10 text-gray-100 fill-current"
                             title="Click the text to view detail"
                             viewBox="0 0 256 256"
                             xmlns="http://www.w3.org/2000/svg"
                             @mouseout="reactiveData.showInfo = false"
                             @mouseover="reactiveData.showInfo = true"
                        >
                            <rect fill="none" height="256" width="256"/>
                            <circle cx="128" cy="128" r="96" stroke="#000" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="8"/>
                            <polyline points="120 120 128 120 128 176 136 176" stroke="#000" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="12"/>
                            <circle cx="128" cy="84" fill="#000" r="12"/>
                        </svg>
                        <p v-show="reactiveData.showInfo"
                           class="absolute text-gray-800 top-5 right-0 p-2 bg-white text-sm">
                            Click the text to view detail
                        </p>
                    </div>
                    <ul class="mt-1 mb-1">
                        <li
                            v-for="{key, customData} in attributes"
                            :key="key"
                            class="cursor-pointer w-64"
                            @click="showDetail(customData.find((d) => d.date.toDateString() === day.date.toDateString()))">
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

const reactiveData = reactive({
    showInfo: false,
})

const showDetail = (e) => {
    console.log(e)
}

const props = defineProps([]);

const data = reactive({
    importantStatements: [],
    regularStatements: [],
    attributes: [],
    loading: true,
})


axios.post('the-military/statements').then((res) => {
    console.log(res.data)
    Object.values(res.data).forEach((d) => {
        let dateSplit = d['date'].split(' ')
        let time = /^(\d)(\d)/.test(dateSplit[1]) ? dateSplit[1] : '0' + dateSplit[1];
        let date = new Date(`${dateSplit[0]}T${time}`);
        if (d['isImportant']) {
            data.importantStatements.push({
                message: d['message'],
                type: d['type'],
                date: date,
                detail: d['detail'],
                dateString: d['date']
            })
        } else {
            data.regularStatements.push({
                date: date,
                message: d['message'],
                type: d['type'],
                detail: d['detail'],
                dateString: d['date']
            })
        }
    })
    data.attributes = [
        {
            dot: 'red',
            popover: {
                visibility: 'hover',
                isInteractive: true,
            },
            dates: data.importantStatements.map((d) => d.date),
            customData: data.importantStatements
        },
        {
            dot: 'blue',
            popover: {
                visibility: 'hover',
                isInteractive: true,
            },
            dates: data.regularStatements.map((d) => d.date),
            customData: data.regularStatements
        }
    ]

    console.log(data)

    data.loading = false;
})

onMounted(() => {
})
</script>

<style scoped>
:deep(.vc-container) {
    background: #EE7E3333;
}
</style>
