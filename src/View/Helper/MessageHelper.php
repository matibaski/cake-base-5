<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class MessageHelper extends Helper
{

	public $helpers = ['Time'];

	/**
	 * generateToast Helper
	 * @param  string  $title
	 * @param  string  $content
	 * @param  string  $icon
	 * @param  integer $delay
	 * @return HTML
	 */
	public function generateToasts($toasts, $delay = 10000)
	{
		$message = '';

		foreach($toasts as $toast) {
			if($toast->seen) {
				continue;
			}

			$created = new Time($this->Time->format($toast->created, "dd.MM.YYYY H:mm"));
			$created = $created->timeAgoInWords(
			    ['format' => 'MMM d, YYY', 'end' => '+1 year']
			);

			$from = $toast->from_user->profile->name;
			$content = mb_strimwidth($toast->message, 0, 24, " ...");
			$id = $toast->id;
			$message .= <<<HTML
			<div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="${delay}">
				<div class="toast-header">
					<a href="/messages/view/${id}" class="mr-auto">
						<i class="far fa-envelope fa-fw mr-2"></i> <strong>Message</strong>
					</a>
					<small class="text-muted">${created}</small>
					<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" data-id="${id}" data-from="messages">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="toast-body">
					<p>
						<strong>From:</strong> $from<br />
					</p>
					<p>
						${content}<br />
						<a href="/messages/view/${id}">Read more</a>
					</p>
				</div>
			</div>
			HTML;
		}

		return $message;
	}

	/**
	 * fetch method
	 * Receive all messages for $user_id as entity-array
	 * 
	 * @param  int    $user_id
	 * @return array  $messages
	 */
	public function fetch(int $user_id)
	{
		// load Model
		$this->Messages = TableRegistry::get('Messages');

		// get Messages
		$messages = $this->Messages->find()
			->limit(4)
			->where(['to_user_id' => $user_id])
			->order(['created'=>'DESC'])
			->toList();
		
		return $messages;
	}
}