<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
$headerLinks = [
    [
        'title' => __('List Articles'),
        'link' => [
            'controller' => 'articles',
            'action' => 'index'
        ],
        'icon' => 'fa-list',
        'btn-class' => 'btn-primary'
    ],
    [
        'title' => __('Edit Article'),
        'link' => [
            'controller' => 'articles',
            'action' => 'edit',
            $article->id
        ],
        'icon' => 'fa-edit',
        'btn-class' => 'btn-primary'
    ],
    [
        'title' => __('Delete'),
        'link' => [
            'controller' => 'articles',
            'action' => 'delete',
            'id' => $article->id
        ],
        'icon' => 'fa-trash',
        'btn-class' => 'btn-danger'
    ],
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
$this->assign('header_title_top', 'View Article #' . $article->id);
$this->assign('header_links', serialize($headerLinks));
?>
<div class="card">
    <div class="row p-4">
        <div class="col-sm-8 border-right">
            <?= $this->Text->autoParagraph($article->body); ?>
        </div>
        <div class="col-sm-4">
            <table class="table">
                <tr>
                    <th class="border-top-0"><?= __('Id') ?></th>
                    <td class="border-top-0"><?= $this->Number->format($article->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($article->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h(date("d.m.Y H:i:s", strtotime($article->created))) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h(date("d.m.Y H:i:s", strtotime($article->modified))) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
