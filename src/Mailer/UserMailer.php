<?php 

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;

class UserMailer extends Mailer
{

    public function welcome($user)
    {
        $settings = \Cake\Core\Configure::read('Settings');

        $this
            ->setEmailFormat('html')
            ->setFrom([$settings['mail_from_address'] => $settings['mail_from_name']])
            ->setTo($user->username)
            ->setSubject(__('Activate your {0} Account', strip_tags($settings['frontend_name'])))
            ->setViewVars([
                'activationHash' => $user->activation_hash,
                'created' => date("d.m.Y H:i:s", strtotime($user->created)),
                'name' => $user->profile->first_name,
                'settings' => $settings
            ])
            ->viewBuilder()
                ->setTemplate('default')
                ->setLayout('register');
    }

    public function forgot($user, $newPassword)
    {
        $settings = \Cake\Core\Configure::read('Settings');

        $this
            ->setEmailFormat('html')
            ->setFrom([$settings['mail_from_address'] => strip_tags($settings['mail_from_name'])])
            ->setTo($user->username)
            ->setSubject(__('Reset Password'))
            ->setViewVars([
                'newPassword' => $newPassword,
                'name' => $user->profile->name,
                'settings' => $settings
            ])
            ->viewBuilder()
                ->setTemplate('default')
                ->setLayout('forgot');
    }
}
