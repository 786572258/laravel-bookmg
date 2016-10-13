<?php

use Illuminate\Database\Seeder;

class LinksSeeder extends Seeder
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
                'sequence' => '1',
                'name' => '百度',
                'url' => 'http://www.baidu.com',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
               
            ],
            [
                'sequence' => '2',
                'name' => 'CSDN',
                'url' => 'http://www.csdn.com',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ],
            
        ];
        DB::table('links')->insert($data);
    }
}
