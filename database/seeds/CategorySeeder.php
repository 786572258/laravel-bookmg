<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'cate_name' => '计算机编程类',
                'as_name' => '计算机编程类',
                'parent_id' => '0',
                'seo_title' => '计算机编程类',
                'seo_key' => '计算机编程类',
                'seo_desc' => '计算机编程类',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ],
            [
                'cate_name' => '生活百科',
                'as_name' => '生活百科',
                'parent_id' => '0',
                'seo_title' => '生活百科',
                'seo_key' => '生活百科',
                'seo_desc' => '生活百科',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ],
        ];
        DB::table('category')->insert($data);
    }
}
