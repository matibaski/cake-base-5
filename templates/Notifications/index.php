<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification[]|\Cake\Collection\CollectionInterface $notifications
 */
$headerLinks = [];
$this->assign('header_title_top', 'Notifications');
$this->assign('header_links', serialize($headerLinks));
?>
<div class="notifications index content col-sm-10 offset-sm-1 card p-3">
    <?php if(count($notifications) > 0): ?>
        <div class="table-responsive">
            <table class="table no-border-top">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('description') ?></th>
                        <th><?= $this->Paginator->sort('seen') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notifications as $notification): ?>
                        <tr>
                            <td><?= h($notification->title) ?></td>
                            <td>
                                <?php 
                                if(!empty($notification->description)) {
                                    echo h($notification->description);
                                } else {
                                    echo '<i class="fa fa-times"></i>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if($notification->seen) {
                                    echo '<i class="fa fa-check"></i>';
                                } else {
                                    echo '<i class="fa fa-times"></i>';
                                }
                                ?>
                            </td>
                            <td><?= h($notification->created->format('d.m.Y H:i')) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $notification->id], ['class' => 'btn btn-sm btn-primary', 'title' => __('Delete'), 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">
            <?= __('No Notifications available.') ?>
        </p>
    <?php endif; ?>
</div>

<?php if(count($notifications) > 0): ?>
    <nav aria-label="Pagination" class="mt-4">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('«') ?>
            <?= $this->Paginator->prev('‹') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('›') ?>
            <?= $this->Paginator->last('»') ?>
        </ul>
        <p class="text-center"><small><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></small></p>
    </nav>
<?php endif; ?>