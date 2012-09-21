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
        $this->set('login', true);
        $this->set('showNav', false);
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function contact(){
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->create();
            debug('post');
            debug($this->request->data);
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                //send email
                $this->sendEmail('contact_support',$this->_coonfigs['config_support_email'],$this->request->data);
            }
        } else {
            $this->request->data = $this->User->create();
        }
        $this->set('breadcrumbs', array('Contact Support'=>'/contact'));
    }

    public function register() {
        $this->layout = 'main';
        $adminEmail = 'paulcrouch@gmail.com';
        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['approved'] = 0;
            $this->request->data['User']['enabled'] = 0;
            if ($this->User->save($this->request->data)) {
                $this->request->data['User']['id'] = $this->User->id;
                //send email to admin
                if ($this->sendEmail('account_register', $adminEmail, array('user'=>$this->request->data['User']))) {

                }
                $this->redirect(array('action' => 'register_thanks'));
            } else {
                $this->Session->setFlash('There was a problem with your registration. Please try again.');
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
            unset($this->User->validate['email']['unique']);
            if ($this->User->validates()) {
                $user = $this->User->find('first', array('conditions' => array('User.email'=>$this->request->data['User']['email'],'User.enabled'=>1), 'recursive' => -1));
                if(empty($user)){
                    $this->User->validationErrors = array('email'=>array('Cannot find an account with this email address'));
                } else {
                    //customer account exists
                    $this->User->id = $user['User']['id'];
                    //generate new random password
                    $pass = $this->randomPassword();
                    if ($this->User->saveField('password', AuthComponent::password($pass))) {
                        $user['User']['new_password'] = $pass;
                        if ($this->sendEmail('new_password', $user['User']['email'],array('user'=>$user['User']))) {
                            $this->redirect(array('action' => 'password_sent'));
                        }
                    }
                }
            }
        }
        $this->set('admin', false);
    }

    public function password_sent() {
        $this->layout = 'main';
        $this->set('admin', false);
    }

    public function preview_email($template) {
        //$this->sendEmail($template, array('paulcrouch@gmail.com'));
        $this->render('/Emails/html/' . $template, '/Emails/html/default');
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
        $this->render('login','main');
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
        $this->set('breadcrumbs', array('Users'=>'/admin/users'));
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
        $this->set('roles', $this->User->roles);
        $this->set('breadcrumbs', array('Users'=>'/admin/users','New User'=>'/admin/users/admin'));
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
        $this->set('roles', $this->User->roles);
        $this->set('countries', $this->User->countries);
        $this->set('breadcrumbs', array('Users'=>'/admin/users','Edit User'=>"/admin/users/edit/{$id}"));
    }

    public function admin_approve($id){
        $this->User->id = $id;
        $user = $this->User->find('first', array('conditions' => array('User.id'=>$id,'User.approved'=>0), 'recursive' => -1));
        if(empty($user)){
            $this->Session->setFlash('Invalid user account');
        } else {
            //generate new random password
            $pass = $this->randomPassword();
            $user['User']['password'] = AuthComponent::password($pass);
            $user['User']['approved'] = 1;
            $user['User']['enabled'] = 1;
            if ($this->User->save($user)) {
                $user['User']['new_password'] = $pass;
                if ($this->sendEmail('new_password', $user['User']['email'],array('user'=>$user['User']))) {
                    $this->Session->setFlash(__('Account approved and activated. An email has been sent to the customer.'));
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
        $this->redirect($this->referer());
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
