<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$headerLinks = [
    [
        'title' => __('New User'),
        'link' => [
            'controller' => 'users',
            'action' => 'add'
        ],
        'icon' => 'fa-plus',
        'btn-class' => 'btn-success'
    ]
];

if($this->request->getParam('pass.0') == 'disabled') {
    $headerLinks[] = [
        'title' => __('Active Users'),
        'link' => [
            'controller' => 'users',
            'action' => 'index'
        ],
        'icon' => 'fa-list',
        'btn-class' => 'btn-primary'
    ];
} else {
    $headerLinks[] = [
        'title' => __('Disabled Users'),
        'link' => [
            'controller' => 'users',
            'action' => 'index',
            'disabled'
        ],
        'icon' => 'fa-list',
        'btn-class' => 'btn-primary'
    ];
}

$this->assign('header_title_top', 'Users');
$this->assign('header_links', serialize($headerLinks));
?>
<div class="users index content card p-3">
    <div class="table-responsive">
        <table class="table datatable no-border-top">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('disabled') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><i class="fas fa-fw <?= ($user->active) ? 'fa-check' : 'fa-times'; ?>"></i></td>
                    <td><i class="fas fa-fw <?= ($user->disabled) ? 'fa-check' : 'fa-times'; ?>"></i></td>
                    <td><?= $this->Time->format($user->created, "dd.MM.YYYY HH:mm") ?></td>
                    <td><?= $this->Time->format($user->modified, "dd.MM.YYYY HH:mm") ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="far fa-fw fa-eye"></i>', ['action' => 'view', $user->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'data-tooltip' => '', 'title' => __('View')]) ?>
                        <?= $this->Html->link('<i class="far fa-fw fa-edit"></i>', ['action' => 'edit', $user->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'data-tooltip' => '', 'title' => __('Edit')]) ?>
                        <?= $this->Form->postLink('<i class="far fa-fw fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'escape' => false, 'class' => 'btn btn-sm btn-danger', 'data-tooltip' => '', 'title' => __('Delete')]) ?>
                    </td>
                </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<nav aria-label="Pagination" class="mt-5">
    <ul class="pagination" style="justify-content:center;">
        <?= $this->Paginator->first('«') ?>
        <?= $this->Paginator->prev('‹') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('›') ?>
        <?= $this->Paginator->last('»') ?>
    </ul>
    <p class="text-center"><small><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></small></p>
</nav>