<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 */
class OrdersController extends AppController {

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function confirm($id = null)
    {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            $this->Session->setFlash(__('Invalid order'));
            $this->redirect($this->sessionReferer);
        }
        $contain = array('OrderItem'=>array('OrderItemOption','ProductUnit'=>'ProductGroup'),'User');
        $order = $this->Order->find('first', array('conditions' => array('Order.id'=>$id), 'contain' => $contain));
        if (empty($order)) {
            $this->Session->setFlash(__('Invalid order'));
            $this->redirect($this->sessionReferer);
        }
        //get the product group
        $contain = array('ProductUnit','Category','CustomOption');
        $product = $this->Order->OrderItem->ProductUnit->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$order['OrderItem'][0]['ProductUnit']['ProductGroup']['slug']), 'contain' => $contain));
        //get available sizes
        $productSizes = $this->Order->OrderItem->ProductUnit->ProductGroup->getSizes($product);
        debug($order);
        $this->set('productGroup', $product);
        $this->set('productSizes', $productSizes);
        $this->set('order', $order);
        $this->set('countries', $this->countries);
    }

    /**
     * index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->Order->recursive = 0;
        $this->set('orders', $this->paginate());
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
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        $this->set('order', $this->Order->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post')) {
            $this->Order->create();
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash(__('The order has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The order could not be saved. Please, try again.'));
            }
        }
        $users = $this->Order->User->find('list');
        $this->set(compact('users'));
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
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash(__('The order has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The order could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Order->read(null, $id);
        }
        $users = $this->Order->User->find('list');
        $this->set(compact('users'));
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
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->Order->delete()) {
            $this->Session->setFlash(__('Order deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Order was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
