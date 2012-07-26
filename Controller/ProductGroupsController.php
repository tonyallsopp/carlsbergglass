<?php
App::uses('AppController', 'Controller');
/**
 * ProductGroups Controller
 *
 * @property ProductGroup $ProductGroup
 */
class ProductGroupsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ProductGroup->recursive = 0;
		$this->set('productGroups', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ProductGroup->id = $id;
		if (!$this->ProductGroup->exists()) {
			throw new NotFoundException(__('Invalid product group'));
		}
		$this->set('productGroup', $this->ProductGroup->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProductGroup->create();
			if ($this->ProductGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The product group has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product group could not be saved. Please, try again.'));
			}
		}
		$categories = $this->ProductGroup->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ProductGroup->id = $id;
		if (!$this->ProductGroup->exists()) {
			throw new NotFoundException(__('Invalid product group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ProductGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The product group has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product group could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ProductGroup->read(null, $id);
		}
		$categories = $this->ProductGroup->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ProductGroup->id = $id;
		if (!$this->ProductGroup->exists()) {
			throw new NotFoundException(__('Invalid product group'));
		}
		if ($this->ProductGroup->delete()) {
			$this->Session->setFlash(__('Product group deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Product group was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
