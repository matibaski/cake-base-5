<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?= __('Register') . ' | ' . $settings['backend_name'] ?></title>

	<!-- Custom fonts for this template-->
	<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

	<div class="container">
		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
					<div class="col-lg-7">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4"><?= __('Create an Account!') ?></h1>
							</div>
							<?= $this->Form->create(null, ['class' => 'user']) ?>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<?= $this->Form->control('profile.first_name', [
                                            'label' => false,
                                            'type' => 'text',
                                            'required' => true,
                                            'class' => 'form-control form-control-user',
                                            'placeholder' => __('First Name')
                                        ]) ?>
									</div>
									<div class="col-sm-6">
										<?= $this->Form->control('profile.last_name', [
                                            'label' => false,
                                            'type' => 'text',
                                            'required' => true,
                                            'class' => 'form-control form-control-user',
                                            'placeholder' => __('Last Name')
                                        ]) ?>
									</div>
								</div>
								<div class="form-group">
									<?= $this->Form->control('username', [
                                        'label' => false,
                                        'type' => 'text',
                                        'required' => true,
                                        'class' => 'form-control form-control-user',
                                        'placeholder' => __('Email Address'),
                                        'aria-describedby' => 'emailHelp'
                                    ]) ?>
								</div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<?= $this->Form->control('password', [
                                            'label' => false,
                                            'type' => 'password',
                                            'required' => true,
                                            'class' => 'form-control form-control-user',
                                            'placeholder' => __('Password')
                                        ]) ?>
									</div>
									<div class="col-sm-6">
										<?= $this->Form->control('password_confirm', [
                                            'label' => false,
                                            'type' => 'password',
                                            'required' => true,
                                            'class' => 'form-control form-control-user',
                                            'placeholder' => __('Repeat Password')
                                        ]) ?>
									</div>
								</div>
								<?= $this->Form->button(__('Register Now!'),[
                                    'class'=>'btn btn-primary btn-user btn-block'
                                ]); ?>
								<hr>
								<a href="#" class="btn btn-google btn-user btn-block">
									<i class="fab fa-google fa-fw"></i> Register with Google
								</a>
								<a href="#" class="btn btn-facebook btn-user btn-block">
									<i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
								</a>
							</form>
							<hr>
							<div class="text-center">
                                <?= $this->Html->link(__('Forgot Password?'), ['action' => 'forgot'], ['class'=>'small']) ?>
                            </div>
                            <div class="text-center">
                                <?= $this->Html->link(__('Already an account? Login now!'), ['action' => 'login'], ['class'=>'small']) ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="/vendor/jquery/jquery.min.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="/js/sb-admin-2.min.js"></script>

</body>

</html>
