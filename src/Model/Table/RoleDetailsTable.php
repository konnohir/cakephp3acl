<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\BaseTable as Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Entity;

class RoleDetailsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setDisplayField('name');

        $this->belongsToMany('Acos');
        $this->belongsToMany('Roles');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 45)
            ->allowEmptyString('description');

        return $validator;
    }
    
    public function afterSave(Event $event, Entity $entity) {

        if (empty($entity->roles)) {
            return;
        }
         
        // 必要なモデルを読み込む
        $this->loadModel('Roles');

        // 権限のupdated_atを更新する (RolesテーブルのafterSaveイベントが実行される)
        foreach($entity->roles as $role) {
            $this->Roles->touch($role, ['atomic' => false]);
        }
    }
    
    public function beforeDelete(Event $event, Entity $entity) {

        if (empty($entity->roles)) {
            return;
        }

        $this->touchRoles = $entity->roles;
    }
    
    public function afterDelete(Event $event, Entity $entity) {

        if (empty($this->touchRoles)) {
            return;
        }
         
        // 必要なモデルを読み込む
        $this->loadModel('Roles');

        // 権限のupdated_atを更新する (RolesテーブルのafterSaveイベントが実行される)
        foreach($this->touchRoles as $role) {
            $this->Roles->touch($role, ['atomic' => false]);
        }
        $this->touchRoles = [];
    }
}
