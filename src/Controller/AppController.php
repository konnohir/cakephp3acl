<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

/**
 * Application Controller
 *
 * @link https://book.cakephp.org/3.0/ja/controllers.html
 */
class AppController extends Controller {

    /**
     * 初期化処理
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();

        $this->loadComponent('Acl.Acl');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'name', 'password' => 'password']
                ],
            ],
            'authorize' => 'RoleBased',
            'loginAction' => [
                'controller' => 'home',
                'action' => 'index',
            ],
            'unauthorizedRedirect' => [
                'controller' => 'home',
                'action' => 'index',
            ],
            'checkAuthIn' => 'Controller.initialize',
        ]);

    }

    /**
     * レスポンスをJSON形式にする
     */
    protected function setResponseJson() {

        // ajax通信以外の場合エラーとする
        if (!$this->request->is('ajax') && !Configure::read('debug')) {
            $this->autoRender = false;
            return;
        }

        // JSON View を使用し、コントローラーでsetされたパラメータを出力する
        $this->viewBuilder()->className('json');
        $this->set('_serialize', true);

    }

    /**
     * トランザクション開始
     */
    protected function begin() {
        ConnectionManager::get('default')->begin();
    }

    /**
     * トランザクションコミット
     */
    protected function commit() {
        ConnectionManager::get('default')->commit();
    }
    
    /**
     * トランザクションロールバック
     */
    protected function rollback() {
        ConnectionManager::get('default')->rollback();
    }
}
