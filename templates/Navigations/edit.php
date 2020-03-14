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
	],
	[
		'title' => __('Delete'),
		'link' => [
			'controller' => 'navigations',
			'action' => 'delete',
			'id' => $navigation->id
		],
		'icon' => 'fa-trash',
		'btn-class' => 'btn-danger'
	]
];
$this->assign('header_title_top', 'Edit Navigation #' . $navigation->id);
$this->assign('header_links', serialize($headerLinks));
?>

<div class="col-sm-10 offset-sm-1 card p-4">
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
					<?= $this->Form->control('icon', ['class'=>'form-control icp icp-auto', 'placeholder'=>'Pick icon...', 'aria-describedby' => 'iconPrepend', 'required' => false, 'data-placement' => 'bottomLeft', 'label' => false]); ?>
				</div>
			</div>
			<div class="form-group">
				<?= $this->Form->control('title', ['class'=>'form-control', 'placeholder'=>'Enter title']); ?>
			</div>

			<div class="link_container">
				<h6>Link Type?</h6>
				
				<?php 
				if(is_array(@unserialize($navigation->link))) {
					$linkType = 'cake';
					$link = unserialize($navigation->link);
					$val_controller = $link['controller'];
					$val_action = $link['action'];
					$val_pass0 = $link['pass0'];
					$val_pass1 = $link['pass1'];
				} else {
					$linkType = 'url';
					$link = $navigation->link;
					$val_controller = '';
					$val_action = '';
					$val_pass0 = '';
					$val_pass1 = '';
				}
				?>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="link_type" id="link_type_cake" value="link_type_cake" <?php if($linkType == 'cake') echo 'checked'; ?>>
					<label class="form-check-label" for="link_type_cake">
						Cake
					</label>
				</div>
				<div class="form-check mb-3">
					<input class="form-check-input" type="radio" name="link_type" id="link_type_url" value="link_type_url"<?php if($linkType == 'url') echo 'checked'; ?>>
					<label class="form-check-label" for="link_type_url">
						URL
					</label>
				</div>

				<div class="form-group" data-link-type="link_type_cake" <?= ($linkType != 'cake') ? 'style="display:none"' : '' ; ?>>
					<div class="row">
						<?= $this->Form->control('link.controller', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'value'=>$val_controller, 'placeholder'=>'pages']); ?>
						<?= $this->Form->control('link.action', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'value'=>$val_action, 'placeholder'=>'display']); ?>
						<?= $this->Form->control('link.pass0', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'value'=>$val_pass0, 'placeholder'=>'home', 'label'=>'Argument 1']); ?>
						<?= $this->Form->control('link.pass1', ['templates'=>['inputContainer'=>'<div class="col-md-3">{{content}}</div>'], 'class'=>'form-control', 'type'=>'text', 'value'=>$val_pass1, 'placeholder'=>'', 'label'=>'Argument 2']); ?>
					</div>
				</div>
				<div class="form-group" data-link-type="link_type_url" <?= ($linkType != 'url') ? 'style="display:none"' : '' ; ?>>
					<?= $this->Form->control('link.url', ['class'=>'form-control', 'type'=>'text', 'placeholder'=>'example. https://google.com', 'value' => $link]); ?>
				</div>
			</div>
		</fieldset>

		<?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']) ?>
		<?= $this->Html->link(__('Cancel'), $this->request->referer(), ['class' => 'btn btn-danger']) ?>
	<?= $this->Form->end() ?>
</div>