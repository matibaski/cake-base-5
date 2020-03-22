<div class="ibox">
    <div class="ibox-content mailbox-content">
        <div class="file-manager">
            <?= $this->Html->link(
                __('Compose Mail'),
                [
                    'action' => 'add'
                ],
                [
                    'class' => 'btn btn-block btn-success compose-mail'
                ]
            ) ?>
            <div class="space-25"></div>
            <h5>Folders</h5>
            <ul class="folder-list p-0">
                <li>
                    <?php 
                    $unreadLabel = '';
                    if($unread > 0) {
                        $unreadLabel = '<span class="label label-warning float-right">' . $unread . '</span>';
                    }

                    ($this->request->getParam('pass.0') == '') ? $active = 'active' : $active = '';
                    ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-fw fa-inbox"></i> ' . __('Inbox') . $unreadLabel,
                        [
                            'action' => 'index'
                        ], 
                        [
                            'escape' => false,
                            'class' => $active
                        ]
                    ) ?>
                </li>
                <li>
                    <?php ($this->request->getParam('pass.0') == 'sent') ? $active = 'active' : $active = ''; ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-fw fa-envelope"></i> ' . __('Sent'),
                        [
                            'action' => 'sent'
                        ], 
                        [
                            'escape' => false,
                            'class' => $active
                        ]
                    ) ?>
                </li>
                <li>
                    <?php ($this->request->getParam('pass.0') == 'trash') ? $active = 'active' : $active = ''; ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-fw fa-trash"></i> ' . __('Trash'),
                        [
                            'action' => 'trash'
                        ], 
                        [
                            'escape' => false,
                            'class' => $active
                        ]
                    ) ?>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>