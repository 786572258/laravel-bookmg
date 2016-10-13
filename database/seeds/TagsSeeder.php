<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'php',
                'number' => '4',
            ],
            [
                'name' => 'mysql',
                'number' => '3',
            
            ],
            
        ];
        DB::table('tags')->insert($data);
    }
}
