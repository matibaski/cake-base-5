<?php

namespace App\Mailer\Preview;

use DebugKit\Mailer\MailPreview;

class UserMailPreview extends MailPreview
{

    public function welcome()
    {
        $this->loadModel('Users');
        $user = $this->Users->find()->first();
        return $this->getMailer('User')->welcome($user);
    }

    public function forgot()
    {
        $this->loadModel('Users');
        $user = $this->Users->find()->first();
        return $this->getMailer('User')->forgot($user, 'testpassword123');
    }
}