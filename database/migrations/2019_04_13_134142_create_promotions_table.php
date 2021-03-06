<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreatePromotionsTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'promotions', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('apartment_id')->nullable();
				$table->string('reference');
				$table->unsignedBigInteger('promotion_plan_id');
				$table->dateTime('start_at');
				$table->dateTime('end_at');
				$table->timestamps();
				$table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null');
				$table->foreign('promotion_plan_id')->references('id')->on('promotion_plans');
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('promotions');
		}
	}
