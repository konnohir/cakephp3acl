<?php
use Migrations\AbstractMigration;

class Rev0004 extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('role_id', 'integer', [
                'after' => 'description',
                'default' => null,
                'length' => 11,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('role_id')
            ->update();
    }
}

