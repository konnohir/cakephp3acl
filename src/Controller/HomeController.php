<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Home Controller
 * ホーム
 */
class HomeController extends AppController
{
    /**
     * Index method
     */
    public function index() {
        
        // ログインしていなければログイン画面を表示する
        if (!$this->Auth->user()) {
            return $this->setAction('login');
        }

    }

    /**
     * Login method
     */
    protected function login() {
        
        if ($this->request->is('post')) {
            // ログイン処理
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('ユーザー名、またはパスワードが間違っています。'));
            }
        }

    }

    /**
     * Logout method
     */
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Profile method
     */
    public function profile() {
    }

    /**
     * Password change method
     */
    public function password() {
    }

}
