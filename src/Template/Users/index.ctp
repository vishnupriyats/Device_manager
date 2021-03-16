<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 *
 */
use App\Model\Entity\User;
use App\Model\Entity\Device;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <!-- <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li> --><!-- 
         -->
         <!-- <li><?= $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('New Device'), ['controller' => 'Devices', 'action' => 'add']) ?></li> -->

        <?php if($user->type === User::USER){ ?>

        <li><?= $this->Html->link(__('View Profile'), ['action' => 'view',$user->id]) ?></li>
        <li><?= $this->Html->link(__('Log Details'), ['controller'=>'Devices','action' => 'usersLog']) ?></li>
        <li><?= $this->Html->link(__('Request for new device'), ['action' => 'requestDevice']) ?></li>
        <li><?= $this->Html->link(__('Logout'), ['action' => 'logout']) ?></li>
        
    <?php } elseif($user->type === User::ADMIN){ ?>
        <li><?= $this->Html->link(__('New Device'), ['controller' => 'Devices','action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('User Logs'), ['controller'=>'Devices','action' => 'usersLog']) ?></li>
        <li><?= $this->Html->link(__('Notifications'), ['controller'=>'Users','action' => 'notifications']) ?></li>
        <li><?= $this->Html->link(__('Logout'), [ 'action' => 'logout']) ?>
        
    <?php } ?>
    </ul>
</nav>

<div class="devices index large-9 medium-8 columns content">
    <h3><?= __('Devices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('browser') ?></th>
                <th scope="col"><?= $this->Paginator->sort('os') ?></th>
                <th scope="col"><?= $this->Paginator->sort('os_version') ?></th>
                <th scope="col"><?= $this->Paginator->sort('model') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devices as $device): ?>
            <tr>
                <td><?= $this->Number->format($device->id) ?></td>
                <td><?= h($device->browser) ?></td>
                <td><?= h($device->os) ?></td>
                <td><?= h($device->os_version) ?></td>
                <td><?= h($device->model) ?></td>
                <?php if($device->status === Device::AVAILABLE) { ?>
                    <td><?= h("Available") ?></td>
                <?php } else if($device->status === Device::TAKEN) {?>
                    <td> <?= h("taken") ?> </td>
                <?php } ?> 
                <?php if($user->type === User::ADMIN){ ?>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Devices','action' => 'view', $device->id]) ?>
                </td>
            <?php } elseif($user->type === User::USER){ ?>
                <td class="actions">
                    <?php if($device->status === Device::AVAILABLE){ ?> 
                     <?= $this->Form->postlink(__('assign'),['controller'=>'Devices','action'=>'assign',$device->id,'borrow'])?>
                    <?php }else{ ?>
                     <?= $this->Form->postlink(__('Return'),['controller'=>'Devices','action'=>'assign',$device->id,'return'])?>
                     <?php } ?>
                </td>
            <?php } ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

