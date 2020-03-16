<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= __('Reset password') . ' | ' . $settings['backend_name']; ?></title>

    <?= $this->Html->css('theme.min.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
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
                                        <h1 class="h4 text-gray-900">Forgot Password?</h1>
                                        <h2 class="h5 text-gray-500 mb-4">Reset now!</h2>
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
                                        <?= $this->Form->button(__('Reset Password'),[
                                            'class'=>'btn btn-primary btn-user btn-block'
                                        ]); ?>
                                    <?= $this->Form->end() ?>
                                    <hr>
                                    <div class="text-center">
                                        <?= $this->Html->link(__('You know your password? Login now!'), ['action' => 'forgot'], ['class'=>'small']) ?>
                                    </div>
                                    <div class="text-center">
                                        <?= $this->Html->link(__('Create an Account. Register now!'), ['action' => 'register'], ['class'=>'small']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/plugins/jquery/jquery.min.js"></script> 
    <script src="/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/plugins/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/theme.js"></script>
</body>
</html>