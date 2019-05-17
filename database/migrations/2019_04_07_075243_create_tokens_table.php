<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateTokensTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			if (!Schema::hasTable('tokens')) {
				// create the table
				Schema::create(
				  'tokens', function (Blueprint $table) {
					
					$table->increments('id');
					$table->string('token_code')->unique();
					$table->string('email');
					$table->dateTime('expiration')->nullable();
					$table->timestamps();
				});
			}
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			//never drop the table
			//			Schema::dropIfExists('tokens');
		}
		
	}
