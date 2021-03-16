<?php
use Migrations\AbstractMigration;

class CreateDevices extends AbstractMigration
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
        $table = $this->table('devices');
        $table->addColumn(
            'browser', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => false,]
        );
        $table->addColumn(
            'os', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => false,]
        );
        $table->addColumn(
            'os_version', 'string', [
            'limit' => 40,
            'null' => false,]
        );
        $table->addColumn(
            'model', 'string', [
            'default' => null,
            'limit' => 40,
            'null' => false,]
        );
        $table->addColumn(
            'status', 'integer', [
            'default' => 1,
            'null' => false,]
        );
        $table->create();
    }
}
