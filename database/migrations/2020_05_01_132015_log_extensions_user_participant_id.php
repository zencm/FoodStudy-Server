<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	class LogExtensionsUserParticipantId extends Migration{
		public function up(){
			
			
			Schema::table(
				'users', function( Blueprint $table ){
				
				if( !Schema::hasColumn('users', 'fs_participant') )
					$table->string('fs_participant', 128)->after('fs_study')
					      ->nullable()
					      ->default(null)
					;
				
			}
			);
			
			
			
			Schema::table( 'fs_log', function( Blueprint $table ){
				if( !Schema::hasColumn('fs_log', 'data') )
					$table->json('data')
					      ->nullable()
					      ->default(null)
					;
				
				foreach( ['sleep','mood','digestion'] as $k )
					if( Schema::hasColumn('fs_log', $k ) )
						$table->dropColumn( $k );
				
			} );
			
			Schema::table( 'fs_log_food', function( Blueprint $table ){
				if( !Schema::hasColumn('fs_log_food', 'data') )
					$table->json('data')
					      ->nullable()
					      ->default(null)
					;
				
				if( Schema::hasColumn('fs_log_food', 'food' ) )
						$table->dropColumn( 'food' );
			} );
			
			
			Schema::table( 'fs_studies', function( Blueprint $table ){
				if( !Schema::hasColumn('fs_studies', 'question_catalog') )
					$table->json('question_catalog')
					      ->nullable()
					      ->default(null)
					;
			} );
			
			
			
			
			
			
		}
		
		public function down(){
			//
		}
	}
