<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateBookingsTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'bookings', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('apartment_id');
				$table->unsignedBigInteger('user_id');
				$table->string('apartment_title');
				$table->string('user_nickname');
				$table->date('check_in');
				$table->date('check_out');
				$table->string('special_requests');
				$table->float('apartment_amount', 8, 2);
				$table->timestamps();
				$table->foreign('apartment_id')->references('id')->on('apartments');
				$table->foreign('user_id')->references('id')->on('users');
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('bookings');
		}
	}
