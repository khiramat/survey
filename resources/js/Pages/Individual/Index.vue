<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
const selectValue = ref(0);

const props = defineProps({
    questions: Object,
    events: Object,
    majorities: Object,
    total_points: Object,
    sum_total_points: Object,
    total_addition: Object,
    users: Object,
    total_points_companies_summary: Object,
    avg_majorities: Object,
});

// 備忘録 ユーザ情報取得、Users レコードからユーザー集取得
//    const user_id = usePage().props.value.auth.user.id;
//    const len = Object.values(props.users).length - 1;

import resultTable from './resultTable.vue'
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
                メンバースコア推移
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                       メンバー各自のMVVサーベイ結果を表示します。下のセレクトボックスから表示したいメンバーを選択してください。
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <select @change="selectEvent" id="selectedEventId" v-model="selectValue">
                            <option value='0' selected>メンバーを選択してください</option>
                            <option v-for="user in users" v-bind:value="user.id">{{user.name}}</option>
                        </select>
                    </div>
                    <div v-if="selectValue > 0">
                    <resultTable :key="componentKey" v-model:questions="questions" v-model:events="events" v-model:majorities="majorities" v-model:total_points="total_points" v-model:sum_total_points="sum_total_points" v-model:total_addition="total_addition" v-model:users="users"  v-model:selectValue="selectValue" v-model:total_points_companies_summary="total_points_companies_summary" v-model:avg_majorities="avg_majorities" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
