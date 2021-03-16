<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsersDevices Controller
 *
 * @property \App\Model\Table\UsersDevicesTable $UsersDevices
 *
 * @method \App\Model\Entity\UsersDevice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersDevicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Devices'],
        ];
        $usersDevices = $this->paginate($this->UsersDevices);

        $this->set(compact('usersDevices'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Device id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersDevice = $this->UsersDevices->get($id, [
            'contain' => ['Users', 'Devices'],
        ]);

        $this->set('usersDevice', $usersDevice);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersDevice = $this->UsersDevices->newEntity();
        if ($this->request->is('post')) {
            $usersDevice = $this->UsersDevices->patchEntity($usersDevice, $this->request->getData());
            if ($this->UsersDevices->save($usersDevice)) {
                $this->Flash->success(__('The users device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users device could not be saved. Please, try again.'));
        }
        $users = $this->UsersDevices->Users->find('list', ['limit' => 200]);
        $devices = $this->UsersDevices->Devices->find('list', ['limit' => 200]);
        $this->set(compact('usersDevice', 'users', 'devices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Device id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersDevice = $this->UsersDevices->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersDevice = $this->UsersDevices->patchEntity($usersDevice, $this->request->getData());
            if ($this->UsersDevices->save($usersDevice)) {
                $this->Flash->success(__('The users device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users device could not be saved. Please, try again.'));
        }
        $users = $this->UsersDevices->Users->find('list', ['limit' => 200]);
        $devices = $this->UsersDevices->Devices->find('list', ['limit' => 200]);
        $this->set(compact('usersDevice', 'users', 'devices'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Device id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersDevice = $this->UsersDevices->get($id);
        if ($this->UsersDevices->delete($usersDevice)) {
            $this->Flash->success(__('The users device has been deleted.'));
        } else {
            $this->Flash->error(__('The users device could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
