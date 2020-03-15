<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
$headerLinks = [
    [
        'title' => __('List Messages'),
        'link' => [
            'controller' => 'messages',
            'action' => 'index'
        ],
        'icon' => 'fa-list',
        'btn-class' => 'btn-primary'
    ]
];
$this->assign('header_title_top', 'New message');
$this->assign('header_links', serialize($headerLinks));
?>

<div class="col-sm-10 offset-sm-1">
	<div class="messages form content card p-3">
		<?= $this->Form->create($message) ?>
			<fieldset>
				<?php
				echo $this->Form->control('to_user_id', ['class' => 'form-control mb-2', 'options' => $toUsers]);
				echo $this->Form->control('message', ['class' => 'form-control mb-2']);
				?>
			</fieldset>
		
			<div class="mt-3">
				<?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']); ?>
				<?= $this->Html->link(__('Cancel'), $this->request->referer(), ['class'=>'btn btn-secondary']) ?>
				<?= $this->Form->end() ?>
			</div>
		<?= $this->Form->end() ?>
	</div>
</div>
