<script setup>
import {usePage} from '@inertiajs/inertia-vue3'
const my_user_id = usePage().props.value.auth.user.id;
const props = defineProps({
    questions: Object,
    events: Object,
    total_points: Object,
    total_points_companies_summary: Object,
    avg_majorities: Object,
});


// 質問ごとのポイント配列作成
const total_points = total_point();
function total_point(id){
    var total_obj = [];
    Object.keys(props.events).forEach(function(key) {
        const event = this[key];
        const total_point_ary = props.total_points.filter((u) => u.event_id === event.id);
        var last_obj = [];
        Object.keys(total_point_ary).forEach(function(key) {
            const val = this[key];
            last_obj.push(val.point);
        }, total_point_ary);
        total_obj.push(last_obj);
    }, props.events);
    return total_obj;
};


const total_avg_point = total_avg_cal_all()
function total_avg_cal_all() {
    var total_obj = [];
    Object.keys(props.events).forEach(function(key) {
        const event = this[key];
        const companies_summary = props.total_points_companies_summary.filter((u) => u.event_id === event.id);
        Object.keys(companies_summary).forEach(function(key) {
            const val = this[key];
            const total_companies_summary = val.summarise_point
            total_obj.push(total_companies_summary);
        }, companies_summary);
    }, props.events);
    return total_obj
}

//
const majority_company_points = majority_company_point();
function majority_company_point() {
    var total_obj = [];
    Object.keys(props.events).forEach(function(key) {
        const event = this[key];
        const majority_company_point_ary = props.avg_majorities.filter((u) => u.event_id === event.id); // 選択された実施年月で連想配列から対象レコードを選択
        Object.keys(majority_company_point_ary).forEach(function(key) {
            const val = this[key];
            const  majority_summary = Number(val.avg_point)
            total_obj.push(majority_summary);
        }, majority_company_point_ary);
    }, props.events);
    return total_obj
};

// 合計算出
const total_summary = []
for (var i = 0; i < total_avg_point.length; i++) {
    const company_total = Number(total_avg_point[i]) + Number(majority_company_points[i]);
    total_summary.push(company_total)
}

//////////////////////////////////////////////////////////////////////////
// グラフデータ
//////////////////////////////////////////////////////////////////////////
const graph_y = ['2022-9', '2022-10', '2022-11', '2022-12', '2023-1', '2023-2', '2023-3', '2023-4', '2023-5', '2023-6', '2023-7', '2023-8', ]

import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, LinearScale, PointElement, CategoryScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, LineElement, LinearScale, PointElement, CategoryScale)

let LineChartData = {
    labels: graph_y,
    datasets: [ { label: '全社集計値',
        backgroundColor: 'rgba(179,181,198,0.2)',
        borderColor: 'rgba(179,181,198,1)',
        pointBackgroundColor: 'rgba(179,181,198,1)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgba(179,181,198,1)',
        data: total_summary }
    ]
};

let chartOptions = {
    scales: {
        y: {
            min: 0,
            max: 100
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
            <th style="background-color: #00005a; color: white; white-space: nowrap" v-for="(event, index) in events">{{ event.event_date.split('-')[1] }}/1/{{ event.event_date.split('-')[0] }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ questions[0].id }}</td>
            <td>{{ questions[0].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[0] }}</td>
        </tr>
        <tr>
            <td>{{ questions[1].id }}</td>
            <td>{{ questions[1].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[1] }}</td>
        </tr>
        <tr>
            <td>{{ questions[2].id }}</td>
            <td>{{ questions[2].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[2] }}</td>
        </tr>
        <tr>
            <td>{{ questions[3].id }}</td>
            <td>{{ questions[3].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[3] }}</td>
        </tr>
        <tr>
            <td>{{ questions[4].id }}</td>
            <td>{{ questions[4].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[4] }}</td>
        </tr>
        <tr>
            <td>{{ questions[5].id }}</td>
            <td>{{ questions[5].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[5] }}</td>
        </tr>
        <tr>
            <td>{{ questions[6].id }}</td>
            <td>{{ questions[6].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[6] }}</td>
        </tr>
        <tr>
            <td>{{ questions[7].id }}</td>
            <td>{{ questions[7].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[7] }}</td>
        </tr>
        <tr>
            <td>{{ questions[8].id }}</td>
            <td>{{ questions[8].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[8] }}</td>
        </tr>
        <tr>
            <td>{{ questions[9].id }}</td>
            <td>{{ questions[9].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[9] }}</td>
        </tr>
        <tr>
            <td>{{ questions[10].id }}</td>
            <td>{{ questions[10].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[10] }}</td>
        </tr>
        <tr>
            <td>{{ questions[11].id }}</td>
            <td>{{ questions[11].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[11] }}</td>
        </tr>
        <tr>
            <td>{{ questions[12].id }}</td>
            <td>{{ questions[12].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[12] }}</td>
        </tr>
        <tr>
            <td>{{ questions[13].id }}</td>
            <td>{{ questions[13].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[13] }}</td>
        </tr>
        <tr>
            <td>{{ questions[14].id }}</td>
            <td>{{ questions[14].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[14] }}</td>
        </tr>
        <tr>
            <td>{{ questions[15].id }}</td>
            <td>{{ questions[15].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[15] }}</td>
        </tr>
        <tr>
            <td>{{ questions[16].id }}</td>
            <td>{{ questions[16].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[16] }}</td>
        </tr>
        <tr>
            <td>{{ questions[17].id }}</td>
            <td>{{ questions[17].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[17] }}</td>
        </tr>
        <tr>
            <td>{{ questions[18].id }}</td>
            <td>{{ questions[18].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[18] }}</td>
        </tr>
        <tr>
            <td>{{ questions[19].id }}</td>
            <td>{{ questions[19].question }}</td>
            <td style="text-align: right" v-for="(total_point, index) in total_points">{{ total_point[19] }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">MVVスコア</td>
            <td style="text-align: right; background-color: #cbd4ff; font-weight: bold" v-for="(total_avg_point_val, index) in total_avg_point">{{ total_avg_point_val }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">過半数回答付加点</td>
            <td style="text-align: right; background-color: #8fabff; font-weight: bold" v-for="(majority_company_point, index) in majority_company_points">{{ majority_company_point }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">合計点</td>
            <td style="text-align: right; background-color: #2e85ff; font-weight: bold; color: white" v-for="(total_summary_val, index) in total_summary">{{ total_summary_val }}</td>
        </tr>
<!--
        <tr>
            <td colspan="2" style="text-align: right">標準偏差</td>
            <td style="text-align: right; background-color: #2e85ff; font-weight: bold" v-for="(event, index) in events">{{ event.stdev }}</td>
            &lt;!&ndash; 偏差値＝（個人の得点-平均点）/ 標準偏差 × 10 + 50 &ndash;&gt;
        </tr>
-->
        </tbody>
    </table>
    <Line
        :chart-options="chartOptions"
        :chart-data="LineChartData"
    />

</template>
