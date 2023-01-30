<script setup>
import {usePage} from '@inertiajs/inertia-vue3'
const my_user_id = usePage().props.value.auth.user.id;

const props = defineProps({
    chapters: Object,
    questions: Object,
    events: Object,
    majorities: Object,
    avg_majorities: Object,
    total_points: Object,
    total_points_companies: Object,
    total_points_companies_summary: Object,
    sum_total_points: Object,
    total_addition: Object,
    users: Object,
    selectValue: Number,
});
//console.log(props.selectValue)
if(props.selectValue == 0 || props.selectValue == null){
    var selectedEventId = 1
} else {
    var selectedEventId = props.selectValue
}

const event_ary = props.events.filter((u) => u.id === selectedEventId);

const majorities = majority(selectedEventId);
function majority(event_id){
    const total_point_ary = props.majorities.filter((u) => u.event_id === event_id);
    var last_obj = [];
    Object.keys(total_point_ary).forEach(function(key) {
        const val = this[key];
        last_obj.push(val.point);
    }, total_point_ary);
    return last_obj;
};


const avg_majorities = avg_majority(selectedEventId);
function avg_majority(event_id){
    const total_point_ary = props.avg_majorities.filter((u) => u.event_id === event_id);
    var last_obj = [];
    Object.keys(total_point_ary).forEach(function(key) {
        const val = this[key];
        last_obj.push(val.point);
    }, total_point_ary);
    return last_obj;
};

const total_points = total_point(selectedEventId);
function total_point(event_id){
    const total_point_ary = props.total_points.filter((u) => u.event_id === event_id);
    var last_obj = [];
    Object.keys(total_point_ary).forEach(function(key) {
        const val = this[key];
        last_obj.push(val.point);
    }, total_point_ary);
    return last_obj;
};


const total_points_companies = total_points_company(selectedEventId);
function total_points_company(event_id){
    const total_point_ary = props.total_points_companies.filter((u) => u.event_id === event_id);
    var last_obj = [];
    Object.keys(total_point_ary).forEach(function(key) {
        const val = this[key];
        last_obj.push(val.point);
    }, total_point_ary);
    return last_obj;
};


const sum_total_points = sum_total_point(selectedEventId);
function sum_total_point(event_id){
    const total_point_ary = props.sum_total_points.filter((u) => u.event_id === event_id);
    var last_obj = [];
    Object.keys(total_point_ary).forEach(function(key) {
        const val = this[key];
        last_obj.push(val.point);
    }, total_point_ary);
    return last_obj;
};


function round_2(val){
    const rounded_data = Math.round(val * Math.pow(10, 2)) / Math.pow(10, 2);
    return rounded_data
}

const total_avg_point = total_avg_cal_all(selectedEventId)
function total_avg_cal_all(id) {
    const companies_summary = props.total_points_companies_summary.filter((u) => u.event_id === id);
    const total_companies_summary = companies_summary[0].summarise_point
    return total_companies_summary
}

const majority_company_points = majority_company_point(selectedEventId);
function majority_company_point(event_id) {
    const majority_company_point_ary = props.avg_majorities.filter((u) => u.event_id === event_id); // 選択された実施年月で連想配列から対象レコードを選択
    return majority_company_point_ary
};

const company_total = Number(total_avg_point) + Number(majority_company_points[0].avg_point);

const total_additions = total_addition_f(selectedEventId);
function total_addition_f(event_id) {
    const total_point_user_ary = props.total_addition.filter((u) => u.event_id === event_id && u.user_id === my_user_id); // 選択された実施年月で連想配列から対象レコードを選択
    const user_total = total_point_user_ary[0].mvv_point + total_point_user_ary[0].maj_point
    return user_total
};

//////////////////////////////////////////////////////////////////////////
// グラフデータ
//////////////////////////////////////////////////////////////////////////
// レーダーチャート

const graph_data_company_1 = round_2((total_points_companies[0] + total_points_companies[1] + total_points_companies[2]) / 3);
const graph_data_company_2 = round_2((total_points_companies[3] + total_points_companies[4] + total_points_companies[5]) / 3);
const graph_data_company_3 = round_2((total_points_companies[6] + total_points_companies[7] + total_points_companies[8]) / 3);
const graph_data_company_4 = round_2((total_points_companies[9] + total_points_companies[10]) / 2);
const graph_data_company_5 = round_2((total_points_companies[11] + total_points_companies[12]) / 2);
const graph_data_company_6 = round_2((total_points_companies[13] + total_points_companies[14] + total_points_companies[15]) / 3);
const graph_data_company_7 = round_2((total_points_companies[16] + total_points_companies[17]) / 2);
const graph_data_company_8 = round_2((total_points_companies[18] + total_points_companies[19]) / 2);

