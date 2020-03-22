<?php
if(isset($notificationsBar)) {
	echo $this->Notification->generateToasts($notificationsBar);
}

if(isset($messagesBar) && $this->request->getParam('controller') != 'Messages') {
	echo $this->Message->generateToasts($messagesBar);
}
?>