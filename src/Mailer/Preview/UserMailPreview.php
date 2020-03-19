<?php

namespace App\Mailer\Preview;

use DebugKit\Mailer\MailPreview;
use Cake\ORM\TableRegistry;

class UserMailPreview extends MailPreview
{

    public function welcome()
    {
        $user = TableRegistry::getTableLocator()->get('Users');
        $user = $user->find()->first();
        return $this->getMailer('User')->welcome($user);
    }

    public function forgot()
    {
        $user = TableRegistry::getTableLocator()->get('Users');
        $user = $user->find()->first();
        return $this->getMailer('User')->forgot($user, 'testpassword123');
    }
}