<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$headerLinks = [];
$this->assign('header_title_top', __('Change password for {0} ({1})', $user->profile->name, $user->username));
$this->assign('header_links', serialize($headerLinks));
?>
<div class="col-sm-10 offset-sm-1 card p-4 mb-4">
    <?= $this->Form->create($user) ?>
        <fieldset>
            <div class="form-group">
                <?= $this->Form->control('current_password', ['class'=>'form-control', 'type'=>'password', 'label'=>'Enter current Password', 'value' => '']); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('password', ['class'=>'form-control', 'label'=>'Enter new Password', 'value' => '']); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('password_confirm', ['class'=>'form-control', 'type'=>'password', 'label'=>'Repeat new Password', 'value'=>'', 'required'=>true]); ?>
            </div>
        </fieldset>

        <?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']) ?>
        <?= $this->Html->link(__('Cancel'), $this->request->referer(), ['class'=>'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>