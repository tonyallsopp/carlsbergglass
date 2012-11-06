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
        $order = $this->Order->find('first', array('conditions' => array('Order.id'=>$id,'Order.user_id'=>$this->_user['id']), 'contain' => $contain));
        if (empty($order)) {
            $this->Session->setFlash(__('Invalid order'));
            $this->redirect($this->sessionReferer);
        }
        //get the product group
        $contain = array('ProductUnit','Category','CustomOption');
        $product = $this->Order->OrderItem->ProductUnit->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$order['OrderItem'][0]['ProductUnit']['ProductGroup']['slug']), 'contain' => $contain));
        //get available sizes
        $productSizes = $this->Order->OrderItem->ProductUnit->ProductGroup->getSizes($product);
        //debug($order);

        if($this->request->is('post') || $this->request->is('put') ){
            //save address and send emails
            debug($this->request->data);
            $this->request->data['Address']['order_id'] = $order['Order']['id'];
            if($this->Order->Address->save($this->request->data['Address'])){
                //upload any image file
                if(!empty($this->request->data['Order']['upload_file'])){
                    $uploadFile = $this->request->data['Order']['upload_file'];
                    $fileName = strtolower($uploadFile['name']);
                    $upload = $this->uploadFile($uploadFile,$fileName,CUST_LOGO_DIR);
                    if($upload['success']){
                        $this->Order->id = $order['Order']['id'];
                        $this->Order->saveField('image_file', $fileName);
                    }
                }
                //send mails
                if(Configure::read('debug') <1){
                    if ($this->sendEmail('order', $this->_configs['config_order_email'],array('user'=>$this->_user,'order'=>$order,'address'=>$this->request->data['Address']))) {
                        if ($this->sendEmail('order_thanks', $this->_user['email'],array('user'=>$this->_user,'order'=>$order,'address'=>$this->request->data['Address']))) {

                        }
                        $this->redirect(array('action'=>'thanks'));
                    } else {
                        $this->Session->setFlash('Error processing order');
                    }
                } else {
                    $this->redirect(array('action'=>'thanks'));
                }
            }
        }

        $this->set('productGroup', $product);
        $this->set('productSizes', $productSizes);
        $this->set('order', $order);
        $this->set('countries', $this->countries);
        //debug($product);
        //breadcrumbs
        if($product['Category']['section'] == 'branded'){
           //$bc = array('Glassware by Brand'=>'/branded_glassware/index',$product['Category']['name'] => $referrer, $product['ProductGroup']['name']=>"/branded_glassware/{$slug}");
            $bc = array();
        } else {
            $bc = array('Glassware Configurator'=>'/custom_glassware',$product['Category']['name'] => "/custom_glassware/{$product['Category']['slug']}", $order['OrderItem'][0]['ProductUnit']['ProductGroup']['name']=>"/custom_glassware/view/{$order['OrderItem'][0]['ProductUnit']['ProductGroup']['slug']}");
        }
        $bc['Your Order'] = "/order/confirm/{$id}";
        $this->set('breadcrumbs', $bc);
    }

    public function thanks(){

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
