<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\BaseTable as Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\ORM\Entity;
/**
 * Roles Model
 */
class RolesTable extends Table
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

        $this->hasMany('Users');
        $this->belongsToMany('RoleDetails');
        
        $this->addBehavior('Acl.Acl', ['requester']);
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
        
        if (!isset($entity->role_details)) {
            throw new \Exception('$entity->role_details is needed');
        }
        
        // 必要なモデルを読み込む
        // Permission テーブルはAclコンポーネントで定義されている(物理名：aros_acos))
        $this->loadModel('Permissions');
        $this->loadModel('Aros');
        $this->loadModel('AcosRoleDetails');

        // 権限に紐づくAroエンティティーを取得する
        $aro = $this->Aros->find()->where([
            'model' => 'Roles',
            'foreign_key' => $entity->id,
        ])->first();

        if (empty($aro->id)) {
            return;
        }

        // Permissions テーブルからAroに紐づくデータをすべて削除する
        $this->Permissions->deleteAll(['aro_id' => $aro->id]);

        // 権限に紐づく権限詳細のID一覧を取得する
        $roleDetailIds = array_column($entity->role_details, 'id');

        if (empty($roleDetailIds)) {
            return;
        }

        // 権限詳細に紐づくAcoのID一覧(重複排除)を取得する
        $acoIds = $this->AcosRoleDetails->find('list', [
            'keyField' => 'id',
            'valueField' => 'aco_id'
        ])->distinct([
            'aco_id'
        ])->where([
            'role_detail_id IN' => $roleDetailIds,
        ])->toList();

        // Permission テーブルにアクセス権を登録する
        foreach ($acoIds as $acoId) {
            $this->Permissions->allow($aro->id, $acoId);
        }

    }

}
