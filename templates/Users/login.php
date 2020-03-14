<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= __('Login') . ' | ' . $settings['backend_name']; ?></title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?= $this->Flash->render() ?>
                                    <?= $this->Form->create(null, ['class' => 'user']) ?>
                                        <div class="form-group">
                                            <?= $this->Form->control('username', [
                                                'label' => false,
                                                'type' => 'text',
                                                'required' => true,
                                                'class' => 'form-control form-control-user',
                                                'placeholder' => __('Email address'),
                                                'aria-describedby' => 'emailHelp'
                                            ]) ?>
                                        </div>
                                        <div class="form-group">
                                            <?= $this->Form->control('password', [
                                                'label' => false,
                                                'type' => 'password',
                                                'required' => true,
                                                'class' => 'form-control form-control-user',
                                                'placeholder' => __('Password')
                                            ]) ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <?= $this->Form->checkbox('remember_me', ['class' => 'custom-control-input', 'id' => 'rememberMeCheck']) ?>
                                                <label class="custom-control-label" for="rememberMeCheck"><?= __('Remember Me') ?></label>
                                            </div>
                                        </div>
                                        <?= $this->Form->button(__('Login'),[
                                            'class'=>'btn btn-primary btn-user btn-block'
                                        ]); ?>
                                        <hr>
                                        <a href="#" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> <?= __('Login with Google') ?>
                                        </a>
                                        <a href="#" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> <?= __('Login with Facebook') ?>
                                        </a>
                                    <?= $this->Form->end() ?>
                                    <hr>
                                    <div class="text-center">
                                        <?= $this->Html->link(__('Forgot Password?'), ['action' => 'forgot'], ['class'=>'small']) ?>
                                    </div>
                                    <div class="text-center">
                                        <?= $this->Html->link(__('Create an Account! Register now!'), ['action' => 'register'], ['class'=>'small']) ?>
                                    </div>
                                </div>
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