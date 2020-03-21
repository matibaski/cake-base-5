<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class NotificationHelper extends Helper
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
		$notification = '';

		foreach($toasts as $toast) {
			if($toast->seen) {
				continue;
			}

			$created = new Time($this->Time->format($toast->created, "dd.MM.YYYY H:mm"));
			$created = $created->timeAgoInWords(
			    ['format' => 'MMM d, YYY', 'end' => '+1 year']
			);

			$title = $toast->title;
			$content = $toast->description;
			$id = $toast->id;
			$notification .= <<<HTML
			<div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="${delay}">
				<div class="toast-header">
					<a href="/notifications/view/${id}" class="mr-auto">
						<i class="far fa-bell fa-fw mr-2"></i> <strong>Notification</strong>
					</a>
					<small class="text-muted">${created}</small>
					<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" data-id="${id}" data-from="notifications">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="toast-body">
					<p><strong>${title}</strong><br />${content}</p>
				</div>
			</div>
			HTML;
		}

		return $notification;
	}


	/**
	 * fetch method
	 * Receive all notifications for $user_id as entity-array
	 * 
	 * @param  int    $user_id
	 * @return array  $notifications
	 */
	public function fetch(int $user_id)
	{
		// load Model
		$this->Notifications = TableRegistry::get('Notifications');

		// get Notifications
		$notifications = $this->Notifications->find()
			->limit(4)
			->where(['user_id' => $user_id])
			->order(['created'=>'DESC'])
			->toList();
		
		return $notifications;
	}
}