const graph_data_my_1 = round_2((total_points[0] + total_points[1] + total_points[2]) / 3);
const graph_data_my_2 = round_2((total_points[3] + total_points[4] + total_points[5]) / 3);
const graph_data_my_3 = round_2((total_points[6] + total_points[7] + total_points[8]) / 3);
const graph_data_my_4 = round_2((total_points[9] + total_points[10]) / 2);
const graph_data_my_5 = round_2((total_points[11] + total_points[12]) / 2);
const graph_data_my_6 = round_2((total_points[13] + total_points[14] + total_points[15]) / 3);
const graph_data_my_7 = round_2((total_points[16] + total_points[17]) / 2);
const graph_data_my_8 = round_2((total_points[18] + total_points[19]) / 2);

import { Radar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, PointElement, RadialLinearScale, LineElement } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, PointElement, RadialLinearScale, LineElement)

let RadarChartData = {
    labels: [ '和をもって尊く', '礼儀', '誠実', '積極性', '開示', '当事者意識', '責任', '学びと遊び' ],
    datasets: [ { label: '会社平均',
        backgroundColor: 'rgba(179,181,198,0.2)',
        borderColor: 'rgba(179,181,198,1)',
        pointBackgroundColor: 'rgba(179,181,198,1)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgba(179,181,198,1)',
        data: [graph_data_company_1, graph_data_company_2, graph_data_company_3, graph_data_company_4, graph_data_company_5, graph_data_company_6, graph_data_company_7, graph_data_company_8] },

        { label: '私の点数',
            backgroundColor: 'rgba(255,99,132,0.2)',
            borderColor: 'rgba(255,99,132,1)',
            pointBackgroundColor: 'rgba(255,99,132,1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(255,99,132,1)',
            data: [graph_data_my_1, graph_data_my_2, graph_data_my_3, graph_data_my_4, graph_data_my_5, graph_data_my_6, graph_data_my_7, graph_data_my_8] } ]
};

