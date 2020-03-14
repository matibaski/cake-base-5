<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Navigation $navigation
 */
$headerLinks = [
    [
        'title' => __('List Navigations'),
        'link' => [
            'controller' => 'navigations',
            'action' => 'index'
        ],
        'icon' => 'fa-list',
        'btn-class' => 'btn-primary'
    ]
];
$this->assign('header_title_top', 'New navigation');
$this->assign('header_links', serialize($headerLinks));
?>

<div class="col-10 offset-1 card p-4 mb-4">
	<?= $this->Form->create($navigation) ?>
		<fieldset>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-addon input-group-text" id="iconPrepend"><i class="<?= $navigation->icon ?>"></i></span>
					</div>
					<?php
					$this->Form->setTemplates([
					    'inputContainer' => '{{content}}'
					]); ?>
					<?= $this->Form->control('icon', ['class'=>'form-control icp icp-auto', 'placeholder'=>'Pick icon...', 'aria-describedby' => 'iconPrepend', 'data-placement' => 'bottomLeft', 'label' => false]); ?>
				</div>
			</div>
			<div class="form-group">
				<?= $this->Form->control('title', ['class'=>'form-control', 'placeholder'=>'Enter title']); ?>
			</div>

			<h6>Link Type?</h6>
			
			<div class="form-check">
				<input class="form-check-input" type="radio" name="link_type" id="link_type_cake" value="link_type_cake" checked>
				<label class="form-check-label" for="link_type_cake">
					Cake Link
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="radio" name="link_type" id="link_type_url" value="link_type_url">
				<label class="form-check-label" for="link_type_url">
					URL
				</label>
			</div>

			<div class="form-group" data-link-type="link_type_cake">
				<div class="row">
					<?= $this->Form->control('link.controller', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'placeholder'=>'pages']); ?>
					<?= $this->Form->control('link.action', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'placeholder'=>'display']); ?>
					<?= $this->Form->control('link.pass0', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'placeholder'=>'home', 'label'=>'Argument 1']); ?>
					<?= $this->Form->control('link.pass1', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'placeholder'=>'', 'label'=>'Argument 2']); ?>
				</div>
			</div>
			<div class="form-group" data-link-type="link_type_url" style="display:none;">
				<?= $this->Form->control('link.url', ['class'=>'form-control', 'type'=>'text', 'placeholder'=>'example. https://google.com']); ?>
			</div>
		</fieldset>

		<?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']) ?>
		<?= $this->Html->link(__('Cancel'), $this->request->referer(), ['class' => 'btn btn-danger']) ?>
	<?= $this->Form->end() ?>
</div>
