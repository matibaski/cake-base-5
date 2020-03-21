<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class MessageHelper extends Helper
{
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