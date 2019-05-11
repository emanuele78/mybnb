<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateCustomersTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			
			Schema::create(
			  'customers', function (Blueprint $table) {
				
				$table->bigIncrements('id');
				$table->unsignedBigInteger('user_id');
				$table->string('customer_id')->unique();
				$table->string('taxCode');
				$table->string('firstName', 100);
				$table->string('lastName', 100);
				$table->string('streetAddress');
				$table->string('locality');
				$table->integer('postalCode');
				$table->timestamps();
				$table->foreign('user_id')->references('id')->on('users');
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			
			Schema::dropIfExists('customers');
		}
	}
