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
				$table->unsignedBigInteger('thread_id');
				$table->unsignedBigInteger('recipient_user_id');
				$table->unsignedBigInteger('sender_user_id');
				$table->text('body');
				$table->tinyInteger('unreaded')->default(1);
				$table->foreign('thread_id')->references('id')->on('threads');
				$table->foreign('recipient_user_id')->references('id')->on('users');
				$table->foreign('sender_user_id')->references('id')->on('users');
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
