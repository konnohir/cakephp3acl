<?php
namespace App\Controller;

use App\Controller\AppController;
use DateTime;

/**
 * RoleDetails Controller
 * 権限詳細マスタ
 */
class RoleDetailsController extends AppController
{
    /**
     * Index method
     */
    public function index() {
        $roleDetails = $this->paginate($this->RoleDetails, [
            // 'finder' => 'index'
        ]);

        $this->set(compact('roleDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Role Detail id.
     */
    public function view($id = null) {
        $roleDetail = $this->RoleDetails->get($id, [
            'contain' => ['Acos']
        ]);

        $this->set('roleDetail', $roleDetail);
    }

    /**
     * Add method
     */
    public function add() {
        $roleDetail = $this->RoleDetails->newEntity();
        return $this->setAction('form', $roleDetail);
    }

    /**
     * Edit method
     *
     * @param string|null $id Role Detail id.
     */
    public function edit($id = null) {
        $roleDetail = $this->RoleDetails->get($id, [
            'contain' => ['Acos', 'Roles', 'Roles.RoleDetails']
        ]);
        return $this->setAction('form', $roleDetail);
    }

    /**
     * Form method
     *
     * @param Entity $roleDetail entity.
     */
    protected function form($roleDetail) {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleDetail = $this->RoleDetails->patchEntity($roleDetail, $this->request->getData());

            if (!$roleDetail->getErrors()) {
                $this->begin();
                try {
                    $this->RoleDetails->saveOrFail($roleDetail);

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

        $acos = $this->RoleDetails->Acos->find('threaded');
        $this->set(compact('roleDetail', 'acos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role Detail id.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleDetail = $this->RoleDetails->get($id, [
            'contain' => ['Acos', 'Roles', 'Roles.RoleDetails']
        ]);

        $this->begin();
        try {

            $this->RoleDetails->deleteOrFail($roleDetail);

            $this->commit();
        }catch(\Exception $e) {
            $this->rollback();
            throw $e;
        }

        $this->Flash->success(__('I-DELETE', __($this->name)));
        return $this->redirect(['action' => 'index']);
    }
}
