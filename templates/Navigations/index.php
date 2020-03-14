<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Navigation[]|\Cake\Collection\CollectionInterface $navigations
 */
$headerLinks = [
    [
        'title' => __('New Navigation'),
        'link' => [
            'controller' => 'navigations',
            'action' => 'add'
        ],
        'icon' => 'fa-plus',
        'btn-class' => 'btn-success'
    ]
];
$loadScripts = [
    '/plugins/nestable/jquery.nestable.js',
    '/js/navigation.js'
];

$this->assign('header_title_top', 'Navigations');
$this->assign('header_links', serialize($headerLinks));
$this->assign('load_scripts', serialize($loadScripts));
?>

<div class="row">
    <div class="col-6">
        <div id="nestable" class="dd">
            <?php $this->Navigation->navTree($nav, 0, false); ?>
        </div>
    </div>
    <div class="col-6">
        <div id="nestable2" class="dd">
            <?php $this->Navigation->navTree($navigations, 0, true) ?>
        </div>
    </div>
    <div class="col-12 mt-4 mb-4">
        <?= $this->Form->create($navigations, ['id' => 'NavigationModifier']) ?>
            <?= $this->Form->control('order', ['class' => 'form-control', 'type' => 'hidden', 'id' => 'nestable-output']) ?>
            <div id="nestable-menu">
                <?= $this->Form->button(__('Save order'), ['class'=>'btn btn-success']); ?>
                <button type="button" data-action="expand-all" class="btn btn-primary">Expand All</button>
                <button type="button" data-action="collapse-all" class="btn btn-primary">Collapse All</button>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>
