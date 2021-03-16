<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn(
            'first_name', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => false,]
        );
        $table->addColumn(
            'last_name', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => false,]
        );
        $table->addColumn(
            'email', 'string', [
            'limit' => 40,
            'null' => false,]
        );
        $table->addColumn(
            'password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,]
        );
        $table->addColumn(
            'team', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => false,]
        );
        $table->addColumn(
            'type', 'integer', [
            'default' => 0,
            'null' => false,]
        );
        $table->create();
    }
}
