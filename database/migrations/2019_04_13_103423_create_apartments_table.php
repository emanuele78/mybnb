<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateApartmentsTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'apartments', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('user_id');
				$table->string('title');
				$table->string('slug')->unique();
				$table->string('main_image');
				$table->text('description');
				$table->tinyInteger('room_count');
				$table->tinyInteger('people_count');
				$table->tinyInteger('bathroom_count');
				$table->smallInteger('square_meters');
				$table->decimal('latitude',10,7);
				$table->decimal('longitude',10,7);
				$table->float('price_per_night',7,2);
				$table->tinyInteger('max_stay');
				$table->tinyInteger('sale')->default(0);
				$table->tinyInteger('is_showed')->default(1);
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('apartments');
		}
	}
