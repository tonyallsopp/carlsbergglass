<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function account()
    {
        $this->User->id = $this->_user['id'];
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $this->User->id);
        }
        $this->set('admin', false);
        $this->set('countries', $this->User->countries);
    }

    /**
     * login method
     *
     * @return void
     */
    public function login()
    {
        $this->layout = 'main';
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Username and/or password is incorrect'), 'default', array(), 'auth');
            }
        }
        $this->set('showNav', false);
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function register() {
        $this->layout = 'main';
        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['approved'] = 0;
            $this->request->data['User']['enabled'] = 0;
            if ($this->User->save($this->request->data)) {
                $this->redirect(array('action' => 'register_thanks'));
            } else {
                $this->Session->setFlash('There was a problem with your registration. Please, try again.');
            }
        } else {
            $this->request->data = $this->User->create();
        }
        $this->set('countries', $this->User->countries);
        $this->set('admin', false);
    }

    public function register_thanks() {
        $this->layout = 'main';
        $this->set('admin', false);
    }

    public function forgot_password() {
        $this->layout = 'main';
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $email = $this->User->find('first', array('conditions' => array('User.email'=>$this->request->data['User']['email']), 'recursive' => -1));
                if(empty($email)){
                    $this->User->validationErrors = array('email'=>array('Cannot find an account with that email address'));
                } else {
                    //got a valid account, send email
                    //TODO: send email
                    $this->redirect(array('action' => 'password_sent'));
                }
            }
        }
        $this->set('admin', false);
    }

    public function password_sent() {
        $this->layout = 'main';
        $this->set('admin', false);
    }

    public function contact()
    {

    }

    /**
     * login method
     *
     * @return void
     */
    public function admin_login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
            }
        }
        $this->set('showNav', false);
    }

    /**
     * index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('userRoles', $this->User->userRoles);
        //$this->paginate = array('limit'=>1);
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->create();
        }
        $this->set('countries', $this->User->countries);
        $this->set('admin', true);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
        $this->set('admin', true);
        $this->set('countries', $this->User->countries);
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
