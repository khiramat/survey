<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {usePage} from '@inertiajs/inertia-vue3'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps({
    chapters: Array,
    questions: Array,
    events: Object,
    answers: Array,
    users: Array,
    request: Object,
});

function events_id_null(){
    if(props.events == null){
        var event_id = 0
    } else {
        var event_id = props.events.id
    }
    return event_id
}
const event_id = events_id_null()

const user_number_total = Object.values(props.users).length
// 評価対象メンバー選別 毎回ランダムなオーダーでユーザー情報が連携される
function target_user() {
    var target_user_id_obj = [];
    Object.keys(props.users).forEach(function (key) {
        const val = this[key]; // this は answer_group_by_user
        const result_array = val.id;
        target_user_id_obj.push(result_array);
    }, props.users);

    const user_id = usePage().props.value.auth.user.id; // ログインしているユーザーの User_id

    const none_target_user = props.answers.filter((u) => u.event_id === event_id && u.user_id === user_id); // すべての回答から今回のサーベイで入力済みのユーザーを選択（入力済みなので対象外とするため)
    if (none_target_user == null) { // すべての回答から入力済みのユーザーがいなかった場合、全てのユーザーを評価対象とする
        var difference = target_user_id_obj;
    } else { // 入力済みのユーザーがいる場合、差分をとって未入力ユーザーのみ取り出す
        var none_target_user_obj = [];
        Object.keys(none_target_user).forEach(function (key) {
            const val = this[key];
            const result_array = val.respondent_user_id;
            none_target_user_obj.push(result_array);
        }, none_target_user);
        var difference = target_user_id_obj.filter(x => none_target_user_obj.indexOf(x) === -1); // 差分を抽出
    }

    if(difference.length == 0){ // 全て入力済みの場合、ダミーのユーザーデータを設定し、表示の制御を行う。ダミーを設定しないとエラーになるため
        var difference = [{'id':9999, 'name': '制御用'}];
    }
    return difference;
};
const target_users = target_user();
const user_number_target = Object.values(target_users).length

function user_name_search() {// ユーザーIDから名前を特定する関数。対象者がいない場合ダミーのユーザーを設定し制御用とする
    const user_id = target_users[0]
    var user = props.users.filter((u) => u.id === user_id);
    if(user.length == 0){
        user = [{'id':9999, 'name': '制御用'}]
    }
    return user
}
const target_user_disp = user_name_search()

const form = useForm({
    event_id: event_id,
    user_id: usePage().props.value.auth.user.id,
    respondent_user_id: target_user_disp[0].id,
    respondent_user_name: target_user_disp[0].name,
    answers1: '',
    answers2: '',
    answers3: '',
    answers4: '',
    answers5: '',
    answers6: '',
    answers7: '',
    answers8: '',
    answers9: '',
    answers10: '',
    answers11: '',
    answers12: '',
    answers13: '',
    answers14: '',
    answers15: '',
    answers16: '',
    answers17: '',
    answers18: '',
    answers19: '',
    answers20: '',
});

const submit = () => {
    form.post(route('answer_store'));
};

const respondent_user_id_disp = target_user_disp[0].id;

// 評価対象者がいない場合、といる場合で v-if 用の変数を設定する
function disp_items() {
    if (respondent_user_id_disp == 9999 || props.events == null) {
        var disp = true
    } else {
        var disp = false
    }
    return disp
}
const disp_item = disp_items()

