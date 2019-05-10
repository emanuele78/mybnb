<?php
	
	namespace App\Console\Commands;
	
	use Illuminate\Console\Command;
	
	class ClearAll extends Command {
		
		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'manu:clear';
		
		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Execute all clear commands';
		
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
			
			$this->line('Clear route');
			exec('php artisan route:clear');
			$this->line('Clear config');
			exec('php artisan config:clear');
			$this->line('Clear cache');
			exec('php artisan cache:clear');
			$this->line('Done');
		}
	}
