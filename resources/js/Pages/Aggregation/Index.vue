<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/inertia-vue3';
import {ref} from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const selectValue = ref(0);

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
    opening_event: Object
//    answers: Object,
});

import resultTable from './resultTable.vue'

const componentKey = ref(0);
const selectEvent = () => {
    var selectedEventId = document.getElementById("selectedEventId").value;
    componentKey.value = selectedEventId;
};

// 開催中のサーベイで全員分の入力が完了したかチェック
const open_event = event_end_flg()

function event_end_flg() {
    const user_numbers = Object.values(props.users).length
    console.log(user_numbers)
    if (Object.values(props.opening_event).length !== 0) {
        const open_event_id = props.opening_event[0].id
        const open_event_date = props.opening_event[0].event_date

/*
        const answers_ary = props.check_event_end.filter((u) => u.event_id === open_event_id); // 選択された実施年月で連想配列から対象レコードを選択
        console.log(answers_ary)
        if(answers_ary.length !== 0){
            const answered_number = answers_ary[0].record_num
            console.log(answered_number)
            const answer_number = user_numbers * (user_numbers - 1) * 20
            console.log(answer_number)
            if (answered_number == answer_number) {
                var end_flg = true
            } else {
                var end_flg = false
            }
            return [end_flg, open_event_id, open_event_date]
        } else {
            return false
        }
*/
        return [open_event_id, open_event_date]
    } else {
        return false
    }
}

console.log(open_event)
const form = useForm({
    event_id: open_event[0],
});

const submit = () => {
    form.post(route('aggregation_summary'));
};

</script>
<link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<template>
    <Head title="全社集計"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                全社集計
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="open_event[0]"
                         class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                         role="alert">
                        <form @submit.prevent="submit">
                            <div class="p-6 bg-white border-b border-gray-200">
                                {{ open_event[1].split('-')[0] }}年{{ open_event[1].split('-')[1] }}月（第
                                {{ open_event[0] + 1 }}回）サーベイの集計を行います。
                                <PrimaryButton>
                                    ここをクリックして集計を行ってください
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                    <div v-if="$page.props.flash.message"
                         class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                         role="alert">
                        <span class="font-medium">{{ $page.props.flash.message }}</span>
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <select @change="selectEvent" id="selectedEventId" v-model="selectValue">
                            <option value='0' selected>表示する年月を選択してください</option>
                            <option v-for="event in events" :value="event.id">{{
                                    event.event_date.split('-')[0]
                                }}年{{ event.event_date.split('-')[1] }}月 （第 {{ event.id + 1 }}回）
                            </option>
                        </select>
                    </div>
                    <div v-if="selectValue > 0">
                        <resultTable :key="componentKey" v-model:questions="questions" v-model:events="events"
                                     v-model:majorities="majorities" v-model:avg_majorities="avg_majorities"
                                     v-model:total_points="total_points"
                                     v-model:total_points_companies="total_points_companies"
                                     v-model:total_points_companies_summary="total_points_companies_summary"
                                     v-model:sum_total_points="sum_total_points" v-model:total_addition="total_addition"
                                     v-model:users="users" v-model:selectValue="selectValue"
                                     v-model:check_event_end="check_event_end"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
