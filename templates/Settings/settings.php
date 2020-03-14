<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messages
 */
$headerLinks = [
	[
        'title' => __('New Setting'),
        'link' => '#',
        'icon' => 'fa fa-plus',
        'btn-class' => 'btn-success addNewSetting'
    ]
];
$this->assign('header_title_top', 'Settings');
$this->assign('header_links', serialize($headerLinks));
?>

<div class="col-sm-10 offset-sm-1 card p-3 mb-4">
	<?= $this->Form->create(null, ['class'=>'settings_form']) ?>
		<fieldset>
			<table class="table no-border-top">
				<thead>
					<tr>
						<th><?= __('Setting') ?></th>
						<th colspan="2"><?= __('Value') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach($settings as $setting => $value): ?>
						<tr data-settings-num="<?= $i ?>">
							<td>
								<input type="text" class="form-control" placeholder="settings_name" value="<?= $setting ?>" name="Settings[<?= $i ?>][name]" data-settings-num="<?= $i ?>" />
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Settings Value" value="<?= $value ?>" name="Settings[<?= $i ?>][value]" />
							</td>
							<td>
								<button class="btn btn-danger" data-remove-setting="<?= $i ?>">
									<i class="fas fa-trash"></i> 
									<?= __('Remove') ?>
								</button>
							</td>
						</tr>
						<?php $i++; ?>
					<?php endforeach; ?>
					<tr class="settings_actions">
						<td colspan="3">
							<button class="submitSettingsForm btn btn-primary" title="<?= __('Save') ?>" type="submit"><i class="fa fa-save"></i> <?= __('Save') ?></button>
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	<?= $this->Form->end() ?>
</div>