<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Toast');

        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => '/users/login'
        ]);

        // $this->viewBuilder()->setHelpers(['AssetCompress.AssetCompress']);
        
        //$this->loadComponent('FormProtection');

        // load settings, navigation and debug state
        $settings = \Cake\Core\Configure::read('Settings');
        $nav = \Cake\Core\Configure::read('Navigation');
        $debug = \Cake\Core\Configure::read('debug');
        $this->set(compact('settings', 'nav', 'debug'));

        // authenticated user
        if($this->Authentication->getResult()->isValid()) {
            $authUser = $this->Authentication->getIdentity()->getOriginalData();

            // fetch notifications & messages
            $this->loadComponent('Notification');
            $this->loadComponent('Message');
            $notificationsBar = $this->Notification->fetch($authUser->id);
            $messagesBar = $this->Message->fetch($authUser->id);

            $this->set(compact('authUser', 'notificationsBar', 'messagesBar'));
        }
    }

    /**
     * beforeFilter method
     * @param  \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'logout', 'activate', 'forgot']);
    }
}
