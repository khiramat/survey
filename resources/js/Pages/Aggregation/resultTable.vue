<script setup>
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
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
    check_event_end: Object,
    selectValue: Number,
});

const point_users = point_user(props.selectValue);
function point_user(event_id) {
    var point_obj = [];
    Object.keys(props.questions).forEach(function (key) {
        const question = props.questions[key];
        const question_id = question.id;
        const point_user_ary = props.total_points.filter((u) => u.event_id === event_id && u.question_id === question_id && u.user_id !== 0); // 選択された実施年月で連想配列から対象レコードを選択
        var last_obj = [];
        Object.keys(point_user_ary).forEach(function (key) {
            const val = this[key];
            const result_array = {
                'point': val.point
            };
            last_obj.push(result_array);
        }, point_user_ary);
        point_obj.push(last_obj)
    },props.questions);
    return point_obj
};

const total_point_users = total_point_user(props.selectValue);
function total_point_user(event_id) {
    const total_point_user_ary = props.sum_total_points.filter((u) => u.event_id === event_id && u.user_id !== 0); // 選択された実施年月で連想配列から対象レコードを選択
    var last_obj = [];
    Object.keys(total_point_user_ary).forEach(function (key) {
        const val = this[key];
        const result_array = {
            'point': val.point
        };
        last_obj.push(result_array);
    }, total_point_user_ary);
    return last_obj
};


const majority_points = majority_point(props.selectValue);
function majority_point(event_id) {
    const majority_point_ary = props.majorities.filter((u) => u.event_id === event_id); // 選択された実施年月で連想配列から対象レコードを選択
    return majority_point_ary
};

const majority_company_points = majority_company_point(props.selectValue);
function majority_company_point(event_id) {
    const majority_company_point_ary = props.avg_majorities.filter((u) => u.event_id === event_id); // 選択された実施年月で連想配列から対象レコードを選択
    return majority_company_point_ary
};


const total_additions = total_addition_f(props.selectValue);
function total_addition_f(event_id) {
    const total_point_user_ary = props.total_addition.filter((u) => u.event_id === event_id); // 選択された実施年月で連想配列から対象レコードを選択
    var last_obj = [];
    Object.keys(total_point_user_ary).forEach(function (key) {
        const val = this[key];
        const result_array = {
            'event_id': val.event_id,
            'user_id': val.user_id,
            'total_point': val.mvv_point + val.maj_point,
        };
        last_obj.push(result_array);
    }, total_point_user_ary);
    return last_obj
};


const total_points_companies = total_points_company(props.selectValue);
function total_points_company(event_id) {
    const all_total_point_ary = props.total_points_companies.filter((u) => u.event_id === event_id); // 選択された実施年月で連想配列から対象レコードを選択
    return all_total_point_ary
};

const stddev_ary = stddev_array();
function stddev_array() {
    var last_obj = [];
    Object.keys(total_additions).forEach(function (key) {
        const val = this[key];
        const result_array = val.total_point
        last_obj.push(val.total_point);
    },total_additions);
    return last_obj
};



const total_avg_point = total_avg_cal_all(props.selectValue)
function total_avg_cal_all(id) {
    const companies_summary = props.total_points_companies_summary.filter((u) => u.event_id === id);
    const total_companies_summary = companies_summary[0].summarise_point
    return total_companies_summary
}


const total_point_rankings = total_point_ranking()
function total_point_ranking() {
    const sorted = stddev_ary.slice().sort(function (a, b) {
        return b - a
    });
    const ranks = stddev_ary.slice().map(function (x) {
        return sorted.indexOf(x) + 1
    });
    return ranks
}



// 標準偏差の計算
const stdev = Math.round(calcStd(stddev_ary))
function calcStd(data) {
    const variance = arr => {
        const avr = arr.reduce((a, b) => a + b) / arr.length;
        return arr.reduce((a, c) => (a + ((c - avr) ** 2)), 0) / arr.length;
    };
    const stdev = arr => Math.sqrt(variance(arr));
    return stdev(data);    // 分散の平方根
}

