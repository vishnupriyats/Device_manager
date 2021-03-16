<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device[]|\Cake\Collection\CollectionInterface $devices
 */
use App\Model\Entity\User;
use App\Model\Entity\Device;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Home'), ['controller'=>'Users','action' => 'index']) ?></li>
    </ul>
</nav>
<div class="devices index large-9 medium-8 columns content">
    <h3><?= __('Notifications') ?></h3>
    
    <?php foreach ($notifications as $notify){ 
        
        if(isset($notify)){?>
        
        <?php if($notify->device_status === Device::NEWREQUEST){ ?>
        <h5>  New device is requested by <?= h($notify->user->first_name)?>  <?= h($notify->user->last_name)?> </h5>
        <h6>Device Details</h6>
        <?php $details=$notify->device_details;
        
        foreach ($details as $key => $value) { ?>
           
            <li><?php echo($key .":". $value); ?> </li>
        

         <?php } } else if($notify->device_status === Device::TAKEN) {?>

            <h5> A Device is taken by  <?= h($notify->user->first_name)?>  <?= h($notify->user->last_name)?> </h5>
            <p>For more details about the device <?= $this->Html->link(__('Click here'), ['controller'=>'Devices','action' => 'view', $notify->device_details['id']]) ?>


         <?php } else if($notify->device_status === Device::AVAILABLE) {?>

            <h5>A Device is returned by  <?= h($notify->user->first_name)?>  <?= h($notify->user->last_name)?> </h5>
            <p>For more details about the device <?= $this->Html->link(__('Click here'), ['controller'=>'Devices','action' => 'view', $notify->device_details['id']]) ?>

     <?php } } }?>

       
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
