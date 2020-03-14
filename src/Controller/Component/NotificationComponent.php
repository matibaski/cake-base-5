<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class NotificationComponent extends Component
{
	/**
	 * Push method
	 * 
	 * @param  int     $user         User ID
	 * @param  varchar $title        Notification Title
	 * @param  text    $description  Notification Text
	 * @param  array   $cta          Call to Action on Notification
	 * @return boolean               True or False
	 */
	public function push(int $user, $title, $description = null, array $cta = [])
	{
		// load Model
		$this->Notifications = TableRegistry::get('Notifications');

		// prepare data
		$newNotification = [
			'user_id' => $user,
			'title' => $title,
			'description' => $description,
			'cta' => serialize($cta),
			'seen' => 0
		];

		// save Notification
		$notification = $this->Notifications->newEmptyEntity();
        $notification = $this->Notifications->patchEntity($notification, $newNotification);
        if($this->Notifications->save($notification)) {
        	return true;
        }
        return false;
	}

	public function fetch($user)
	{
		// load Model
		$this->Notifications = TableRegistry::get('Notifications');

		// get Notifications
		$notifications = $this->Notifications->find()
			->limit(4)
			->where(['user_id' => $user])
			->order(['created'=>'DESC'])
			->toList();
		
		return $notifications;
	}
}