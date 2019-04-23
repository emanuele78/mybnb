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
				$table->unsignedBigInteger('apartment_id');
				$table->unsignedBigInteger('started_by');
				$table->timestamps();
				$table->foreign('apartment_id')->references('id')->on('apartments');
				$table->foreign('started_by')->references('id')->on('users');
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
