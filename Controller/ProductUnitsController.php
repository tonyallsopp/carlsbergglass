<?php
App::uses('AppController', 'Controller');
/**
 * ProductUnits Controller
 *
 * @property ProductUnit $ProductUnit
 */
class ProductUnitsController extends AppController {

    /**
     *  method
     *
     * @return void
     */
    /*public function admin_slugs() {
        $prods = $this->ProductUnit->find('all', array('recursive' => -1));
        foreach($prods as $i=>$p){
            $prods[$i]['ProductUnit']['slug'] = $this->ProductUnit->sluggify($p['ProductUnit']['name']);
        }
        debug($prods);
        $this->ProductUnit->saveMany($prods);
    }*/

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ProductUnit->recursive = 0;
		$this->set('productUnits', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->ProductUnit->id = $id;
		if (!$this->ProductUnit->exists()) {
			throw new NotFoundException(__('Invalid product unit'));
		}
		$this->set('productUnit', $this->ProductUnit->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ProductUnit->create();
			if ($this->ProductUnit->save($this->request->data)) {
				$this->Session->setFlash(__('The product unit has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product unit could not be saved. Please, try again.'));
			}
		}
		$images = $this->ProductUnit->Image->find('list');
		$suppliers = $this->ProductUnit->Supplier->find('list');
		$products = $this->ProductUnit->Product->find('list');
		$this->set(compact('images', 'suppliers', 'products'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->ProductUnit->id = $id;
		if (!$this->ProductUnit->exists()) {
			throw new NotFoundException(__('Invalid product unit'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ProductUnit->save($this->request->data)) {
				$this->Session->setFlash(__('The product unit has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product unit could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ProductUnit->read(null, $id);
		}
		$images = $this->ProductUnit->Image->find('list');
		$suppliers = $this->ProductUnit->Supplier->find('list');
		$products = $this->ProductUnit->Product->find('list');
		$this->set(compact('images', 'suppliers', 'products'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ProductUnit->id = $id;
		if (!$this->ProductUnit->exists()) {
			throw new NotFoundException(__('Invalid product unit'));
		}
		if ($this->ProductUnit->delete()) {
			$this->Session->setFlash(__('Product unit deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Product unit was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
