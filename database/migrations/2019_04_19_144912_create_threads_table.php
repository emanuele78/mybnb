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
				$table->unsignedBigInteger('started_by');
				$table->unsignedBigInteger('apartment_id');
				$table->timestamps();
				$table->foreign('started_by')->references('id')->on('user');
				$table->foreign('apartment_id')->references('id')->on('apartment');
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
