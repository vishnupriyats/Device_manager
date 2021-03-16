<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\Model\Entity\Device;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $devices = $this->paginate("Devices");
        $id = $this->Auth->User('id');
        if (!isset($id)) {
            return $this->redirect(["action" => 'login']);
        }
        $user = $this->Users->get($id);
        $this->set(compact('user', 'devices'));
    }
    /**
     * View method
     *
     * @param  integer| $id User id.
     * @return \Cake\Http\Response| redirects to view page
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {     
        $user = $this->Users->get($id);
        $this->set('user', $user);
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Auth->setUser($user);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set('user', $user);
    }

    /**
     * Edit method
     *
     * @param  integer|null $id User id.
     * @return \Cake\Http\Response| Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity(
                $user, $this->request->getData(), [
                // Added: Disable modification of id.
                'accessibleFields' => ['id' => false]]
            );
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $devices = $this->Users->Devices->find('list', ['limit' => 200]);
        $this->set(compact('user', 'devices'));
    }

    /**
     * Delete method
     *
     * @param  integer| $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response| Redirects on successful login, renders login otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect(['controller'=>'Users','action'=>'index']);       
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response| Redirects on successful logout, renders index otherwise.
     */
    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * RequestDevice method
     *
     * @return \Cake\Http\Response| Redirects on successful request, renders index otherwise.
     */
    public function requestDevice()
    {
        $this->loadModel('Notifications');
        $notify = $this->Notifications->newEntity();
        $id = $this->Auth->User('id');
        if ($this->request->is('post')) {
            $notify-> user_id = $id;
            $notify-> device_status = Device::NEWREQUEST;
            $notify-> device_details = $this->request->getData();
            print_r($notify);
            if ($this->Notifications->save($notify)) {
                $this->Flash->success(__('The request is sent.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('request denied'));
        }
        $this->set(compact('notify'));
    }

    /**
     * Notifications method
     *
     * @return \Cake\Http\Response| renders notifications.
     */
    public function notifications()
    {
        $this->loadModel('Notifications');
        $notifications = $this->paginate(
            $this->Notifications->find(
                'all', [
                'contain' => ['Users'],
                'order' => array( 'Notifications.id' => 'DESC'),]
            )
        );
        $this->set(compact('notifications'));
    }
    /**
     * IsAuthorized method
     *
     * @param  object| $user Auth user
     * @return boolean true or false for authorization .
     */
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if (in_array($action, ['add','login','logout','requestDevice'])) {
            return true;
        } else if ($action === "notifications" and $user['type'] === User::ADMIN) {
            return true;
        }
        $id = $this->request->getParam('pass.0');
        $users = $this->Users->findById($id)->first();
        if (!$id) {
            return false;
        }
        return $users->id === $user['id'];
    }   
}
