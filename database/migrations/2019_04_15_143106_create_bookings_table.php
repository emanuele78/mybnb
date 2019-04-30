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
				$table->string('reference')->unique();
				$table->string('status', 20);
				
				$table->unsignedBigInteger('user_booking_id');
				$table->string('user_booking_nickname');
				$table->string('user_booking_fullname');
				$table->string('user_booking_address');
				$table->string('user_booking_full_locality');
				$table->string('user_booking_email');
				
				$table->unsignedBigInteger('apartment_id');
				$table->string('apartment_title');
				$table->string('apartment_slug');
				$table->unsignedBigInteger('apartment_owner_id');
				$table->string('apartment_owner_nickname');
				$table->string('apartment_owner_fullname');
				$table->string('apartment_owner_address');
				$table->string('apartment_owner_full_locality');
				$table->string('apartment_owner_email');
				$table->string('apartment_image');
				
				$table->date('check_in');
				$table->date('check_out');
				$table->string('special_requests')->nullable();
				$table->float('apartment_price_per_night', 8, 2);
				$table->timestamps();
				$table->foreign('apartment_id')->references('id')->on('apartments');
				$table->foreign('user_booking_id')->references('id')->on('users');
				$table->foreign('apartment_owner_id')->references('id')->on('users');
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
