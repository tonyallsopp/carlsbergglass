<?php
App::uses('AppController', 'Controller');
/**
 * OrderItemOptions Controller
 *
 * @property OrderItemOption $OrderItemOption
 */
class OrderItemOptionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OrderItemOption->recursive = 0;
		$this->set('orderItemOptions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->OrderItemOption->id = $id;
		if (!$this->OrderItemOption->exists()) {
			throw new NotFoundException(__('Invalid order item option'));
		}
		$this->set('orderItemOption', $this->OrderItemOption->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderItemOption->create();
			if ($this->OrderItemOption->save($this->request->data)) {
				$this->Session->setFlash(__('The order item option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item option could not be saved. Please, try again.'));
			}
		}
		$orderItems = $this->OrderItemOption->OrderItem->find('list');
		$this->set(compact('orderItems'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->OrderItemOption->id = $id;
		if (!$this->OrderItemOption->exists()) {
			throw new NotFoundException(__('Invalid order item option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderItemOption->save($this->request->data)) {
				$this->Session->setFlash(__('The order item option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item option could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->OrderItemOption->read(null, $id);
		}
		$orderItems = $this->OrderItemOption->OrderItem->find('list');
		$this->set(compact('orderItems'));
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
		$this->OrderItemOption->id = $id;
		if (!$this->OrderItemOption->exists()) {
			throw new NotFoundException(__('Invalid order item option'));
		}
		if ($this->OrderItemOption->delete()) {
			$this->Session->setFlash(__('Order item option deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Order item option was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
