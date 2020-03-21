<?php
if(isset($notificationsBar)) {
	echo $this->Notification->generateToasts($notificationsBar);
}

if(isset($messagesBar)) {
	echo $this->Message->generateToasts($messagesBar);
}
?>