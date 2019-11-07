<?php

use Illuminate\Database\Seeder;

class TagCategoriesSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tag_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('tag_categories')->insert([
            [
                'name' => 'front',
            ],
            [
                'name' => 'back',
            ],
            [
                'name' => 'infra',
            ],
            [
                'name' => 'others',
            ],
        ]);
    }
}

