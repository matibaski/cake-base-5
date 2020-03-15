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
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Event\EventInterface;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler');
    }

    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        // load components
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => '/users/login'
        ]);

        // load settings
        $settings = \Cake\Core\Configure::read('Settings');

        // get navigation
        $nav = \Cake\Core\Configure::read('Navigation');

        // get debug state
        $debug = \Cake\Core\Configure::read('debug');

        $this->set(compact('settings', 'nav', 'debug'));

        // check if user is logged in
        if(isset($_SESSION['Auth']) && !empty($_SESSION['Auth'])) {
            $this->loadModel('Users');
            $authUser = $this->Users->find()->where(['Users.id' => $_SESSION['Auth']->id])->contain(['Profiles'])->first();

            // fetch notifications
            $this->loadComponent('Notification');
            $notificationsBar = $this->Notification->fetch($authUser['id']);

            // fetch messages
            $this->loadComponent('Message');
            $messagesBar = $this->Message->fetch($authUser['id']);

            $this->set(compact('authUser', 'notificationsBar', 'messagesBar'));

        // if not logged in, redirect to login page
        } else {
            $this->Flash->error(__('You need to login to access that page.'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
        $this->viewBuilder()->setTemplatePath('Error');
    }

    /**
     * afterFilter callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function afterFilter(EventInterface $event)
    {
    }
}
