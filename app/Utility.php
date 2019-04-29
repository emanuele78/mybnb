<?php
	
	namespace App;
	
	use Carbon\Carbon;
	
	class Utility {
		
		/**
		 * Utility function to convert date time in locale
		 *
		 * @param $value
		 * @param $addTime
		 * @return string
		 */
		public static function dateTimeLocale(string $value, bool $addTime): string {
			
			$d = Carbon::createFromFormat('Y-m-d H:i:s', $value);
			$d->setTimezone('Europe/Rome');
			if ($addTime) {
				return $d->format('d-m-Y H:i');
			}
			return $d->format('d-m-Y');
		}
		
		/**
		 * Utility function to count days between two string date
		 *
		 * @param string $firstDate
		 * @param string $lastDate
		 * @return mixed
		 */
		public static function diffInDays(string $firstDate, string $lastDate) {
			
			return Carbon::createFromFormat('Y-m-d H:i:s', $lastDate)->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $firstDate));
		}
	}
