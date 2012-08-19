<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Category->recursive = 0;
        $this->set('categories', $this->paginate());
    }

    public function brands()
    {
        $conditions = array('Category.section' => 'branded');
        $contain = array('ProductGroup');
        $opts = array('Category' => array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20, 'order' => 'Category.name ASC'));
        $this->paginate = $opts;
        $categories = $this->paginate('Category');
        debug($categories);
        $this->set('listings', $categories);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->set('category', $this->Category->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Category->read(null, $id);
        }
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('Category deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
