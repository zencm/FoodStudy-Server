<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	class AddApiAuthTokenToUsersTable extends Migration{
		public function up(){
			Schema::table(
				'users', function( Blueprint $table ){
				
				
				if( !Schema::hasColumn('users', 'api_token') )
					$table->string('api_token', 80)->after('password')
					      ->unique()
					      ->nullable()
					      ->default(null)
					;
				
			}
			);
		}
		
		public function down(){
			Schema::table(
				'users', function( Blueprint $table ){
				//
			}
			);
		}
	}
