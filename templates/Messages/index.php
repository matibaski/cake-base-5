<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messages
 */
use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-lg-3">
        <?= $this->element('mailbox_sidebar') ?>
    </div>
    <div class="col-lg-9 animated fadeInRight">
        <div class="mail-box-header">
            <form method="get" action="" class="float-right mail-search">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-sm btn-primary" type="button">
                            <i class="fas fa-search" data-toggle="tooltip" title="<?= __('Search') ?>"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Search ..." class="form-control form-control-sm" placeholder="" aria-label="" aria-describedby="basic-addon1">
                </div> 
            </form>
            <h2 class="mb-3">
                <?= $title ?>
            </h2>
            <div class="mail-tools tooltip-demo m-t-md">
                <div class="btn-group float-right" role="group">
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" title="<?= __('Previous Message') ?>"><i class="fa fa-arrow-left"></i></button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" title="<?= __('Next Message') ?>"><i class="fa fa-arrow-right"></i></button>
                </div>
                <div class="btn-group" role="group">
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" title="<?= ('Refresh') ?>"><i class="fas fa-fw fa-sync"></i> Refresh</button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" title="<?= ('Mark as read') ?>"><i class="fas fa-fw fa-eye"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" title="<?= ('Mark as important') ?>"><i class="fas fa-fw fa-exclamation"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" title="<?= ('Move to trash') ?>"><i class="fas fa-fw fa-trash"></i> </button>
                </div>
            </div>
        </div>
        <div class="mail-box">
            <table class="table table-hover table-mail">
                <thead>
                    <tr>
                        <td>
                            <?php
                            if($this->request->getParam('pass.0') != 'sent') {
                                echo $this->Paginator->sort('from_user_id', __('From'));
                            } else {
                                echo $this->Paginator->sort('to_user_id', __('To'));
                            }
                            ?>
                        </td>
                        <td><?= $this->Paginator->sort('subject') ?></td>
                        <td></td>
                        <td class="text-right"><?= $this->Paginator->sort('created', __('Sent')) ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($messages as $message): ?>
                        <?php if($this->request->getParam('pass.0') == 'sent'): ?>
                            <tr>
                        <?php else: ?>
                            <tr class="<?= ($message->seen) ? 'read' : 'unread' ?>">
                        <?php endif; ?>
                            <td class="mail-contact">
                                <?php 
                                if($this->request->getParam('pass.0') != 'sent') {
                                    echo $message->from_user->profile->name;
                                } else {
                                    echo $message->to_user->profile->name;
                                }?>
                                <?= $this->Html->link(
                                    $message->subject,
                                    [
                                        'controller' => 'messages',
                                        'action' => 'view',
                                        $message->id
                                    ],
                                    [
                                        'class' => 'open-mail'
                                    ]
                                ) ?>
                            </td>
                            <td class="mail-subject">
                                <?= $this->Html->link(
                                    $message->subject,
                                    [
                                        'controller' => 'messages',
                                        'action' => 'view',
                                        $message->id
                                    ]
                                ) ?>
                                <?= $this->Html->link(
                                    $message->subject,
                                    [
                                        'controller' => 'messages',
                                        'action' => 'view',
                                        $message->id
                                    ],
                                    [
                                        'class' => 'open-mail'
                                    ]
                                ) ?>
                            </td>
                            <td class="">
                                <?php //<i class="fa fa-paperclip"></i> ?>
                                <?= $this->Html->link(
                                    $message->subject,
                                    [
                                        'controller' => 'messages',
                                        'action' => 'view',
                                        $message->id
                                    ],
                                    [
                                        'class' => 'open-mail'
                                    ]
                                ) ?>
                            </td>
                            <td class="text-right mail-date">
                                <?php 
                                $created = new Time($this->Time->format($message->created, "dd.MM.YYYY H:mm"));
                                echo $created->timeAgoInWords(
                                    ['format' => 'MMM d, YYY', 'end' => '+1 year']
                                );
                                ?>
                                <?= $this->Html->link(
                                    $message->subject,
                                    [
                                        'controller' => 'messages',
                                        'action' => 'view',
                                        $message->id
                                    ],
                                    [
                                        'class' => 'open-mail'
                                    ]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if(count($messages) == 0): ?>
                        <tr>
                            <td colspan="4" class="text-center">No Messages available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if(count($messages) > 0): ?>
            <nav aria-label="Pagination">
                <ul class="pagination mt-3 justify-content-center">
                    <?= $this->Paginator->first('«') ?>
                    <?= $this->Paginator->prev('‹') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('›') ?>
                    <?= $this->Paginator->last('»') ?>
                </ul>
                <p class="text-center"><small><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></small></p>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>