<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateThreadsTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'threads', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->string('reference_id');
				$table->unsignedBigInteger('apartment_id');
				$table->unsignedBigInteger('with_user_id');
				$table->foreign('apartment_id')->references('id')->on('apartments');
				$table->foreign('with_user_id')->references('id')->on('users');
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('threads');
		}
	}
