<?php 
$this->assign('header_title_top', __('Register'));
?>
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
            <?= $this->Html->link(
                '<i class="fab fa-google fa-fw"></i> ' . __('Register with Google'),
                '#',
                [
                    'class' => 'btn btn-google btn-user btn-block',
                    'escape' => false
                ]
            ) ?>
            <?= $this->Html->link(
                '<i class="fab fa-facebook-f fa-fw"></i> ' . __('Register with Facebook'),
                '#',
                [
                    'class' => 'btn btn-facebook btn-user btn-block',
                    'escape' => false
                ]
            ) ?>
        </form>
        <hr>
        <div class="text-center">
            <?= $this->Html->link(__('Already an account? Login now!'), ['action' => 'login'], ['class'=>'small']) ?>
        </div>
        <div class="text-center">
            <?= $this->Html->link(__('Forgot Password?'), ['action' => 'forgot'], ['class'=>'small']) ?>
        </div>
    </div>
</div>