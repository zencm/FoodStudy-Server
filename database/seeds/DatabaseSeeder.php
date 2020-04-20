<?php
	
	use Illuminate\Database\Seeder;
	
	class DatabaseSeeder extends Seeder{
		/**
		 * Seed the application's database.
		 *
		 * @return void
		 */
		public function run(){
			$this->call(FSLogMenuItemSeeder::class);
			$this->call(FSDataTypesTableSeeder::class);
			$this->call(FSDataRowsTableSeeder::class);
		}
	}
