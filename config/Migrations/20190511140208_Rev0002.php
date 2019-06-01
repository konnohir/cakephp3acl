<?php
use Migrations\AbstractMigration;

class Rev0002 extends AbstractMigration
{

    public function up()
    {

        $this->table('aco_role_details')
            ->addColumn('aco_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('role_detail_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'aco_id',
                    'role_detail_id',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('role_details')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();

        $this->table('role_role_details')
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('role_detail_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'role_id',
                    'role_detail_id',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('roles')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();
    }

    public function down()
    {

        $this->table('aco_role_details')->drop()->save();

        $this->table('role_details')->drop()->save();

        $this->table('role_role_details')->drop()->save();

        $this->table('roles')->drop()->save();

        $this->table('users')->drop()->save();
    }
}

