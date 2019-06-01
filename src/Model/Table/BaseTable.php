<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\ORM\Association\BelongsToMany;
use Cake\Datasource\ModelAwareTrait;
use InvalidArgumentException;
use DateTime;

class BaseTable extends Table {

    use ModelAwareTrait;

    // 楽観ロック用のフィールド名
    protected $_lockField = '_lock';

    public function beforeMarshal($event, $data, $options) {
        // 楽観ロック用のフィールドをエンティティに一括代入するための設定
        $options['accessibleFields'][$this->_lockField] = true;
    }

    public function beforeFind($event, $query, $options, $primary) {
        $query->where([$this->getAlias() . '.deleted_at is null']);
    }

    public function touch($entity, $options = []) {
        $entity->set('_lock', $entity->updated_at);
        $entity->set('updated_at');
        $this->saveOrFail($entity, $options);
    }
    
    /**
     * Auxiliary function to handle the update of an entity's data in the table
     *
     * @param \Cake\Datasource\EntityInterface $entity the subject entity from were $data was extracted
     * @param array $data The actual data that needs to be saved
     * @return \Cake\Datasource\EntityInterface|bool
     * @throws \InvalidArgumentException When primary key data is missing.
     */
    protected function _update($entity, $data) {
        $primaryColumns = (array)$this->getPrimaryKey();
        $primaryKey = $entity->extract($primaryColumns);

        $data = array_diff_key($data, $primaryKey);
        if (empty($data)) {
            return $entity;
        }

        if (count($primaryColumns) === 0) {
            $entityClass = get_class($entity);
            $table = $this->getTable();
            $message = "Cannot update `$entityClass`. The `$table` has no primary key.";
            throw new InvalidArgumentException($message);
        }

        if (!$entity->has($primaryColumns)) {
            $message = 'All primary key value(s) are needed for updating, ';
            $message .= get_class($entity) . ' is missing ' . implode(', ', $primaryColumns);
            throw new InvalidArgumentException($message);
        }

        $query = $this->query();
        $statement = $query->update()
            ->set($data)
            ->where($primaryKey);

        if ($entity->has($this->_lockField)) {
            $statement->where([$this->getAlias() . '.updated_at' => $entity->{$this->_lockField}]);
        }
        $statement = $statement->execute();

        $success = false;
        if ($statement->errorCode() === '00000') {
            if ($statement->rowCount() === 0) {
                $statement->closeCursor();
                throw new \Exception('locked'.$entity->_lock);
            }
            $success = $entity;
        }
        $statement->closeCursor();

        return $success;
    }
    

    /**
     * Perform the delete operation.
     *
     * Will delete the entity provided. Will remove rows from any
     * dependent associations, and clear out join tables for BelongsToMany associations.
     *
     * @param \Cake\Datasource\EntityInterface $entity The entity to delete.
     * @param \ArrayObject $options The options for the delete.
     * @throws \InvalidArgumentException if there are no primary key values of the
     * passed entity
     * @return bool success
     */
    protected function _processDelete($entity, $options)
    {
        if ($entity->isNew()) {
            return false;
        }

        $primaryKey = (array)$this->getPrimaryKey();
        if (!$entity->has($primaryKey)) {
            $msg = 'Deleting requires all primary key values.';
            throw new InvalidArgumentException($msg);
        }

        if ($options['checkRules'] && !$this->checkRules($entity, RulesChecker::DELETE, $options)) {
            return false;
        }

        $event = $this->dispatchEvent('Model.beforeDelete', [
            'entity' => $entity,
            'options' => $options
        ]);

        if ($event->isStopped()) {
            return $event->getResult();
        }

        $this->_associations->cascadeDelete(
            $entity,
            ['_primary' => false] + $options->getArrayCopy()
        );

        $query = $this->query();
        $conditions = (array)$entity->extract($primaryKey);
        $statement = $query->update()
            ->set(['deleted_at' => (new DateTime())->format('Y-m-d H:i:s.u')])
            ->where($conditions)
            ->execute();

        $success = $statement->rowCount() > 0;
        if (!$success) {
            return $success;
        }

        $this->dispatchEvent('Model.afterDelete', [
            'entity' => $entity,
            'options' => $options
        ]);

        return $success;
    }
    
}