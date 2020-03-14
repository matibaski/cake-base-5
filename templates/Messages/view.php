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
    ],
    [
        'title' => __('Delete'),
        'link' => [
            'controller' => 'messages',
            'action' => 'delete',
            'id' => $message->id
        ],
        'icon' => 'fa-trash',
        'btn-class' => 'btn-danger'
    ],
    [
        'title' => __('New Message'),
        'link' => [
            'controller' => 'messages',
            'action' => 'add'
        ],
        'icon' => 'fa-plus',
        'btn-class' => 'btn-success'
    ]
];
$this->assign('header_title_top', 'View Message #' . $message->id);
$this->assign('header_links', serialize($headerLinks));
?>
<div class="col-sm-10 offset-sm-1 card p-3">
    <div class="row">
        <div class="col-sm-7 border-right">
            <table class="table no-border-top">
                <tr>
                    <th><?= __('Message') ?></th>
                </tr>
                <tr>
                    <td><?= $this->Text->autoParagraph($message->message); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-5">
            <table class="table no-border-top">
                <tr>
                    <th><?= __('From') ?></th>
                    <td><?= h($message->from_user->profile->first_name) . ' ' . h($message->from_user->profile->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Received') ?></th>
                    <td><?= h(date("d.m.Y H:i:s", strtotime($message->created))) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>