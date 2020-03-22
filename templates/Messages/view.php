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
            <div class="float-right tooltip-demo btn-group">
                <a href="/messages/reply/<?= $message->id ?>" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fas fa-reply"></i></a>
                <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Print email"><i class="fas fa-print"></i> </a>
                <?= $this->Form->postLink('<i class="far fa-fw fa-trash-alt"></i>', ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id), 'escape' => false, 'class' => 'btn btn-sm btn-white', 'data-tooltip' => 'Move to trash', 'title' => __('Delete')]) ?>
            </div>
            <div class="mail-tools m-t-md">
                <h3>
                    <?= $message->subject ?>
                </h3>
                <table class="table table-sm table-borderless mail-view-info mt-3 mb-0">
                    <tr>
                        <td><?= __('Subject') ?></td>
                        <td><?= $message->subject ?></td>
                    </tr>
                    <tr>
                        <td><?= __('From') ?></td>
                        <td><?= $this->Html->link(
                            $message->from_user->profile->name . ' (' . $message->from_user->username . ')',
                            [
                                'controller' => 'users',
                                'action' => 'view',
                                $message->from_user->id
                            ]
                        ) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= __('Received') ?></td>
                        <td><?= $message->created->format('D, d.m.Y H:i') ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mail-box">
            <div class="mail-body pt-3 pl-3 pr-3 pb-3">
                <?= $message->message ?>
            </div>
            <div class="mail-attachment pl-3 pr-3">
                <p>
                    <span><i class="fas fa-paperclip"></i> 3 attachments - </span>
                    <a href="#">Download all</a>
                </p>

                <div class="attachment row justify-content-md-center">
                    <div class="file-box col-sm">
                        <div class="file">
                            <a href="#">
                                <span class="corner"></span>

                                <div class="icon">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div class="file-name">
                                    Document_2014.doc
                                    <br>
                                    <small>Added: Jan 11, 2014</small>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="file-box col-sm">
                        <div class="file">
                            <a href="#">
                                <span class="corner"></span>

                                <div class="image">
                                    <img alt="image" class="img-fluid" src="http://webapplayers.com/inspinia_admin-v2.9.3/img/p1.jpg">
                                </div>
                                <div class="file-name">
                                    Italy street.jpg
                                    <br>
                                    <small>Added: Jan 6, 2014</small>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="file-box col-sm">
                        <div class="file">
                            <a href="#">
                                <span class="corner"></span>

                                <div class="image">
                                    <img alt="image" class="img-fluid" src="http://webapplayers.com/inspinia_admin-v2.9.3/img/p2.jpg">
                                </div>
                                <div class="file-name">
                                    My feel.png
                                    <br>
                                    <small>Added: Jan 7, 2014</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="w-100"></div>
                </div>
            </div>
            <div class="mail-body text-right tooltip-demo p-3">
                <div class="btn-group">
                    <a class="btn btn-sm btn-white" href="#"><i class="fas fa-reply"></i> Reply</a>
                    <a class="btn btn-sm btn-white" href="#"><i class="fas fa-arrow-right"></i> Forward</a>
                    <button type="button" class="btn btn-sm btn-white"><i class="fas fa-print"></i> Print</button>
                    <button type="button" class="btn btn-sm btn-white"><i class="fas fa-trash"></i> Remove</button>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>