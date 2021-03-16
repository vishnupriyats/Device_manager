<h1>Login</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('email') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->button('Login') ?>
<p>Not having an account?</p>
<?= $this->Html->link(__('Register'), ['controller'=> 'Users', 'action' => 'add']) ?> </li>
<?= $this->Form->end() ?>