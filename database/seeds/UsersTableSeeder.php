<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('users')->insert([
            [
                'name'          => '坂田 聖史',
                'slack_user_id' => 'AAAAAAAAA',
                'email'         => 'hoge@gmail.com',
                'avatar'        => null,
                'created_at'    => Carbon::create(2017, 12, 3),
            ],
            [
                'name'          => 'Daichi Ando',
                'slack_user_id' => 'U5L6XL5KJ',
                'email'         => 'a24arc.ad@gmail.com',
                'avatar'        => 'https://avatars.slack-edge.com/2019-01-11/521652138498_a80d324258d73c87ad2e_192.jpg',
                'created_at'    => Carbon::create(2017, 4, 3),
            ],
            [
                'name'          => '金谷 翔平',
                'slack_user_id' => 'CCCCCCCCC',
                'email'         => 'foo@gmail.com',
                'avatar'        => null,
                'created_at'    => Carbon::create(2017, 7, 16),
            ]
        ]);
    }
}

