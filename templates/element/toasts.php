<?php if(isset($notificationsBar)): ?>
	<?= $this->Notification->generateToasts($notificationsBar); ?>
<?php endif; ?>