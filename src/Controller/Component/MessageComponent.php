<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class MessageComponent extends Component
{
	public function push($to_user_id, $from_user_id, $message)
	{
		// load Model
		$this->Messages = TableRegistry::get('Messages');

		// prepare data
		$newMessage = [
			'to_user' => $to_user_id,
			'from_user' => $from_user_id,
			'message' => $message,
			'seen' => 0
		];

		// save Message
		$message = $this->Messages->newEntity();
        $message = $this->Messages->patchEntity($message, $newMessage);
        if($this->Messages->save($message)) {
        	return true;
        }
        return false;
	}

	public function fetch($user_id)
	{
		// load Model
		$this->Messages = TableRegistry::get('Messages');

		// get Messages
		$messages = $this->Messages
			->find('all')
			->where(['Messages.to_user_id' => $user_id])
			->order(['Messages.created' => 'DESC'])
			->contain(['FromUsers' => ['Profiles']])
			->toList();

		return $messages;
	}
}