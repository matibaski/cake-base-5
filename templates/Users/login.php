<?php 
$this->assign('header_title_top', __('Login'));
?>
<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
<div class="col-lg-6">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4"><?= __('Welcome Back!') ?></h1>
        </div>
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
            <?= $this->Html->link(__('Create an Account. Register now!'), ['action' => 'register'], ['class'=>'small']) ?>
        </div>
    </div>
</div>