</script>
<template>
    <Head title="Answer"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                MVVサーベイ入力ページ
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="disp_item">
                        <div class="p-6 bg-white border-b border-gray-200">
                           <span style="font-weight: bold;font-size: 20px">すべての入力が完了しました。</span>お疲れさまでした。
                        </div>
                    </div>
                    <div v-if="!disp_item">
                    <form @submit.prevent="submit">
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{ events.event_date.split('-')[0] }}年{{ events.event_date.split('-')[1] }}月のMVVサーベイです。　
                            <span style="font-weight: bold;font-size: 20px">{{ target_user_disp[0].name }}</span>さんに対して以下の質問に回答してください。 対象者{{ user_number_total }}人中、残りは{{ target_user_disp[0].name }}さんを含め{{user_number_target}}人です。
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <table>
                                <thead>
                                <tr style="background-color: #b0c4de">
                                    <th>No.</th>
                                    <th>質問</th>
                                    <th>回答</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[0].chapter_no }}条 {{ chapters[0].chapter_name }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[0].id }}</td>
                                    <td>{{ questions[0].question }}</td>
                                    <td>
                                        <div style="font-size: 12px; white-space: nowrap">
                                            <input type="radio" id="answers1" name="answers1" v-model="form.answers1" value="1" required /><label>はい</label>
                                            <input type="radio" id="answers1" name="answers1" v-model="form.answers1" value="0"/><label>いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[1].id }}</td>
                                    <td>{{ questions[1].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" id="answers2" name="answers2" v-model="form.answers2" value="1" required/>
                                             <label for="one">はい</label>
                                            <input type="radio" id="answers2" name="answers2" v-model="form.answers2" value="0"/>
                                             <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[2].id }}</td>
                                    <td>{{ questions[2].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers3" v-model="form.answers3" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers3" v-model="form.answers3" value="0" />
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[1].chapter_no }}条 {{ chapters[1].chapter_name }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ questions[3].id }}</td>
                                    <td>{{ questions[3].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers4" v-model="form.answers4" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers4" v-model="form.answers4" value="0" />
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[4].id }}</td>
                                    <td>{{ questions[4].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers5" v-model="form.answers5" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers5" v-model="form.answers5" value="0" />
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[5].id }}</td>
                                    <td>{{ questions[5].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers6" v-model="form.answers6" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers6" v-model="form.answers6" value="0" />
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[2].chapter_no }}条 {{ chapters[2].chapter_name }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ questions[6].id }}</td>
                                    <td>{{ questions[6].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers7" v-model="form.answers7" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers7" v-model="form.answers7" value="0" />
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[7].id }}</td>
                                    <td>{{ questions[7].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers8" v-model="form.answers8" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers8" v-model="form.answers8" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[8].id }}</td>
                                    <td>{{ questions[8].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers9" v-model="form.answers9" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers9" v-model="form.answers9" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[3].chapter_no }}条 {{ chapters[3].chapter_name }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ questions[9].id }}</td>
                                    <td>{{ questions[9].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers10" v-model="form.answers10" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers10" v-model="form.answers10" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[10].id }}</td>
                                    <td>{{ questions[10].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers11" v-model="form.answers11" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers11" v-model="form.answers11" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[4].chapter_no }}条 {{ chapters[4].chapter_name }}</td>
                                    <td style="text-align: right; font-weight: bold"></td>
                                </tr>
                                <tr>
                                    <td>{{ questions[11].id }}</td>
                                    <td>{{ questions[11].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers12" v-model="form.answers12" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers12" v-model="form.answers12" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[12].id }}</td>
                                    <td>{{ questions[12].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers13" v-model="form.answers13" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers13" v-model="form.answers13" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[5].chapter_no }}条 {{ chapters[5].chapter_name }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ questions[13].id }}</td>
                                    <td>{{ questions[13].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers14" v-model="form.answers14" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers14" v-model="form.answers14" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[14].id }}</td>
                                    <td>{{ questions[14].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers15" v-model="form.answers15" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers15" v-model="form.answers15" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[15].id }}</td>
                                    <td>{{ questions[15].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers16" v-model="form.answers16" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers16" v-model="form.answers16" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[6].chapter_no }}条 {{ chapters[6].chapter_name }}</td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[16].id }}</td>
                                    <td>{{ questions[16].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers17" v-model="form.answers17" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers17" v-model="form.answers17" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[17].id }}</td>
                                    <td>{{ questions[17].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers18" v-model="form.answers18" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers18" v-model="form.answers18" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="background-color: #e6e6fa; font-weight: bold">
                                    <td colspan="2">第{{ chapters[7].chapter_no }}条 {{ chapters[7].chapter_name }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ questions[18].id }}</td>
                                    <td>{{ questions[18].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers19" v-model="form.answers19" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers19" v-model="form.answers19" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ questions[19].id }}</td>
                                    <td>{{ questions[19].question }}</td>
                                    <td>
                                        <div style="font-size: 12px">
                                            <input type="radio" name="answers20" v-model="form.answers20" value="1" required/>
                                            <label for="one">はい</label>
                                            <input type="radio" name="answers20" v-model="form.answers20" value="0"/>
                                            <label for="two">いいえ</label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <PrimaryButton>
                                {{ target_user_disp[0].name }}さんへの回答を実行
                            </PrimaryButton>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
