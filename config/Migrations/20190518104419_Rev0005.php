<?php
use Migrations\AbstractMigration;

class Rev0005 extends AbstractMigration
{

    public function up()
    {

        $this->table('role_details')
            ->addColumn('updated_at', 'datetime', [
                'after' => 'description',
                'default' => 'CURRENT_TIMESTAMP(6)',
                'length' => null,
                'limit' => 6,
                'null' => false,
            ])
            /*->addColumn('deleted_at', 'datetime', [
                'after' => 'updated_at',
                'default' => null,
                'length' => null,
                'null' => true,
            ])*/
            ->update();
/*
        $this->table('roles')
            ->addColumn('updated_at', 'datetime', [
                'after' => 'description',
                'default' => 'CURRENT_TIMESTAMP(6)',
                'length' => null,
                'null' => false,
            ])
            ->addColumn('deleted_at', 'datetime', [
                'after' => 'updated_at',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                    'deleted_at',
                ],
                [
                    'name' => 'deleted',
                ]
            )
            ->update();

        $this->table('users')
            ->addColumn('password', 'string', [
                'after' => 'name',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->addColumn('updated_at', 'timestamp', [
                'after' => 'role_id',
                'default' => 'CURRENT_TIMESTAMP(6)',
                'length' => null,
                'null' => false,
            ])
            ->addColumn('deleted_at', 'datetime', [
                'after' => 'updated_at',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();*/
    }

    public function down()
    {

        $this->table('role_details')
            ->removeColumn('updated_at')
        /*    ->removeColumn('deleted_at')*/
            ->update();
/*
        $this->table('roles')
            ->removeIndexByName('deleted')
            ->update();

        $this->table('roles')
            ->removeColumn('updated_at')
            ->removeColumn('deleted_at')
            ->update();

        $this->table('users')
            ->removeColumn('password')
            ->removeColumn('updated_at')
            ->removeColumn('deleted_at')
            ->update();*/
    }
}

