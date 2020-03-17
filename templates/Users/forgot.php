<?php 
$this->assign('header_title_top', __('Forgot Password'));
?>
    <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
    <div class="col-lg-6">
        <div class="p-5 mt-5 mb-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900"><?= __('Forgot Password?') ?></h1>
                <h2 class="h5 text-gray-500 mb-4"><?= __('Reset now!') ?></h2>
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
                <?= $this->Html->link(__('You know your password? Login now!'), ['action' => 'login'], ['class'=>'small']) ?>
            </div>
            <div class="text-center">
                <?= $this->Html->link(__('Create an Account. Register now!'), ['action' => 'register'], ['class'=>'small']) ?>
            </div>
        </div>
    </div>