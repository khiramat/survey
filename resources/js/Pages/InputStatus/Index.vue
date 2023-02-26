<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';

const props = defineProps({
    inputs: Object,
    user_num: Object,
    opening_event: Object
});
const user_num = props.user_num[0].user_num - 1;
const answer_num = user_num * 20;
//console.log(props.inputs)
//console.log(props.user_num)
//console.log(props.opening_event)

const survey_year = survey_years();
function survey_years(){
    if(Object.values(props.opening_event).length !== 0){
        var result = props.opening_event[0].event_date.split('-')[0];
    } else {
        result = null;
    }
    return result
}

const survey_month = survey_months();
function survey_months(){
    if(Object.values(props.opening_event).length !== 0){
        var result = props.opening_event[0].event_date.split('-')[1];
    } else {
        result = null;
    }
    return result
}

const survey_num = survey_nums();
function survey_nums(){
    if(Object.values(props.opening_event).length !== 0){
        var result = props.opening_event[0].id + 1;
    } else {
        result = null;
    }
    return result
}


</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<template>
    <Head title="イベント回答状況"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 v-if="Object.values(props.opening_event).length !== 0" class="font-semibold text-xl text-gray-800 leading-tight">
                {{survey_year}}年{{survey_month}}月（第{{survey_num}}回）の回答状況
            </h2>

            <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">
                開催中のサーベイはありません。
            </h2>

        </template>
        <div v-if="Object.values(props.opening_event).length !== 0" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="table table-bordered text-nowrap" style="width: 20%">
                        <tbody>
                        <tr>
                            <th style="white-space: nowrap; padding: 5px;">ID</th>
                            <th style="white-space: nowrap; padding: 5px;">名前</th>
                            <th style="white-space: nowrap; padding: 5px;">入力数</th>
                            <th style="white-space: nowrap; padding: 5px;">Status</th>
                        </tr>
                        <tr  v-for="input in inputs" :key="input.id">
                            <td style="white-space: nowrap; padding: 5px; text-align: right;">{{input.id}}</td>
                            <td style="white-space: nowrap; padding: 5px;">{{input.name}}</td>
                            <td style="white-space: nowrap; padding: 5px; text-align: right;">
                                <span v-if="input.count">{{input.count}}</span>
                                <span v-else="!input.count">0</span>
                            </td>
                            <td style="white-space: nowrap; padding: 5px; text-align: right;">
                                <span v-if="input.count && input.count === answer_num">Complete</span>
                                <span v-else style="color: red">Incomplete</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-else>

        </div>
    </AuthenticatedLayout>
</template>
