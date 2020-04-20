<?php

use Illuminate\Database\Seeder;

class FSDataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
    	
    	// TODO: upgrade with proper testing structures akin to main DataTypesTableSeeder
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2020-04-20 22:46:17',
                'updated_at' => '2020-04-20 23:02:32',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2020-04-20 22:46:17',
                'updated_at' => '2020-04-20 22:46:17',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2020-04-20 22:46:17',
                'updated_at' => '2020-04-20 22:46:17',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'fs_studies',
                'slug' => 'fs-studies',
                'display_name_singular' => 'Study',
                'display_name_plural' => 'Studies',
                'icon' => 'voyager-lighthouse',
                'model_name' => 'App\\FSStudy',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2020-04-20 22:50:43',
                'updated_at' => '2020-04-20 23:06:33',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'fs_bls',
                'slug' => 'fs-bls',
                'display_name_singular' => 'BLS Entry',
                'display_name_plural' => 'BLS Entries',
                'icon' => 'voyager-database',
                'model_name' => 'App\\FSBLS',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":"id","order_display_column":null,"order_direction":"asc","default_search_key":"name_de","scope":null}',
                'created_at' => '2020-04-20 23:11:59',
                'updated_at' => '2020-04-20 23:20:12',
            ),
        ));
        
        
    }
}
