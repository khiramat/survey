<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Chapter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chapters')->insert([
            'chapter_no' => '1',
            'chapter_name' => '和をもって尊く',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '2',
            'chapter_name' => '礼儀',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '3',
            'chapter_name' => '誠実',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '4',
            'chapter_name' => '積極性',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '5',
            'chapter_name' => '開示',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '6',
            'chapter_name' => '当事者意識',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '7',
            'chapter_name' => '責任',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        DB::table('chapters')->insert([
            'chapter_no' => '8',
            'chapter_name' => '学びと遊び',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

    }
}
