<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
$headerLinks = [
    [
        'title' => __('New Article'),
        'link' => [
            'controller' => 'articles',
            'action' => 'add'
        ],
        'icon' => 'fa-plus',
        'btn-class' => 'btn-success'
    ]
];
$this->assign('header_title_top', 'Articles');
$this->assign('header_links', serialize($headerLinks));
?>
<div class="articles index content col-sm-10 offset-sm-1 card p-4 mb-4">
    <?php if(count($articles) > 0): ?>
        <div class="table-responsive">
            <table class="table no-border-top">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('user_id') ?></th>
                        <th><?= $this->Paginator->sort('created') ?></th>
                        <th><?= $this->Paginator->sort('modified') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= $this->Html->link(h($article->title), ['action' => 'view', $article->id]) ?></td>
                            <td><?= $article->has('user') ? $this->Html->link($article->user->profile->name, ['controller' => 'Users', 'action' => 'view', $article->user->id]) : '' ?></td>
                            <td><?= $this->Time->format($article->created, "dd.MM.Y H:m:s") ?></td>
                            <td><?= $this->Time->format($article->modified, "dd.MM.Y H:m:s") ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="far fa-fw fa-eye"></i>', ['action' => 'view', $article->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'data-tooltip' => '', 'title' => __('View')]) ?>
                                <?= $this->Html->link('<i class="far fa-fw fa-edit"></i>', ['action' => 'edit', $article->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'data-tooltip' => '', 'title' => __('Edit')]) ?>
                                <?= $this->Form->postLink('<i class="far fa-fw fa-trash-alt"></i>', ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id), 'escape' => false, 'class' => 'btn btn-sm btn-danger', 'data-tooltip' => '', 'title' => __('Delete')]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">
            <?= __('No Articles available.') ?>
        </p>
    <?php endif; ?>
</div>

<?php if(count($articles) > 0): ?>
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('«') ?>
            <?= $this->Paginator->prev('‹') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('›') ?>
            <?= $this->Paginator->last('»') ?>
        </ul>
        <p class="text-center">
            <small>
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
            </small>
        </p>
    </nav>
<?php endif; ?>