<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 *
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $messages = $this->paginate($this->Messages
            ->find('all')
            ->contain(['FromUser' => ['Profiles'], 'ToUser' => ['Profiles']])
            ->where(['Messages.to_user' => $this->Authentication->getIdentity()->id])
            ->order(['Messages.created' => 'DESC'])
        );

        $this->set(compact('messages'));
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['FromUser' => ['Profiles'], 'ToUser' => ['Profiles']],
        ]);

        if(!$message->seen) {
            $message = $this->Messages->patchEntity($message, ['seen' => true]);
            $this->Messages->save($message);
            return $this->redirect(['action' => 'view', $message->id]);
        }

        $this->set('message', $message);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEmptyEntity();
        if ($this->request->is('post')) {

            // manipulate data
            $data = $this->request->getData();
            $data['from_user'] = $this->Authentication->getIdentity()->id;
            $data['to_user'] = (int) $data['to_user'];
            $data['seen'] = false;

            $message = $this->Messages->patchEntity($message, $data);

            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $toUser = $this->Messages->ToUser->find('list', ['limit' => 200]);
        $this->set(compact('message', 'toUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
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
    public function toggle($id = null, $field = null) {
        $message = $this->Messages->get($id);
        if (!$message) {
            throw new NotFoundException(__('Invalid message'));
        }
        
        $toggle = [
            $field => !$message->$field
        ];
        ($toggle[$field]) ? $newVal = 'true' : $newVal = 'false';

        $message = $this->Messages->patchEntity($message, $toggle);
        if($this->Messages->save($message)) {
            $this->Flash->success(__('Field <strong>{0}</strong> set to {1}', $field, $newVal), ['escape'=>false]);
        } else {
            $this->Flash->error(__('Field <strong>{0}</strong> could not set to {1}', $field, $newVal), ['escape'=>false]);
        }
        return $this->redirect($this->referer());  
    }
}
