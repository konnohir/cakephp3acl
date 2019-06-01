<?php
use Migrations\AbstractMigration;

class Rev0003 extends AbstractMigration
{

    public function up()
    {

        $this->table('acos_role_details')
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

        $this->table('roles_role_details')
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

        $this->table('aco_role_details')->drop()->save();

        $this->table('role_role_details')->drop()->save();
    }

    public function down()
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

        $this->table('acos_role_details')->drop()->save();

        $this->table('roles_role_details')->drop()->save();
    }
}

