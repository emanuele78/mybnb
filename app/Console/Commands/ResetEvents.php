<?php
	
	namespace App\Console\Commands;
	
	use App\Utility;
	use Illuminate\Console\Command;
	
	class ResetEvents extends Command {
		
		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'manu:resetevents';
		
		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Truncate table events';
		
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
			
			Utility::clearEvents();
			$this->line('Events reset');
		}
	}
