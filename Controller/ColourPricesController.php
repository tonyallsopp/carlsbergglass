<?php
App::uses('AppController', 'Controller');
/**
 * ColourPrices Controller
 *
 * @property ColourPrice $ColourPrice
 */
class ColourPricesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ColourPrice->recursive = 0;
		$this->set('colourPrices', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ColourPrice->id = $id;
		if (!$this->ColourPrice->exists()) {
			throw new NotFoundException(__('Invalid colour price'));
		}
		$this->set('colourPrice', $this->ColourPrice->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ColourPrice->create();
			if ($this->ColourPrice->save($this->request->data)) {
				$this->Session->setFlash(__('The colour price has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The colour price could not be saved. Please, try again.'));
			}
		}
		$suppliers = $this->ColourPrice->Supplier->find('list');
		$productGroups = $this->ColourPrice->ProductGroup->find('list');
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
		$this->ColourPrice->id = $id;
		if (!$this->ColourPrice->exists()) {
			throw new NotFoundException(__('Invalid colour price'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ColourPrice->save($this->request->data)) {
				$this->Session->setFlash(__('The colour price has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The colour price could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ColourPrice->read(null, $id);
		}
		$suppliers = $this->ColourPrice->Supplier->find('list');
		$productGroups = $this->ColourPrice->ProductGroup->find('list');
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
		$this->ColourPrice->id = $id;
		if (!$this->ColourPrice->exists()) {
			throw new NotFoundException(__('Invalid colour price'));
		}
		if ($this->ColourPrice->delete()) {
			$this->Session->setFlash(__('Colour price deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Colour price was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
