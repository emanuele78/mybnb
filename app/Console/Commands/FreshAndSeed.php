<?php
	
	namespace App\Console\Commands;
	
	use Illuminate\Console\Command;
	
	class FreshAndSeed extends Command {
		
		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'manu:reset';
		
		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Execute migrate fresh followed by db seed';
		
		/**
		 * Create a new command instance.
		 *
		 * @return void
		 */
		public function __construct() {
			
			parent::__construct();
		}
		
		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle() {
			
			$this->line('Migrate fresh started');
			exec('php artisan migrate:fresh');
			$this->line('Migrate fresh finished');
			$this->line('Seeding started');
			exec('php artisan db:');
			$this->line('Seeding finished');
		}
	}
