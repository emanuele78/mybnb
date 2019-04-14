<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateUsersTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'users', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('email')->unique();
				$table->string('password');
				$table->string('nickname')->unique();
				$table->tinyInteger('is_admin')->default(0);
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('users');
		}
	}
