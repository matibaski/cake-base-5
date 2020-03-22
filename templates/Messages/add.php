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
            <div class="float-right btn-group">
                <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to draft folder"><i class="fas fa-edit"></i> Draft</a>
                <a href="<?= $this->request->referer() ?>" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Discard email"><i class="fas fa-times"></i> Discard</a>
            </div>
            <h2>
                <?= ('Compose mail') ?>
            </h2>
        </div>
        <div class="mail-box">
            <?= $this->Form->create($message) ?>
                <div class="mail-body">
                    <?php
                    echo $this->Form->control('to_user_id', ['class' => 'form-control mb-2', 'label' => 'To', 'options' => $toUsers]);
                    echo $this->Form->control('subject', ['class' => 'form-control mb-2']);
                    echo $this->Form->control('message', ['class' => 'tinymce form-control mb-2', 'required' => false]);
                    ?>
                </div>
                <div class="mail-body text-right">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Send" type="submit"><i class="fas fa-reply"></i> Send</button>
                        <a href="<?= $this->request->referer() ?>" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fas fa-times"></i> Discard</a>
                        <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fas fa-edit"></i> Draft</a>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>