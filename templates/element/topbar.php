<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

	<!-- Nav Item - Search Dropdown (Visible Only XS) -->
	<li class="nav-item dropdown no-arrow d-sm-none">
		<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-search fa-fw"></i>
		</a>
		<!-- Dropdown - Messages -->
		<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
			<form class="form-inline mr-auto w-100 navbar-search">
				<div class="input-group">
					<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
					<div class="input-group-append">
						<button class="btn btn-primary" type="button">
							<i class="fas fa-search fa-sm"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</li>

	<!-- Nav Item - Alerts -->
	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-bell fa-fw"></i>
			<!-- Counter - Alerts -->
			<?php 
			$count = 0;
			if(isset($notificationsBar)) {
				foreach($notificationsBar as $n) {
					if(!$n->seen) {
						$count++;
					}
				}
				
				if($count > 3) {
					$count = '3+';
				}
			}
			?>
			<?php if($count > 0): ?>
				<span class="badge badge-danger badge-counter">
					<?= $count ?>
				</span>
			<?php endif; ?>
		</a>
		<!-- Dropdown - Alerts -->
		<div id="userNotifications" class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
			<h6 class="dropdown-header">
				<?= __('Alerts Center') ?>
			</h6>

			<?php if($notificationsBar): ?>
				<?php foreach($notificationsBar as $notification): ?>
					<a class="notification-item dropdown-item d-flex align-items-center" href="/notifications/view/<?= $notification->id ?>">
						<div class="mr-3">
							<div class="icon-circle <?= ($notification->seen) ? 'bg-primary' : 'bg-success'; ?>">
								<i class="fas fa-file-alt text-white"></i>
							</div>
						</div>
						<div>
							<div class="small text-gray-500"><?= $this->Time->timeAgoInWords($notification->created) ?></div>
							<span <?php if(!$notification->seen): ?>class="font-weight-bold"<?php endif; ?>><?= $notification->title ?></span>
							<p class="m-0 lh-1 text-gray-500"><small><?= $notification->description ?></small></p>
						</div>
					</a>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="notification-item dropdown-item text-center pt-4 pb-4">
					<span><?= __('No notifications available.') ?></span>
				</div>
			<?php endif; ?>
			<?= $this->Html->link(
				__('Show All Alerts'),
				[
					'controller' => 'notifications',
					'action' => 'index'
				],
				[
					'id' => 'showAllUserNotifications',
					'class' => 'dropdown-item text-center small text-gray-500',
					'escape' => false
				]	
			) ?>
		</div>
	</li>

	<!-- Nav Item - Messages -->
	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-envelope fa-fw"></i>
			<?php 
			$count = 0;
			if(isset($messagesBar)) {
				foreach($messagesBar as $m) {
					if(!$m->seen) {
						$count++;
					}
				}
			}
			?>
			<?php if($count > 0): ?>
				<span class="badge badge-danger badge-counter"><?= $count ?></span>
			<?php endif; ?>
		</a>
		<!-- Dropdown - Messages -->
		<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
			<h6 class="dropdown-header">
				<?= __('Message Center') ?>
			</h6>
			<?php if($messagesBar): ?>
				<?php foreach($messagesBar as $message): ?>
					<a class="dropdown-item d-flex align-items-center" href="/messages/view/<?= $message->id ?>">
						<div class="dropdown-list-image mr-3">
							<img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
							<?php if(!$message->seen): ?><div class="status-indicator bg-danger"></div><?php endif; ?>
						</div>
						<div<?php if(!$message->seen): ?> class="font-weight-bold"<?php endif; ?>>
							<div class="text-truncate"><?= $message->message ?></div>
							<div class="small text-gray-500">
								<?= (isset($message->from_user->profile->name)) ? $message->from_user->profile->name : '<i>' . __('unknown') . '</i>'; ?> · <?= $this->Time->timeAgoInWords($message->created) ?>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="dropdown-item d-flex align-items-center" href="javascript:;">
					<div class="dropdown-list-image mr-3">
					</div>
					<div>
						<div class="text-truncate"><?= __('No messages available.') ?></div>
					</div>
				</div>
			<?php endif; ?>
			<?= $this->Html->link(
				__('Read More Messages'),
				[
					'controller' => 'messages',
					'action' => 'index'
				],
				[
					'id' => 'showAllUserMessages',
					'class' => 'dropdown-item text-center small text-gray-500'
				]
			) ?>
		</div>
	</li>

	<div class="topbar-divider d-none d-sm-block"></div>

	<!-- Nav Item - User Information -->
	<li class="nav-item dropdown no-arrow">
		<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $authUser['profile']->first_name . ' ' . $authUser['profile']->last_name ?></span>
			<?php 
			if(!empty($authUser['profile']->image_file)) {
				$profileImage = $authUser['profile']->image_file;
			} else {
				$profileImage = '/img/profile-placeholder.png';
			}
			?>
			<img class="img-profile rounded-circle" src="<?= $profileImage ?>">
		</a>
		<!-- Dropdown - User Information -->
		<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
			<?= $this->Html->link(
				'<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> ' . __('Profile'),
				[
					'controller' => 'users',
					'action' => 'view',
					$authUser['id']
				],
				[
					'class' => 'dropdown-item',
					'escape' => false
				]
			) ?>
			<?php if($authUser['role'] == 'admin'): ?>
				<?= $this->Html->link(
					'<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> ' . __('Settings'),
					[
						'controller' => 'settings',
						'action' => 'index'
					],
					[
						'class' => 'dropdown-item',
						'escape' => false
					]
				) ?>
			<?php endif; ?>
			<?= $this->Html->link(
				'<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> ' . __('Activity Log'),
				[
					'controller' => 'activities',
					'action' => 'index'
				],
				[
					'class' => 'dropdown-item',
					'escape' => false
				]
			) ?>
			<div class="dropdown-divider"></div>
			<?= $this->Html->link(
				'<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> ' . __('Logout'),
				'#',
				[
					'class' => 'dropdown-item',
					'escape' => false,
					'data-toggle' => 'modal',
					'data-target' => '#logoutModal'
				]
			) ?>
		</div>
	</li>
</ul>

<?php 
/*function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = [
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second'
	];

	foreach($string as $k => &$v) {
		if($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if(!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}*/
?>