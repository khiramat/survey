<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
const selectValue = ref(0);
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
});

// 備忘録 ユーザ情報取得、Users レコードからユーザー集取得
//    const user_id = usePage().props.value.auth.user.id;
//    const len = Object.values(props.users).length - 1;

import resultTable from './resultTable.vue'
import All from './All.vue'
const componentKey = ref(0);

const selectEvent = () => {
    var selectedEventId = document.getElementById("selectedEventId").value;
    componentKey.value = selectedEventId;
};
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ $page.props.auth.user.name }}さんのMVVサーベイ結果です
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <select @change="selectEvent" id="selectedEventId" v-model="selectValue">
                            <option value='0' selected>表示する年月を選択してください</option>
                            <option v-for="event in events" v-bind:value="event.id">{{ event.event_date.split('-')[0] }}年{{ event.event_date.split('-')[1] }}月 （第 {{event.id +1}}回） </option>
                            <option value="99">全てのサーベイ</option>
                        </select>
                    </div>
<!--
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3>MVVサーベイ<span v-if="selectValue != 0 && selectValue != 99  && my_user_id > 5"> 第{{selectValue}}回結果</span></h3>
                    </div>
-->
                    <div v-if="selectValue != 0 && selectValue != 99 && my_user_id > 5">
                        <resultTable :key="componentKey" v-model:chapters="chapters" v-model:questions="questions" v-model:events="events" v-model:majorities="majorities" v-model:avg_majorities="avg_majorities" v-model:total_points="total_points" v-model:total_points_companies="total_points_companies" v-model:total_points_companies_summary="total_points_companies_summary" v-model:sum_total_points="sum_total_points" v-model:total_addition="total_addition" v-model:users="users"  v-model:selectValue="selectValue" />
                    </div>
                    <div v-else-if="selectValue == 99 && my_user_id > 5">
                        <All :key="componentKey" v-model:questions="questions" v-model:events="events" v-model:majorities="majorities" v-model:total_points="total_points" v-model:sum_total_points="sum_total_points" v-model:total_addition="total_addition" v-model:users="users" v-model:avg_majorities="avg_majorities" v-model:total_points_companies_summary="total_points_companies_summary" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
