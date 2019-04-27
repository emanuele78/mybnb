<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class Thread extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Set key for route model binding
		 *
		 * @return string
		 */
		public function getRouteKeyName() {
			
			return 'reference_id';
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function withUser() {
			
			return $this->belongsTo(User::class, 'with_user_id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function messages() {
			
			return $this->hasMany(Message::class);
		}
		
		/**
		 * Return a thread if exists otherwise create new one and return it
		 *
		 * @param int $apartment_id
		 * @param int $with_user_id
		 * @return Thread
		 */
		public static function addIfNotExists(int $apartment_id, int $with_user_id): self {
			
			$thread = Thread::where('apartment_id', $apartment_id)->where('with_user_id', $with_user_id)->get()->first();
			if ($thread) {
				//if thread exists, return it
				return $thread;
			}
			//otherwise create it and return it
			$thread = new Thread();
			$thread->fill(
			  [
				'reference_id' => (string)Str::uuid(),
				'apartment_id' => $apartment_id,
				'with_user_id' => $with_user_id,
			  ])->save();
			return $thread;
		}
		
		/**
		 * Return all the threads for apartment where given user_id is the owner, grouped by apartment
		 *
		 * @param int $user_id
		 * @return array
		 */
		public static function groupedByApartment(int $user_id): array {
			
			$groupedApartments = Thread::whereHas(
			  'apartment', function ($query) use ($user_id) {
				
				$query->where('user_id', $user_id);
			})->whereHas(
			  'messages', function ($query) use ($user_id) {
				
				$query->where('visible_for', $user_id)->orWhere('visible_for', null);
			})->with(['apartment', 'withUser'])->get()->groupBy('apartment_id');
			$apartmentsThreads = [];
			foreach ($groupedApartments->toArray() as $threadsForApartment) {
				$apartmentEntry =
				  [
					'apartment_slug' => $threadsForApartment[0]['apartment']['slug'],
					'apartment_title' => $threadsForApartment[0]['apartment']['title'],
					'apartment_image' => $threadsForApartment[0]['apartment']['main_image'],
					'apartment_has_new_messages' => false,
					'threads' => [],
				  ];
				foreach ($threadsForApartment as $thread) {
					$hasNewMessages = self::hasNewMessages($thread['id'], $user_id);
					$apartmentEntry['threads'][] =
					  [
						'thread_reference' => $thread['reference_id'],
						'with_user' => $thread['with_user']['nickname'],
						'started_at' => self::dateTimeLocale($thread['created_at']),
						'last_message' => self::dateTimeLocale($thread['updated_at']),
						'has_new_messages' => $hasNewMessages,
					  ];
					$apartmentEntry['apartment_has_new_messages'] = $hasNewMessages ? $hasNewMessages : $apartmentEntry['apartment_has_new_messages'];
				}
				$apartmentsThreads[] = $apartmentEntry;
			}
			
			return $apartmentsThreads;
		}
		
		/**
		 * Check if given thread for the given user has new messages
		 *
		 * @param int $thread_id
		 * @param int $user_id
		 * @return bool
		 */
		private static function hasNewMessages(int $thread_id, int $user_id): bool {
			
			return Message::where('thread_id', $thread_id)->where('recipient_id', $user_id)->where(
			  function ($query) use ($user_id) {
				  
				  $query->where('visible_for', $user_id)->orWhere('visible_for', null);
			  })->where('unreaded', 1)->get()->count();
		}
		
		/**
		 * Utility function to covert date time in locale
		 *
		 * @param $value
		 * @return string
		 */
		private static function dateTimeLocale($value) {
			
			$d = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value);
			$d->setTimezone('Europe/Rome');
			return $d->format('d/m/Y H:i');
		}
		
		/**
		 * Return all the threads for apartment to which given user_id asked for info
		 *
		 * @param int $user_id
		 * @return array
		 */
		public static function requestedInfo(int $user_id): array {
			
			$threads = Thread::where('with_user_id', $user_id)->whereHas(
			  'messages', function ($query) use ($user_id) {
				
				$query->where('visible_for', $user_id)->orWhere('visible_for', null);
			})->with('apartment.user')->get();
			
			$userThreads = [];
			foreach ($threads->toArray() as $thread) {
				$threadEntry =
				  [
					'thread_reference' => $thread['reference_id'],
					'apartment_title' => $thread['apartment']['title'],
					'apartment_slug' => $thread['apartment']['slug'],
					'apartment_image' => $thread['apartment']['main_image'],
					'apartment_owner' => $thread['apartment']['user']['nickname'],
					'created_at' => $thread['created_at'],
					'last_message' => $thread['updated_at'],
					'has_new_messages' => self::hasNewMessages($thread['id'], $user_id),
				  ];
				$userThreads[] = $threadEntry;
			}
			return $userThreads;
		}
		
		/**
		 * Show all the visible (not deleted) messages for the given user
		 *
		 * @param User $user
		 * @return array
		 */
		public function getMessages(User $user): array {
			
			$thread = $this->where('reference_id', $this->reference_id)->whereHas(
			  'messages', function ($query) use ($user) {
				
				$query->where('visible_for', $user->id)->orWhere('visible_for', null);
			})
			  ->with(
				['apartment.user', 'messages.sender', 'messages.recipient', 'messages' => function ($query) {
					
					$query->orderBy('created_at');
				}])->get()->toArray();
			if (empty($thread)) {
				return $thread;
			}
			$response =
			  [
				'thread_reference' => $thread[0]['reference_id'],
				'thread_for_user' => $user->nickname,
				  //				'created_at' => $thread[0]['created_at'],
				  //				'last_message' => $thread[0]['updated_at'],
				  //				'apartment_title' => $thread[0]['apartment']['title'],
				  //				'apartment_slug' => $thread[0]['apartment']['slug'],
				  //				'apartment_image' => $thread[0]['apartment']['main_image'],
				  //				'apartment_owner' => $thread[0]['apartment']['user']['nickname'],
				'messages' => [],
			  ];
			foreach ($thread[0]['messages'] as $message) {
				$message_item =
				  [
					'sender' => $message['sender']['nickname'],
					'recipient' => $message['recipient']['nickname'],
					'body' => $message['body'],
					'sent_at' => $message['created_at'],
				  ];
				if ($message['sender_id'] == $user->id) {
					$message_item['unreaded'] = $message['unreaded'];
				}
				$response['messages'][] = $message_item;
			}
			return $response;
		}
		
		/**
		 * Return thread info
		 *
		 * @param string $reference
		 * @param int $user_id
		 * @return array|null
		 */
		public static function getThreadDataFor(string $reference, int $user_id): ?array {
			
			$thread = Thread::where('reference_id', $reference)->with(['apartment.user', 'withUser'])->get()->first();
			if (!$thread) {
				//not found
				return null;
			}
			if ($thread->with_user_id != $user_id && $thread->apartment->user_id != $user_id) {
				//unauthorized
				return null;
			}
			return [
			  'thread_reference' => $thread->reference_id,
			  'apartment_title' => $thread->apartment->title,
			  'apartment_image' => $thread->apartment->main_image,
			  'apartment_slug' => $thread->apartment->slug,
			  'current_user_is_owner' => $thread->apartment->user_id == $user_id ?: false,
			  'apartment_owner' => $thread->apartment->user->nickname,
			  'with_user' => $thread->withuser->nickname,
			];
		}
		
		/**
		 * Add new message to current thread
		 *
		 * @param User $sender
		 * @param string $message
		 */
		public function addMessage(User $sender, string $message): void {
			
			$data = [
			  'thread_id' => $this->id,
			  'sender_id' => $sender->id,
			  'recipient_id' => $sender->id == $this->with_user_id ? $this->apartment->user_id : $this->with_user_id,
			  'body' => $message,
			];
			Message::add($data);
		}
		
	}
