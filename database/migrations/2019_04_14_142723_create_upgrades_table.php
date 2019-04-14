<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateUpgradesTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'upgrades', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('apartment_id');
				$table->unsignedBigInteger('service_id');
				$table->float('price_per_night', 5, 2);
				$table->timestamps();
				$table->foreign('apartment_id')->references('id')->on('apartments');
				$table->foreign('service_id')->references('id')->on('services');
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('upgrades');
		}
	}
