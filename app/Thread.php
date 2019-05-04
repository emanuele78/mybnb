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
		 * @param Apartment $apartment
		 * @param int $with_user_id
		 * @return Thread
		 */
		public static function addIfNotExists(Apartment $apartment, int $with_user_id): self {
			
			$thread = Thread::where('apartment_id', $apartment->id)->where('with_user_id', $with_user_id)->get()->first();
			if ($thread) {
				//if thread exists, return it
				return $thread;
			}
			//otherwise create it and return it
			$thread = new Thread();
			$thread->fill(
			  [
				'reference_id' => (string)Str::uuid(),
				'apartment_id' => $apartment->id,
				'apartment_owner_nickname' => $apartment->owner()->nickname,
				'apartment_title' => $apartment->title,
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
		public static function hasNewMessages(int $thread_id, int $user_id): bool {
			
			return Message::where('thread_id', $thread_id)->where('recipient_id', $user_id)->where(
			  function ($query) use ($user_id) {
				  
				  $query->where('visible_for', $user_id)->orWhere('visible_for', null);
			  })->where('unread', 1)->get()->count();
		}
		
		/**
		 * Utility function to convert date time in locale
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
					'apartment_title' => $thread['apartment_title'],
					'apartment_slug' => $thread['apartment']['slug'],
					'apartment_image' => $thread['apartment']['main_image'] ?: 'no_image.jpg',
					'apartment_owner' => $thread['apartment_owner_nickname'],
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
					$message_item['unread'] = $message['unread'];
				}
				$response['messages'][] = $message_item;
			}
			return $response;
		}
		
		/**
		 * Return thread info
		 *
		 * @param string $nickname
		 * @return array
		 */
		public function getThreadDataFor(string $nickname): array {
			
			$thread = Thread::where('reference_id', $this->reference_id)->with(['apartment.user', 'withUser'])->get()->first();
			return [
			  'thread_reference' => $thread->reference_id,
			  'apartment_title' => $thread->apartment_title,
			  'apartment_image' => $thread->apartment()->exists() ? $thread->apartment->main_image : 'no_image.jpg',
			  'apartment_slug' => $thread->apartment()->exists() ? $thread->apartment->slug : null,
			  'current_user_is_owner' => $thread->apartment_owner_nickname == $nickname ?: false,
			  'apartment_owner' => $thread->apartment_owner_nickname,
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
		
		/**
		 * Set messages as read for the given user
		 *
		 * @param User $user
		 */
		public function setMessagesAsReadForUser(User $user): void {
			
			Message::where('thread_id', $this->id)->where('recipient_id', $user->id)->update(['unread' => 0]);
		}
		
		/**
		 * Delete a thread. Make thread messages visible only for counterpart. If counterpart has already deleted messages, remove them permanently
		 *
		 * @param User $user
		 */
		public function deleteThread(User $user): void {
			
			//first thing first find the counterpart
			$counterpart_id = $user->id == $this->with_user_id ? User::findByNickname($this->apartment_owner_nickname)->id : $this->with_user_id;
			//now assign to thread messages the counterpart id where visible_for is null
			Message::where('thread_id', $this->id)->whereNull('visible_for')->update(['visible_for' => $counterpart_id]);
			//finally delete messages already deleted by counterpart
			Message::where('thread_id', $this->id)->where('visible_for', $user->id)->delete();
		}
		
		/**
		 * The given user has deleted the given apartment. Need to set visible_for property in related apartment threads messages
		 *
		 * @param int $apartment_id
		 * @param user $user
		 */
		public static function removingApartment(int $apartment_id, user $user): void {
			
			//find all threads related to given apartment
			$threads = Thread::where('apartment_id', $apartment_id)->get();
			//set visible_for in each threads message
			foreach ($threads as $thread) {
				$thread->deleteThread($user);
			}
		}
		
	}
