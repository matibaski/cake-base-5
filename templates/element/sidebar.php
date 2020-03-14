<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3"><?= $settings['frontend_name'] ?></div>
	</a>

	<hr class="sidebar-divider">

	<?php
	$this->Navigation->generateNavigation(
		$nav,
		$this->request->getParam('controller'),
		$this->request->getParam('action'),
		$this->request->getParam('pass.0')
	);
	?>

	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->