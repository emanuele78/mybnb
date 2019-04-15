<?php
	
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class ServicesTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$services = [
			  'aria condizionata',
			  'bagno privato',
			  'tv satellitare',
			  'set cortesia',
			  'culla',
			  'animali in casa',
			  'pulizia giornaliera',
			  'colazione compresa',
			  'trasporto privato',
			  'WiFi',
			  'piscina privata',
			  'giardino',
			  'parcheggio privato',
			  'servizio lavanderia',
			  'parco giochi',
			  'vicino alla metro',
			  'assistenza per tour',
			  'portineria',
			  'terrazza',
			  'articoli da bagno'
			];
			$now = Carbon::now();
			foreach ($services as $service) {
				
				DB::table('services')->insert(
				  [
					'name' => $service,
					'created_at' => $now,
					'updated_at' => $now
				  ]);
			}
		}
	}
