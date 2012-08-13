<?php
App::uses('AppController', 'Controller');
/**
 * CmsElements Controller
 *
 * @property CmsElement $CmsElement
 */
class CmsElementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function get($name = null) {
        $elem = $this->CmsElement->find('first', array('conditions' => array('name'=>$name), 'recursive' => -1));
        debug($elem);
        if (empty($elem)) {
            throw new NotFoundException(__('Invalid cms element'));
        }
        return $elem;
	}

    /**
     * index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->CmsElement->recursive = 0;
        $this->paginate = array('order'=>'CmsElement.display_order ASC');
        $this->set('cmsElements', $this->paginate());
    }


/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CmsElement->create();
			if ($this->CmsElement->save($this->request->data)) {
				$this->Session->setFlash(__('The cms element has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cms element could not be saved. Please, try again.'));
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
	public function admin_edit($id = null) {
		$this->CmsElement->id = $id;
		if (!$this->CmsElement->exists()) {
			throw new NotFoundException(__('Invalid cms element'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CmsElement->save($this->request->data)) {
				$this->Session->setFlash(__('The cms element has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cms element could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CmsElement->read(null, $id);
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
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CmsElement->id = $id;
		if (!$this->CmsElement->exists()) {
			throw new NotFoundException(__('Invalid cms element'));
		}
		if ($this->CmsElement->delete()) {
			$this->Session->setFlash(__('Cms element deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cms element was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
