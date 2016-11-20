<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('links')->insert([
	        [
	            'link_name' => '百度',
	           	'link_title' => '百度一下，你就知道',
	           	'link_url' => 'http://www.baidu.com',
	           	'link_order' => 1,
	       	],
	        [
	            'link_name' => '谷歌',
	           	'link_title' => '全球最流行的搜索网站',
	           	'link_url' => 'http://www.google.com',
	           	'link_order' => 2,
	       	]
       	]);
    }
}
