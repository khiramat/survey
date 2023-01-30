<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Question extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'chapter_no' => '1',
            'question' => '業務と人間関係を円滑にするための協調性があり、他者の話や提案に耳を傾け、相手の意思を尊重しようとしますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '1',
            'question' => '掛け替えの無い存在になるというビジョンを意識して、自己と他者の関わりの質と量を高めようとされてますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '1',
            'question' => '感情的に不安定だったり、不機嫌な態度や、威圧的、利己的、一方的、あるいは悪口を言うなどして、安心して対話が出来ないと感じることはありますか？',
            'sort_no' => '3',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '2',
            'question' => '朝礼、出退社時、外出時や、日々の業務の中で、丁寧で明るい挨拶をしますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '2',
            'question' => '清潔感や信頼感を感じる身なりや振る舞いを心がけ、社内外に良いイメージを与えていますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '2',
            'question' => '業務中に何をやっているかが分かりやすく、また連絡の際のレスポンスは早く、スムーズかつ円滑に業務連携できますか？',
            'sort_no' => '3',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '3',
            'question' => '感謝の言葉を述べたり、誤った際は素直に非を認めるなど、相手へのリスペクトを言葉や形に出来てますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '3',
            'question' => '社内のルールや期限などの決めごとに対して不平不満などを述べず、誠実にその内容を遵守してますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '3',
            'question' => '合理的な理由が説明されること無く、仕事の依頼や相談事を断ることがありますか？',
            'sort_no' => '3',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '4',
            'question' => '自発的に考えて行動することと、その自分の考えや行いを効果的に他者に伝えるなどして興味関心を誘い、全体の積極性向上に貢献されてますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '4',
            'question' => '問題発生時や会議に参加した際に、積極的かつ意欲的に発言したり、課題解決のための提案をしますか？？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '5',
            'question' => '会社や自身の業務に関わる事を開示し、安心できる環境を作ろうという姿勢を感じますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '5',
            'question' => '社内で開示される情報に対して興味を示し、その情報を情報を活かして他者と連携しようという姿勢を感じますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '6',
            'question' => '周囲に自分を委ねず、自身が関わる範囲や領域を自ら拡げ、自己とチームをセルフマネジメントしてますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '6',
            'question' => '自発的に無駄の排除や経費削減を行い、利益伸長、仕事の効率化を加速させるなどの経営努力を行ってますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '6',
            'question' => '私は関係無い、私は知らないというな当事者意識に欠ける発言をしたり、他者との距離を感じさせることはありますか？',
            'sort_no' => '3',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '7',
            'question' => '自身の役割に対する責任を自覚し、仲間を助け、企業価値向上に貢献することができてますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '7',
            'question' => '自分の責任から逃げたり、他者に責任を押し付けること無く、未経験分野や苦手な業務にも前向きに取り組みますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '8',
            'question' => '学びや遊びの社内行事企画や運営に関わり、お互いの成長やコミュニケーションの活性化を推進してますか？',
            'sort_no' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('questions')->insert([
            'chapter_no' => '8',
            'question' => '気づいたことや学んだことを共有し、個人やチームとしての挑戦や成長の喜びを分かち合ってますか？',
            'sort_no' => '2',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }
}