let chartOptions = {
    scales: {
        r: {
            max: 4
        },
    },
    responsive: true,
    maintainAspectRatio: false
};
</script>
<template>
    <table>
        <thead>
        <tr style="background-color: #00005a; color: white">
            <th>No.</th>
            <th>質問</th>
            <th>会社平均</th>
            <th style="background-color: #00005a; color: white"> {{ $page.props.auth.user.name }}</th>
        </tr>
        </thead>
        <tbody>
        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[0].chapter_no }}条 {{ chapters[0].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[0] + total_points_companies[1] + total_points_companies[2]) / 3) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[0] + total_points[1] + total_points[2]) / 3) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[0].id }}</td>
            <td>{{ questions[0].question }}</td>
            <td style="text-align: right">{{ total_points_companies[0] }}</td>
            <td style="text-align: right">{{ total_points[0] }}</td>
        </tr>
        <tr>
            <td>{{ questions[1].id }}</td>
            <td>{{ questions[1].question }}</td>
            <td style="text-align: right">{{ total_points_companies[1] }}</td>
            <td style="text-align: right">{{ total_points[1] }}</td>
        </tr>
        <tr>
            <td>{{ questions[2].id }}</td>
            <td>{{ questions[2].question }}</td>
            <td style="text-align: right">{{ total_points_companies[2] }}</td>
            <td style="text-align: right">{{ total_points[2] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[1].chapter_no }}条 {{ chapters[1].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[3] + total_points_companies[4] + total_points_companies[4]) / 3) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[3] + total_points[4] + total_points[5]) / 3) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[3].id }}</td>
            <td>{{ questions[3].question }}</td>
            <td style="text-align: right">{{ total_points_companies[3] }}</td>
            <td style="text-align: right">{{ total_points[3] }}</td>
        </tr>
        <tr>
            <td>{{ questions[4].id }}</td>
            <td>{{ questions[4].question }}</td>
            <td style="text-align: right">{{ total_points_companies[4] }}</td>
            <td style="text-align: right">{{ total_points[4] }}</td>
        </tr>
        <tr>
            <td>{{ questions[5].id }}</td>
            <td>{{ questions[5].question }}</td>
            <td style="text-align: right">{{ total_points_companies[5] }}</td>
            <td style="text-align: right">{{ total_points[5] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[2].chapter_no }}条 {{ chapters[2].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[6] + total_points_companies[7] + total_points_companies[8]) / 3) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[6] + total_points[7] + total_points[8]) / 3) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[6].id }}</td>
            <td>{{ questions[6].question }}</td>
            <td style="text-align: right">{{ total_points_companies[6] }}</td>
            <td style="text-align: right">{{ total_points[6] }}</td>
        </tr>
        <tr>
            <td>{{ questions[7].id }}</td>
            <td>{{ questions[7].question }}</td>
            <td style="text-align: right">{{ total_points_companies[7] }}</td>
            <td style="text-align: right">{{ total_points[7] }}</td>
        </tr>
        <tr>
            <td>{{ questions[8].id }}</td>
            <td>{{ questions[8].question }}</td>
            <td style="text-align: right">{{ total_points_companies[8] }}</td>
            <td style="text-align: right">{{ total_points[8] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[3].chapter_no }}条 {{ chapters[3].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[9] + total_points_companies[10]) / 2) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[9] + total_points[10]) / 2) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[9].id }}</td>
            <td>{{ questions[9].question }}</td>
            <td style="text-align: right">{{ total_points_companies[9] }}</td>
            <td style="text-align: right">{{ total_points[9] }}</td>
        </tr>
        <tr>
            <td>{{ questions[10].id }}</td>
            <td>{{ questions[10].question }}</td>
            <td style="text-align: right">{{ total_points_companies[10] }}</td>
            <td style="text-align: right">{{ total_points[10] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[4].chapter_no }}条 {{ chapters[4].chapter_name }}</td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points_companies[11] + total_points_companies[12]) / 2) }}
            </td>
            <td style="text-align: right">
                {{ round_2((total_points[11] + total_points[12]) / 2) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[11].id }}</td>
            <td>{{ questions[11].question }}</td>
            <td style="text-align: right">{{ total_points_companies[11] }}</td>
            <td style="text-align: right">{{ total_points[11] }}</td>
        </tr>
        <tr>
            <td>{{ questions[12].id }}</td>
            <td>{{ questions[12].question }}</td>
            <td style="text-align: right">{{ total_points_companies[12] }}</td>
            <td style="text-align: right">{{ total_points[12] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[5].chapter_no }}条 {{ chapters[5].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[13] + total_points_companies[14] + total_points_companies[15]) / 3) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[13] + total_points[14] + total_points[15]) / 3) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[13].id }}</td>
            <td>{{ questions[13].question }}</td>
            <td style="text-align: right">{{ total_points_companies[13] }}</td>
            <td style="text-align: right">{{ total_points[13] }}</td>
        </tr>
        <tr>
            <td>{{ questions[14].id }}</td>
            <td>{{ questions[14].question }}</td>
            <td style="text-align: right">{{ total_points_companies[14] }}</td>
            <td style="text-align: right">{{ total_points[14] }}</td>
        </tr>
        <tr>
            <td>{{ questions[15].id }}</td>
            <td>{{ questions[15].question }}</td>
            <td style="text-align: right">{{ total_points_companies[15] }}</td>
            <td style="text-align: right">{{ total_points[15] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[6].chapter_no }}条 {{ chapters[6].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[16] + total_points_companies[17]) / 2) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[16] + total_points[17]) / 2) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[16].id }}</td>
            <td>{{ questions[16].question }}</td>
            <td style="text-align: right">{{ total_points_companies[16] }}</td>
            <td style="text-align: right">{{ total_points[16] }}</td>
        </tr>
        <tr>
            <td>{{ questions[17].id }}</td>
            <td>{{ questions[17].question }}</td>
            <td style="text-align: right">{{ total_points_companies[17] }}</td>
            <td style="text-align: right">{{ total_points[17] }}</td>
        </tr>

        <tr style="background-color: #e6e6fa; font-weight: bold">
            <td colspan="2">第{{ chapters[7].chapter_no }}条 {{ chapters[7].chapter_name }}</td>
            <td style="text-align: right">
                {{ round_2((total_points_companies[18] + total_points_companies[19]) / 2) }}
            </td>
            <td style="text-align: right; font-weight: bold">
                {{ round_2((total_points[18] + total_points[19]) / 2) }}
            </td>
        </tr>
        <tr>
            <td>{{ questions[18].id }}</td>
            <td>{{ questions[18].question }}</td>
            <td style="text-align: right">{{ total_points_companies[18] }}</td>
            <td style="text-align: right">{{ total_points[18] }}</td>
        </tr>
        <tr>
            <td>{{ questions[19].id }}</td>
            <td>{{ questions[19].question }}</td>
            <td style="text-align: right">{{ total_points_companies[19] }}</td>
            <td style="text-align: right">{{ total_points[19] }}</td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: right">MVVスコア</td>
            <td style="text-align: right; background-color: #e5e9ff; font-weight: bold">{{ total_avg_point }}</td>
            <td style="text-align: right; background-color: #cbd4ff; font-weight: bold">{{ sum_total_points[0] }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">過半数回答付加点</td>
            <td style="text-align: right; background-color: #e5e9ff; font-weight: bold">{{majority_company_points[0].avg_point}}</td>
            <td style="text-align: right; background-color: #cbd4ff; font-weight: bold">{{ majorities[0] }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">合計点</td>
            <td style="text-align: right; background-color: #aebfff; font-weight: bold; color: white">{{ company_total }}</td>
            <td style="text-align: right; background-color: #8fabff; font-weight: bold; color: white">
                {{ total_additions }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">偏差値（会社平均は標準偏差）</td>
            <td style="text-align: right; background-color: #6998ff; font-weight: bold; color: white">{{ event_ary[0].stdev }}</td>
            <td style="text-align: right; background-color: #2e85ff; font-weight: bold; color: white">{{Math.round((total_additions - company_total)/event_ary[0].stdev * 10 + 50)}}</td>
            <!-- 偏差値＝（個人の得点-平均点）/ 標準偏差 × 10 + 50 -->
        </tr>
        </tbody>
    </table>
        <Radar
            :chart-options="chartOptions"
            :chart-data="RadarChartData"
       />

</template>
