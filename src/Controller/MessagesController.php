<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\Event;

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
     * beforeRender method
     * 
     * @param  \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|null
     */
    public function beforeRender(\Cake\Event\EventInterface $event): void
    {
        $unread = $this->Messages->find()
            ->where([
                'Messages.to_user_id' => $this->Authentication->getIdentity()->id,
                'Messages.seen' => 0
            ])
            ->count();
        $this->set(compact('unread'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $messages = $this->Messages->find('all')->contain(['FromUsers' => ['Profiles'], 'ToUsers' => ['Profiles']]);

        switch($this->request->getParam('pass.0')) {
            case 'sent':
                $title = 'Sent';
                $messages = $messages
                    ->where([
                        'Messages.from_user_id' => $this->Authentication->getIdentity()->id,
                        'Messages.deleted' => false
                    ]);
                break;
            case 'trash':
                $title = 'Trash';
                $messages = $messages
                    ->where([
                        'Messages.to_user_id' => $this->Authentication->getIdentity()->id,
                        'Messages.deleted' => true
                    ]);
                break;
            default:
                $title = 'Inbox';
                $messages = $messages
                    ->where([
                        'Messages.to_user_id' => $this->Authentication->getIdentity()->id,
                        'Messages.deleted' => false
                    ]);
        }

        $messages = $messages->order(['Messages.created' => 'DESC']);
        
        $messages = $this->paginate($messages);

        $this->set(compact('messages', 'title'));
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

        if(!$message->seen && $message->to_user_id == $_SESSION['Auth']->id) {
            $message = $this->Messages->patchEntity($message, ['seen' => true]);
            $this->Messages->save($message);
            return $this->redirect(['action' => 'view', $id]);
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

        // if reply message, prefill content
        if(!empty($this->request->getParam('pass.0'))) {
            $rply = $this->Messages->find()
                        ->where(['Messages.id' => $this->request->getParam('pass.0')])
                        ->contain(['ToUsers' => ['Profiles'], 'FromUsers' => ['Profiles']])
                        ->first();
            $message->to_user_id = $rply->from_user_id;
            $message->subject = 'Re: ' . $rply->subject;

            $rplyFrom = '"' . $rply->from_user->profile->name . '"" (' . $rply->from_user->username . ')';
            $rplyFrom .= ' | ' . $rply->created->format("d.m.Y H:i");
            $rplyMsg = $rply->message;

            $message->message = <<<HTML
                <br />
                <hr />
                <p>
                    [Original Message: ${rplyFrom}]<br />
                    ${rplyMsg}
                </p>
            HTML;
        }

        if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been sent.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be sent. Please, try again.'));
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

        // just mark "deleted" in database
        if(!$message->deleted) {
            $delete = ['deleted' => true];
            $message = $this->Messages->patchEntity($message, $delete);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been deleted.'));
            } else {
                $this->Flash->error(__('The message could not be deleted. Please, try again.'));
            }

        // delete entirely if already marked as "deleted"
        } else {
            if ($this->Messages->delete($message)) {
                $this->Flash->success(__('The message has been deleted entirely.'));
            } else {
                $this->Flash->error(__('The message could not be deleted entirely. Please, try again.'));
            }
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
