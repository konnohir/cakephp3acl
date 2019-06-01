<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Users Controller
 * ユーザーマスタ
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $users = $this->paginate($this->Users, [
            'contain' => ['Roles']
        ]);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     */
    public function add() {
        $user = $this->Users->newEntity();
        $this->setAction('form', $user);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id);
        $this->setAction('form', $user);
    }

    /**
     * Form method
     */
    protected function form($user) {

        if ($this->request->is(['post', 'put', 'patch'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($user->isNew()) {
                $user->passsword ='pass#12345';
            }
            if ($this->Users->save($user)) {
                $this->Flash->success(__('I-SAVE', __($this->name)));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('E-SAVE', __($this->name)));
        }
        $roles = $this->Users->Roles->find('list');
        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('I-DELETE', __($this->name)));
        } else {
            $this->Flash->error(__('E-DELETE', __($this->name)));
        }

        return $this->redirect(['action' => 'index']);
    }

}
