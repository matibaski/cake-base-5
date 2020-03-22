<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Mailer\MailerAwareTrait;

class UsersController extends AppController
{
    use MailerAwareTrait;
    
    /**
     * Index method
     * 
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        if($this->Authentication->getIdentity()->role != 'admin') {
            return $this->redirect(['action' => 'view', $this->Authentication->getIdentity()->id]);
        }

        $query = $this->Users->find()->where(['disabled' => false]);
        if($this->request->getParam('pass.0') == 'disabled') {
            $query = $this->Users->find()->where(['disabled' => true]);
        }
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     * 
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        $user = $this->Users->find()->contain('Profiles')->where(['Users.id' => $id])->first();

        if(!$user) {
            throw new NotFoundException(__('User not found'));
        }
        
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        // check if user is admin or the user himself
        if($this->Authentication->getIdentity()->role != 'admin') {
            $this->Flash->error(__('You are not allowed to create new users.'));
            return $this->redirect($this->request->referer());
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // check passwords match
            if($data['password'] != $data['password_confirm']) {
                return $this->Flash->error(__('Passwords don\'t match.'));
            }
            unset($data['password_confirm']);

            $user = $this->Users->patchEntity($user, $data, ['associated' => ['Profiles']]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Profiles'],
        ]);

        // check if user is admin or the user himself
        if(($this->Authentication->getIdentity()->role != 'admin') && ($this->Authentication->getIdentity()->id != $id)) {
            $this->Flash->error(__('You are not allowed to access that page'));
            return $this->redirect('/');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['associated' => ['Profiles']]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);

        // delete only for admins or user himself
        if(($this->Authentication->getIdentity()->role != 'admin') && ($this->Authentication->getIdentity()->id != $id)) {
            $this->Flash->error(__('You are not allowed to delete {0}{1}{2}', '<b>', $user->username, '</b>'));
            return $this->redirect($this->request->referer());
        }

        // cannot delete himself if admin
        if($this->Authentication->getIdentity()->id == $id && $this->Authentication->getIdentity()->role == 'admin') {
            $this->Flash->error(__('You are not allowed to delete yourself, because you are admin.'));
            return $this->redirect($this->request->referer());
        }

        // user already disabled, delete fully
        if($user->disabled) {
            if($this->Authentication->getIdentity()->role == 'admin') {
                $user = $this->Users->find()->where(['Users.id' => $user->id])->contain(['Profiles'])->first();
                if($this->Users->delete($user)) {
                    $this->Flash->success(__('User has been deleted.'));
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__('User is already disabled'));
                return $this->redirect($this->referer());
            }
        }
        $data = ['disabled' => true];
        $user = $this->Users->patchEntity($user, $data);
        if ($this->Users->save($user)) {

            // user deleted himself. logout.
            if($this->Authentication->getIdentity()->id == $id) {
                $this->Authentication->logout();
                $this->Flash->success(__('Your user has been disabled'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }

            $this->Flash->success(__('The user has been disabled.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Register method
     * 
     * @return \Cake\Http\Response|null Redirects on successful register, renders view otherwise.
     */
    public function register()
    {
        $this->viewBuilder()->setLayout('splash');
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {

            // generate activation key
            $data = $this->request->getData();
            $data['activation_hash'] = sha1(mt_rand(10000,99999).time().$data['username']);
            $data['role'] = 'user';
            
            $user = $this->Users->newEntity($data, ['associated' => 'Profiles']);
            if ($this->Users->save($user)) {
                $this->getMailer('User')->send('welcome', [$user]);
                $this->Toast->success(__('You need to activate your user. Check your emails.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Toast->error(__('Could not register. Please contact support.'));
        }

        $this->set('user', $user);
    }

    /**
     * activate hash
     * @param  string $hash
     * @return \Cake\Http\Response|null Toast message on login page.
     */
    public function activate($hash = null) {
        $this->layout = false;

        // check if hash is given
        if(!$hash) {
            $this->Toast->error(__('No token!'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        // check if hash is valid
        $user = $this->Users->find()->where(['activation_hash' => $hash])->first();
        if(!$user) {
            $this->Toast->error(__('Invalid token!'));
        }

        // check if user is already active
        elseif($user->active) {
            $updateUser = ['activation_hash' => ''];
            $user = $this->Users->patchEntity($user, $updateUser);
            
            if($this->Users->save($user)) {
                $this->Toast->success(__('You can now log in.'));
            } else {
                $this->Toast->error(__('Could not activate user'));
            }
        }

        // user can be activated
        else {
            $updateUser = [
                'activation_hash' => '',
                'active' => true
            ];
            $user = $this->Users->patchEntity($user, $updateUser);
            if($this->Users->save($user)) {
                $this->Toast->success(__('You can now log in.'));
            } else {
                $this->Toast->error(__('Could not activate user'));
            }
        }

        return $this->redirect(['controller' => 'users', 'action' => 'login']);
    }

    /**
     * Login method
     * 
     * @return \Cake\Http\Response|null Redirects on successful login, renders view otherwise.
     */
    public function login() {
        $this->viewBuilder()->setLayout('splash');
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();
        $identity = $this->Authentication->getIdentity();

        // check credentials
        if ($this->request->is('post')) {
            if(!empty($result->getErrors()) && count($result->getErrors()) > 0) {
                foreach($result->getErrors() as $error) {
                    if(!empty($error)) {
                        $this->Toast->error($error);
                    }
                }
            }

            if(!$result->isValid()) {
                return $this->Toast->error(__('Invalid username or password.'));
            } elseif(!$identity->active) {
                $this->Toast->error(__('User is not activated yet.'));
                return $this->Authentication->logout();
            } elseif($identity->disabled) {
                $this->Toast->error(__('User is deactivated.'));
                return $this->Authentication->logout();
            }
        }

        // redirect if user is already logged in
        if ($result->isValid() && $identity->active && !$identity->disabled) {
            $redirect = $this->request->getQuery('redirect', '/');

            return $this->redirect($redirect);
        }
    }

    /**
     * Logout method
     * 
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Forgot method
     *
     * @return \Cake\Http\Response\null
     */
    public function forgot()
    {
        $this->viewBuilder()->setLayout('splash');
        $this->request->allowMethod(['get', 'post']);

        if($this->request->is('post')) {
            $data = $this->request->getData();
            $forgotSuccessMessage = 'If your email address was correct, you\'re going to receive an email';

            $user = $this->Users->find()->where(['username' => $data['username']])->contain(['Profiles'])->first();
            if(!$user) {
                $this->Toast->success(__($forgotSuccessMessage));
                return $this->redirect(['action' => 'login']);
            } elseif(!$user->active) {
                return $this->Toast->error(__('Your user is not activated.'));
            } elseif($user->disabled) {
                return $this->Toast->error(__('Your user is disabled.'));
            }

            $newPassword = $this->generatePassword(14);
            $user = $this->Users->patchEntity($user, ['password' => $newPassword]);
            if($this->Users->save($user)) {
                $this->Toast->success(__($forgotSuccessMessage));
                $this->getMailer('User')->send('forgot', [$user, $newPassword]);
                return $this->redirect(['action' => 'login']);
            } else {
                return $this->Toast->error(__('There was an error resetting your password.'));
            }
        }
    }

    /**
     * Password method
     * 
     * @param  integer $id
     * @return \Cake\Http\Response|null
     */
    public function password($id = null)
    {
        $user = $this->Users->find()
            ->where(['Users.id' => $id])
            ->contain(['Profiles'])
            ->first();

        // check if user is admin or the user himself
        if(($this->Authentication->getIdentity()->role != 'admin') && ($this->Authentication->getIdentity()->id != $id)) {
            $this->Flash->error(__('You are not allowed to change the password for {0}{1}{2}', '<b>', $user->username, '</b>'));
            return $this->redirect($this->request->referer());
        }

        $this->set('user', $user);

        if ($this->request->is(['patch', 'post', 'put'])) { 
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)) {
                $this->Flash->success(__('Password has been updated'));
                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('Could not update password. Please, try again.'));
        }
    }

    /**
     * GeneratePassword method
     * @param  integer $length
     * @return string  $result
     */
    private function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.!?$_#';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}