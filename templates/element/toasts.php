<?php if(isset($notificationsBar)): ?>
	<div id="toast" aria-live="polite" aria-atomic="true">
		<?= $this->Notification->generateToasts($notificationsBar); ?>
	</div>
<?php endif; ?>