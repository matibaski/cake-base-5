<?php
declare(strict_types=1);

namespace App\Controller;

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
            ->contain(['FromUsers' => ['Profiles'], 'ToUsers' => ['Profiles']])
            ->where(['Messages.to_user_id' => $this->Authentication->getIdentity()->id])
            ->order(['Messages.created' => 'DESC'])
        );

        $this->set(compact('messages'));
    }

    /**
     * Sent method
     *
     * @return \Cake\Http\Response|null
     */
    public function sent()
    {
        $messages = $this->paginate($this->Messages
            ->find('all')
            ->contain(['FromUsers' => ['Profiles'], 'ToUsers' => ['Profiles']])
            ->where(['Messages.from_user_id' => $this->Authentication->getIdentity()->id])
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
            'contain' => ['ToUsers' => ['Profiles'], 'FromUsers' => ['Profiles']],
        ]);

        if(!$message->seen) {
            $message = $this->Messages->patchEntity($message, ['seen' => true]);
            $this->Messages->save($message);
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
            $data = $this->request->getData();
            $data['seen'] = false;
            $data['from_user_id'] = $this->Authentication->getIdentity()->id;
            $message = $this->Messages->patchEntity($message, $data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $toUsers = $this->Messages->ToUsers->find('list', ['limit' => 200]);
        $fromUsers = $this->Messages->FromUsers->find('list', ['limit' => 200]);
        $this->set(compact('message', 'toUsers', 'fromUsers'));
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
     * toggleajax method
     * 
     * @param  int $id
     * @return null
     */
    public function toggleajax($id)
    {
        $this->layout = false;

        if($this->request->is(['ajax', 'get'])) {
            if(!$this->Messages->get($id)) {
                echo '404';
            }

            $toggle = [
                'seen' => true
            ];
            $message = $this->Messages->get($id);
            $message = $this->Messages->patchEntity($message, $toggle);
            if($this->Messages->save($message)) {
                echo '200';
            } else {
                echo '500';
            }
        }
        exit;
    }
}
