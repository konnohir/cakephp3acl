<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Roles Controller
 * 権限マスタ
 */
class RolesController extends AppController
{
    /**
     * Index method
     */
    public function index() {
        $roles = $this->paginate($this->Roles, [

        ]);

        $this->set(compact('roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     */
    public function view($id = null) {
        $role = $this->Roles->get($id, [
            'contain' => ['RoleDetails']
        ]);

        $this->set('role', $role);
    }

    /**
     * Add method
     */
    public function add() {
        $role = $this->Roles->newEntity([
            'role_details' => []
        ], ['validate' => false]);
        $this->setAction('form', $role);
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     */
    public function edit($id = null) {
        $role = $this->Roles->get($id, [
            'contain' => ['RoleDetails']
        ]);
        $this->setAction('form', $role);
    }

    /**
     * Form method
     */
    protected function form($role) {

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            
            if (!$role->getErrors()) {
                $this->begin();
                try {
                    $this->Roles->saveOrFail($role, ['atomic' => false]);
                    $this->commit();
                }catch(\Exception $e) {
                    $this->rollback();
                    throw $e;
                }
                
                $this->Flash->success(__('I-SAVE', __($this->name)));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('E-SAVE', __($this->name)));
        }
        $roleDetails = $this->Roles->RoleDetails->find('list');
        $this->set(compact('role', 'roleDetails'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        
        $this->begin();
        try {
            $this->Roles->deleteOrFail($role);
            $this->commit();
        }catch(\Exception $e) {
            $this->rollback();
            throw $e;
        }

        $this->Flash->success(__('I-DELETE', __($this->name)));
        return $this->redirect(['action' => 'index']);
    }
}
