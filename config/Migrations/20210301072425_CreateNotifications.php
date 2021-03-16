<?php
use Migrations\AbstractMigration;

class CreateNotifications extends AbstractMigration
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
        $table = $this->table('notifications');
        $table->addColumn(
            'user_id', 'integer', [
            'default' => null,
            'null' => false,]
        );
        $table->addColumn(
            'device_status', 'integer', [
            'default' => null,
            'null' => false,]
        );
        $table->addColumn(
            'device_details', 'json', [
            'default' => null,
            'null' => false,]
        );

        $table->create();
    }
}
