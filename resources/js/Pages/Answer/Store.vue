<template>
    <Head title="Answer"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                MVVサーベイ入力完了ページ
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div style="padding: 10px">{{respondent_user_name}}さんのサーベイ入力が完了しました</div>
                </div>
                <div style="padding: 10px"> </div>
                <form @submit.prevent="submit">
                <PrimaryButton>
                    次のメンバーの評価を行う
                </PrimaryButton>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const props = defineProps({
    respondent_user_name: String
    }
)

const form = useForm({
    user_id: usePage().props.value.auth.user.id,
});

const submit = () => {
    form.post(route('answer'));
};

</script>

<style scoped>

</style>
