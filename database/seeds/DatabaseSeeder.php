<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		 $this->call('UserSeeder');
		 $this->call('SystemSeeder');
		 $this->call('BookSeeder'); 
		 $this->call('CategorySeeder'); 
		 $this->call('LinksSeeder'); 
		 $this->call('NavigationSeeder'); 
		 $this->call('TagsSeeder'); 
	}

}
