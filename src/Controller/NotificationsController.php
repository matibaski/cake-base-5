<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 *
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $notifications = $this->paginate($this->Notifications
            ->find('all')
            ->contain(['Users'])
            ->where(['Notifications.user_id' => $this->Authentication->getIdentity()->id])
            ->order(['Notifications.created' => 'DESC'])
        );

        $this->set(compact('notifications'));
    }

    /**
     * View method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        $notification = $this->Notifications->get($id);
        if(!empty($notification->cta)) {
            if(!$notification->seen)
                $this->toggle($notification->id, 'seen', false, false);
            return $this->redirect(unserialize($notification->cta));
        } else {
            $this->Flash->default('<small><i>' . __('Notification') . ':</i></small>' . "\n" . '<p><strong>' . $notification->title . '</strong></p>' . "\n" . '<p>' . $notification->description . '</p>');
            return $this->redirect($this->request->referer());
        }
    }

    /**
     * AJAX method
     */
    public function livesync()
    {
        $this->layout = false;

        if($this->request->is('ajax')) {
            $notifications = $this->Notifications->find()
                ->limit(4)
                ->where(['user_id' => $this->Authentication->getIdentity()->id])
                ->order(['created'=>'DESC'])
                ->toList();
            echo json_encode($notifications);
            exit;
        }
    }

    public function toggleajax($id)
    {
        $this->layout = false;

        if($this->request->is(['ajax', 'get'])) {
            if(!$this->Notifications->get($id)) {
                echo '404';
            }

            $toggle = [
                'seen' => true
            ];
            $notification = $this->Notifications->get($id);
            $notification = $this->Notifications->patchEntity($notification, $toggle);
            if($this->Notifications->save($notification)) {
                echo '200';
            } else {
                echo '500';
            }
        }
        exit;
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * toggle method for switching boolean values
     *
     * @param string $id
     * @param string $field
     * @return void
     */
    public function toggle($id = null, $field = null, $flashMessage = true, $redirect = true)
    {
        $notification = $this->Notifications->get($id);
        if (!$notification) {
            throw new NotFoundException(__('Invalid notification'));
        }
        
        $toggle = [
            $field => !$notification->$field
        ];
        ($toggle[$field]) ? $newVal = 'true' : $newVal = 'false';

        $notification = $this->Notifications->patchEntity($notification, $toggle);
        if($this->Notifications->save($notification)) {
            if($flashMessage)
                $this->Flash->success(__('Field <strong>{0}</strong> set to {1}', $field, $newVal), ['escape'=>false]);
        } else {
            if($flashMessage)
                $this->Flash->error(__('Field <strong>{0}</strong> could not set to {1}', $field, $newVal), ['escape'=>false]);
        }
        if($redirect)
            return $this->redirect($this->referer());  
    }
}
