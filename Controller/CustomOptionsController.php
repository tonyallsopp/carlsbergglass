<?php
App::uses('AppController', 'Controller');
/**
 * CustomOptions Controller
 *
 * @property CustomOption $CustomOption
 */
class CustomOptionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CustomOption->recursive = 0;
		$this->set('customOptions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CustomOption->id = $id;
		if (!$this->CustomOption->exists()) {
			throw new NotFoundException(__('Invalid custom option'));
		}
		$this->set('customOption', $this->CustomOption->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CustomOption->create();
			if ($this->CustomOption->save($this->request->data)) {
				$this->Session->setFlash(__('The custom option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The custom option could not be saved. Please, try again.'));
			}
		}
		$suppliers = $this->CustomOption->Supplier->find('list');
		$productGroups = $this->CustomOption->ProductGroup->find('list');
		$this->set(compact('suppliers', 'productGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CustomOption->id = $id;
		if (!$this->CustomOption->exists()) {
			throw new NotFoundException(__('Invalid custom option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CustomOption->save($this->request->data)) {
				$this->Session->setFlash(__('The custom option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The custom option could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CustomOption->read(null, $id);
		}
		$suppliers = $this->CustomOption->Supplier->find('list');
		$productGroups = $this->CustomOption->ProductGroup->find('list');
		$this->set(compact('suppliers', 'productGroups'));
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
		$this->CustomOption->id = $id;
		if (!$this->CustomOption->exists()) {
			throw new NotFoundException(__('Invalid custom option'));
		}
		if ($this->CustomOption->delete()) {
			$this->Session->setFlash(__('Custom option deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Custom option was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
