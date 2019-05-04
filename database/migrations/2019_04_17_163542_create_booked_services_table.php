<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateBookedServicesTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'booked_services', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('booking_id');
				$table->string('name', 40);
				$table->string('slug');
				$table->float('price_per_night', 5, 2);
				$table->timestamps();
				$table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('booked_services');
		}
	}
