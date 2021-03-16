<?php
use Migrations\AbstractMigration;

class CreateUsersDevices extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users_devices');
        $table->addColumn(
            'user_id', 'integer', [
            'default' => null,
            'null' => false,]
        );
        $table->addColumn(
            'device_id', 'integer', [
            'default' => null,
            'null' => false,]
        );
        $table->addColumn(
            'assigned_date', 'datetime', [
            'default' => null ,
            'null' => false,]
        );
        $table->addColumn(
            'returned_date', 'datetime', [
            'default' => null,
            'null' => true,]
        );
        $table->create();
    }
}
