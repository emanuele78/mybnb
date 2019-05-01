<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreatePromotionPlansTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'promotion_plans', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->string('card_type',20);
				$table->string('name',50);
				$table->float('price_per_day', 5, 2);
				$table->tinyInteger('max_length');
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('promotion_plans');
		}
	}
