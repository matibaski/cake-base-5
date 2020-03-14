<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$headerLinks = [
    [
        'title' => __('List Users'),
        'link' => [
            'controller' => 'users',
            'action' => 'index'
        ],
        'icon' => 'fa-list',
        'btn-class' => 'btn-primary'
    ],
    [
        'title' => __('Delete'),
        'link' => [
            'controller' => 'users',
            'action' => 'delete',
            'id' => $user->id
        ],
        'icon' => 'fa-trash',
        'btn-class' => 'btn-danger'
    ]
];
$this->assign('header_title_top', 'Edit User #' . $user->id);
$this->assign('header_links', serialize($headerLinks));
?>
<div class="row">
    <div class="col-sm-10 offset-sm-1 users">
        <?= $this->Form->create($user, ['class'=>'sendHidden']) ?>
            <?= $this->Form->control('profile.id', ['type'=>'hidden', 'value'=>$user->profile->id]); ?>
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                    <a class="nav-link active" href="#settings_user" data-toggle="list" role="tab">Login Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#settings_profile" data-toggle="list" role="tab">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#settings_social" data-toggle="list" role="tab">Social</a>
                </li>
            </ul>
            <div class="tab-content tab-container-white bg-white p-3 mb-3">
                <div class="tab-pane active" id="settings_user" role="tabpanel">
                    <fieldset>
                        <div class="form-group">
                            <?php 
                            $options = [
                                'admin' => 'Administrator',
                                'user' => 'User'
                            ];
                            ?>
                            <?= $this->Form->control('role', [
                                'class' => 'form-control',
                                'options' => $options,
                                'required' => true,
                                // 'disabled' => [''],
                                // 'value' => ''
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('username', ['label'=>__('Email'), 'class'=>'form-control', 'placeholder'=>'john@doe.com', 'required'=>true]); ?>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="settings_profile" role="tabpanel">
                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.first_name', ['class'=>'form-control', 'required'=>true]); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.last_name', ['class'=>'form-control', 'required'=>true]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.street', ['class'=>'form-control', 'required'=>true]); ?>
                            </div>
                            <div class="form-group col-md-2 col-sm-4">
                                <?= $this->Form->control('profile.zip', ['class'=>'form-control', 'required'=>true]); ?>
                            </div>
                            <div class="form-group col-md-4 col-sm-8">
                                <?= $this->Form->control('profile.city', ['class'=>'form-control', 'required'=>true]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.region', ['class'=>'form-control']); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.country', ['class'=>'form-control', 'required'=>true]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.phone', ['class'=>'form-control']); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.mobile', ['class'=>'form-control']); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="settings_social" role="tabpanel">
                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.website', ['label'=>'<i class="fab fa-fw fa-chrome"></i> ' . __('Website'), 'class'=>'form-control', 'escape' => false]); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.facebook', ['label'=>'<i class="fab fa-fw fa-facebook"></i> ' . __('Facebook'), 'class'=>'form-control', 'escape' => false]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.instagram', ['label'=>'<i class="fab fa-fw fa-instagram"></i> ' . __('Instagram'), 'class'=>'form-control', 'escape' => false]); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?= $this->Form->control('profile.linkedin', ['label'=>'<i class="fab fa-fw fa-linkedin"></i> ' . __('LinkedIn'), 'class'=>'form-control', 'escape' => false]); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), $this->request->referer(), ['class'=>'btn btn-secondary']) ?>

            <p><small>Fields with * are mandatory.</small></p>
        <?= $this->Form->end() ?>
    </div>
</div>