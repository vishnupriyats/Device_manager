<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use APp\Model\Entity\Device;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Devices Controller
 *
 * @property \App\Model\Table\DevicesTable $Devices
 *
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevicesController extends AppController
{
    


    /**
     * View method
     *
     * @param integer|$id Device id.
     * @return \Cake\Http\Response| renders the view page
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        $device = $this->Devices->get(
            $id, [
            'contain' => ['Users'],]
        );

        $this->set('device', $device);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response| Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $device = $this->Devices->newEntity();
        $device->status === Device::AVAILABLE;
        if ($this->request->is('post')) {
            $device = $this->Devices->patchEntity(
                $device, $this->request->getData()
            );
            if ($this->Devices->save($device)) {
                $this->Flash->success(__('The device has been saved.'));

                return $this->redirect(
                    ['controller'=>'Users','action' => 'index']
                );
            }
            $this->Flash->error(
                __('The device could not be saved.Please, try again.')
            );
        }
        $this->set('device', $device);
    }

    /**
     * Edit method
     *
     * @param  integer| $id Device id.
     * @return \Cake\Http\Response| Redirects on successful edit, renders home otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $device = $this->Devices->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $device = $this->Devices->patchEntity($device, $this->request->getData());
            if ($this->Devices->save($device)) {
                $this->Flash->success(__('The device has been saved.'));

                return $this->redirect(['controller'=>'Users','action' => 'index']);
            }
            $this->Flash->error(__('The device could not be saved. Please, try again.'));
        }
         $this->set('device', $device);
    }

    /**
     * Delete method
     *
     * @param  integer| $id Device id.
     * @return \Cake\Http\Response| Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $device = $this->Devices->get($id);
        if ($this->Devices->delete($device)) {
            $this->Flash->success(__('The device has been deleted.'));
        } else {
            $this->Flash->error(__('The device could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller'=>'Users','action' => 'index']);
    }

    /**
     * Assign method
     *
     * @param  integer | $id  Device id
     * @param  string  | $ops (assign/borrow)
     * @return \Cake\Http\Response| On succssfull assign ,Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function assign($id, $ops)
    {
        $this->loadModel('UsersDevices');
        $this->loadModel('Notifications');
        $this->request->allowMethod(['post']);
        $usersDevice = $this->UsersDevices->findByDeviceId($id)->last();
        $device = $this->Devices->get($id); 
        if ($ops === "borrow") {

            if ($device->status === Device::AVAILABLE) {

                $device->status = Device::TAKEN;
                $this->Devices->save($device);
                $notify=$this->Notifications->newEntity();
                $notify->user_id=$this->Auth->User('id');
                $notify->device_status=Device::TAKEN;
                $notify->device_details=['id'=> $id ];
                $this->Notifications->save($notify);
                $usersDevice = $this->UsersDevices->newEntity();
                $usersDevice->user_id=$this->Auth->User('id');
                $usersDevice->device_id=$id;
                $usersDevice->assigned_date = Time::now();
                if ($this->UsersDevices->save($usersDevice)) {
                    $this->Flash->success(__('The users device has been saved.'));
                } else { 
                    $this->Flash->error(__('The users device could not be saved. Please, try again.'));
                }
            } else { 
                $this->Flash->error(__('Device not available'));
            }
        } else if ($ops === "return" ) {
            if (isset($usersDevice)&&($usersDevice->user_id === $this->Auth->User('id') && $device->status === Device::TAKEN )) {
                $device->status = Device::AVAILABLE;
                $usersDevice->returned_date = Time::now();
                $notify=$this->Notifications->newEntity();
                $notify->user_id = $this->Auth->User('id');
                $notify->device_status = Device::AVAILABLE;
                $notify->device_details = ['id'=> $id ];
                $this->Notifications->save($notify);
                $this->Devices->save($device);
                $this->UsersDevices->save($usersDevice);
            } else {
                $this->Flash->error(__('You are not authorised to access this location'));
            }
        }
        return $this->redirect(['controller'=>'Users','action'=>'index']);
    }

    /**
     * UsersLog method
     *
     * @return \Cake\Http\Response| Redirects to userlogs.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function usersLog() 
    {
        $this->loadModel('UsersDevices');
        $type=$this->Auth->User('type');
        $id=$this->Auth->User('id');
        if ($type === User::USER) {
            $logs = $this->paginate(
                $this->UsersDevices->findByUserId($id)
                    ->contain(['Users', 'Devices'])
                    ->order(['UsersDevices.Id'=>'DESC'])
            );
        } else if ($type === User::ADMIN) {
            $logs = $this->paginate(
                $this->UsersDevices->find(
                    'all', ['contain' => ['Users','Devices'],
                    'order' => array( 'UsersDevices.id' => 'DESC'),]
                )
            );
        }
        if (!isset($logs)) {
            $this->Flash->error(__("No activities found!"));
            return $this->redirect(['controller'=>'Users','action'=>'index']);
        } else {
            $this->set(compact('logs'));
        }
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
        if (in_array($action, ['usersLog','assign'])) {
            return true;
        }
        $id = $this->request->getParam('pass.0');
        if (!$id) {
            return false;
        }
        return $this->Auth->User('type') === User::ADMIN;
    }   
}