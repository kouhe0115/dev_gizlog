<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DailyReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('daily_reports')->truncate();

        DB::table('daily_reports')->insert([
            [
                'user_id' => 1,
                'title' => 'テスト投稿１',
                'content' => 'テスト投稿１です',
                'reporting_time' => Carbon::create(2019, 10, 30),
            ],
            [
                'user_id' => 1,
                'title' => 'テスト投稿２',
                'content' => 'テスト投稿２です',
                'reporting_time' => Carbon::create(2019, 10, 30),
            ],
            [
                'user_id' => 1,
                'title' => 'テスト投稿３',
                'content' => 'テスト投稿３です',
                'reporting_time' => Carbon::create(2019, 10, 30),
            ],
        ]);
    }
}