const company_total = Number(total_avg_point) + Number(majority_company_points[0].avg_point);


</script>

<template>
    <div class="table-responsive">
        <table class="table table-bordered text-nowrap" style="width: 99%">
            <tbody v-for="(question, index) in questions" :key="question">
            <tr>
                <th colspan="100" style="background-color: #cbd4ff; text-align: left">{{ questions[index].id }}. {{ questions[index].question }}</th>
            </tr>
            <tr>
                <td style="background-color: #cccccc; text-align: center">会社平均</td>
                <td v-for="user in users" :key="user.id" style="text-align: center">{{user.name.split(' ')[0] }}</td>
            </tr>
            <tr>
                <td style="text-align: right; font-weight: bold; background-color: #cccccc">{{ total_points_companies[index].point }}</td>
                <td v-for="point in point_users[index]" :key="point.point"
                    style="text-align: right">{{ point.point }}
                    <br>
                    <span v-if="point.point - total_points_companies[index].point < 0"
                          style="color: red">{{Math.round((point.point - total_points_companies[index].point)* Math.pow(10, 2)) / Math.pow(10, 2)}}</span>
                    <span v-else="point.point - total_points_companies[index].point > 0"
                        style="color: blue">{{ Math.round((point.point - total_points_companies[index].point)* Math.pow(10, 2)) / Math.pow(10, 2)}}</span>
                </td>
            </tr>
            </tbody>
            <tbody>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom: 20px"> </div>
    <div class="table-responsive">
        <table class="table table-bordered text-nowrap" style="width: 99%">
            <thead>
            <tr>
                <th style="background-color: #4a5568; color: white">集計項目</th>
                <th style="background-color: #4a5568; color: white">会社平均</th>
                <th v-for="user in users" :key="user.id" style="background-color: #4a5568; color: white">{{user.name }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="text-align: right">MVVスコア</td>
                <td style="text-align: right; font-weight: bold; background-color: #e5e9ff">{{ total_avg_point }}</td>
                <td v-for="total_point_user in total_point_users" :key="total_point_users"
                    style="text-align: right; font-weight: bold; background-color: #cbd4ff">{{
                        total_point_user.point
                    }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right">過半数回答付加点</td>
                <td style="text-align: right; background-color: #aebfff; font-weight: bold;">
                    {{ majority_company_points[0].avg_point }}
                </td>
                <td v-for="majority_point_result in majority_points" :key="majority_points"
                    style="text-align: right; background-color: #8fabff; font-weight: bold;">
                    {{ majority_point_result.point }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right">合計点</td>
                <td style="text-align: right; background-color: #6998ff; color: white; font-weight: bold;">
                    {{ company_total}}
                </td>
                <td v-for="all_total_point_user in total_additions" :key="total_additions"
                    style="text-align: right; font-weight: bold; background-color: #2e85ff; color: white">
                    {{ all_total_point_user.total_point }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right">偏差値（全社平均は標準偏差）</td>
                <td style="text-align: right; background-color: #d4fcd7; font-weight: bold;">{{ stdev }}</td>
                <td v-for="stddevs in stddev_ary" :key="stddev_ary"
                    style="text-align: right; font-weight: bold; background-color: #90d285; color: white">
                    {{ Math.round((stddevs - company_total) / stdev * 10 + 50) }}
                </td>
                <!-- 偏差値＝（個人の得点-平均点）/ 標準偏差 × 10 + 50 -->
            </tr>
            <tr>
                <td style="text-align: right">偏差値順位</td>
                <td style="text-align: right; background-color: #d5abb7; color: white; font-weight: bold;">-</td>
                <td v-for="total_point_ranking in total_point_rankings" :key="total_point_rankings"
                    style="text-align: right; font-weight: bold; background-color: #b88ea6; color: white">
                    {{ total_point_ranking }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
