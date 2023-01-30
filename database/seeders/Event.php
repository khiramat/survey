<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Event extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'event_date' => '2022-10-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2022-11-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2022-11-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2023-01-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2023-02-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2023-03-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2023-04-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2023-05-01',
        ]);
        DB::table('events')->insert([
            'event_date' => '2023-06-01',
        ]);
    }
}
