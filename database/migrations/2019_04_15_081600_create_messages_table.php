<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateMessagesTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'messages', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('apartment_id');
				$table->unsignedBigInteger('user_id');
				$table->text('body');
				$table->foreign('apartment_id')->references('id')->on('apartments');
				$table->foreign('user_id')->references('id')->on('users');
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('messages');
		}
	}
