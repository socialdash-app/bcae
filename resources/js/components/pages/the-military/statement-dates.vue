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
const height = window.innerHeight;

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
