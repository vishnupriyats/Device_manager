<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device[]|\Cake\Collection\CollectionInterface $devices
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?>
    </ul>
</nav>
<div class="devices index large-9 medium-8 columns content">
    <h3><?= __('Devices') ?></h3>


    <table cellpadding="0" cellspacing="0">
        <thead>
        
            <tr>
                
                <th scope="col"><?= $this->Paginator->sort('user name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('userId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('device name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deviceId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('assigned_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('returned_date') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log):
                ?>
            <tr>
               
                <td><?= h($log->user->first_name)?>  <?= h($log->user->last_name) ?></td>
                <td><?= h($log->user_id) ?></td>
                <td><?= h($log->device->model) ?></td>
                <td><?= h($log->device_id) ?></td>
                <td><?= h($log->assigned_date) ?></td>
                <td><?= h($log->returned_date) ?></td>
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
