<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateImagesTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'images', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('apartment_id');
				$table->string('name');
				$table->timestamps();
				$table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('images');
		}
	}
