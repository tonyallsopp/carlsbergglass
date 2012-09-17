<?php
App::uses('AppController', 'Controller');
/**
 * ProductGroups Controller
 *
 * @property ProductGroup $ProductGroup
 */
class ProductGroupsController extends AppController {


    public function index($brand = null){
        $section = 'branded';
        $conditions = array('Category.section'=>$section);
        if($brand){
            $conditions['Category.slug'] = $brand;
        }
        $contain = array('Category.name','ProductUnit.price');
        $opts = array('ProductGroup'=>array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20));
        $this->paginate = $opts;
        $productGroups = $this->paginate('ProductGroup');
        //debug($productGroups);
        $this->ProductGroup->getBasePrice($productGroups);
        $this->set('listings', $productGroups);
        $this->set('currentBrand', $brand ? $productGroups[0]['Category']['name'] : 'All brands');

        $this->set('title_for_layout', 'Branded Glassware');
    }

    public function custom_index($subcat = null){
        $section = 'unbranded';
        $conditions = array('Category.section'=>$section);
        if($subcat){
            $conditions['Category.slug'] = $subcat;
        }
        $contain = array('Category.name','ProductUnit.price');
        $opts = array('ProductGroup'=>array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20));
        $this->paginate = $opts;
        $productGroups = $this->paginate('ProductGroup');
        $this->ProductGroup->getBasePrice($productGroups);
        $this->set('listings', $productGroups);
        $this->set('subCategory', $subcat ? $productGroups[0]['Category']['name'] : 'All');
        $this->set('title_for_layout', 'Unbranded Glassware');
    }

    public function view($slug) {
        $contain = array('ProductUnit','Category');
        $product = $this->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$slug), 'contain' => $contain));
        if(empty($product)){
            $this->Session->setFlash('Could not find product');
            $this->redirect($this->referer());
        }
        // particular params selected?
        $productSizes = $this->ProductGroup->getSizes($product);
        $productVersions = $this->ProductGroup->getVersions($product);
        $selectedVariant = isset($this->request->named['vers']) ? $this->request->named['vers']*1 : 0;
        $selectedSize = isset($this->request->named['size']) ? $this->request->named['size']*1 : 0;
        $currentProdUnit = $this->ProductGroup->getCurrentUnit($product,array('variant'=>$productVersions[$selectedVariant],'size'=>$productSizes[$selectedSize] ));
        //debug($product);
        $this->set('currentUnit', $currentProdUnit);
        $this->set('selectedSize', $selectedSize);
        $this->set('selectedVersion', $selectedVariant);
        $this->set('productSizes', $productSizes);
        $this->set('productVersions', $productVersions);
        $this->set('productGroup', $product);
        $referrer = $this->sessionReferer == '/' ? '/branded_glassware/index' : $this->sessionReferer;
        $this->set('referrer', $this->sessionReferer);
        $this->set('custom',false);
        $this->set('title_for_layout', $product['ProductGroup']['name']);

    }

    public function view_custom($slug) {
        $contain = array('ProductUnit','Category','CustomOption');
        $product = $this->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$slug), 'contain' => $contain));
        //debug($product);
        if(empty($product)){
            $this->Session->setFlash('Could not find product');
            $this->redirect($this->referer());
        }
        //get available custom options for this product group
        $this->ProductGroup->getCustomOptions($product);
        //get available sizes
        $productSizes = $this->ProductGroup->getSizes($product);
        //get the product unit from the selected size
        $selectedSize = isset($this->request->data['ProductGroup']['size']) ? $this->request->data['ProductGroup']['size']*1 : 0;
        $currentProdUnit = $this->ProductGroup->getCurrentCustomUnit($product,array('size'=>$productSizes[$selectedSize] ));
        $estimatePrice = $currentProdUnit['price'];
        // calc price etc based on inputs
        if ($this->request->is('post')) {
            debug($this->request->data);
            //create an order
            $order = $this->ProductGroup->ProductUnit->OrderItem->Order->initQuote($this->_user, $this->request->data, $currentProdUnit, $product);
            //save the order
            $saved = $this->ProductGroup->ProductUnit->OrderItem->Order->saveAll($order,array('deep'=>true));
            //get the price
            $estimatePrice = $order['OrderItem'][0]['unit_price'];
            if($saved){
                $orderId = $this->ProductGroup->ProductUnit->OrderItem->Order->id;
                $this->redirect('/orders/confirm/' . $orderId);
            }
        }
        $this->set('estimatePrice', $estimatePrice);
        $this->set('currentUnit', $currentProdUnit);
        $this->set('selectedSize', $selectedSize);
        $this->set('productSizes', $productSizes);
        $this->set('colours', $this->ProductGroup->colours);
        $this->set('productGroup', $product);
        $referrer =  '/branded_glassware/' . $product['Category']['slug'];
        $this->set('referrer', $this->sessionReferer);
        $this->set('title_for_layout', $product['ProductGroup']['name']);
        $this->set('custom',true);
        $this->render('view');
    }

    public function update_custom_price(){
        // ajax update
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            Configure::write('debug', 0);
            $contain = array('ProductUnit','Category','CustomOption');
            $product = $this->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$this->request->data['ProductGroup']['slug']), 'contain' => $contain));
            //get available sizes
            $productSizes = $this->ProductGroup->getSizes($product);
            //get the product unit from the selected size
            $selectedSize = isset($this->request->data['ProductGroup']['size']) ? $this->request->data['ProductGroup']['size']*1 : 0;
            $currentProdUnit = $this->ProductGroup->getCurrentCustomUnit($product,array('size'=>$productSizes[$selectedSize] ));
            //create an order
            $order = $this->ProductGroup->ProductUnit->OrderItem->Order->initQuote($this->_user, $this->request->data, $currentProdUnit, $product);
            //save the order
            $saved = $this->ProductGroup->ProductUnit->OrderItem->Order->saveAll($order,array('deep'=>true));
            if($saved){
                $orderId = $this->ProductGroup->ProductUnit->OrderItem->Order->id;
                $order['Order']['id'] = $orderId;
            }
            //insert the selected product unit
            unset($currentProdUnit['ColourPrice'], $currentProdUnit['CustomOption']);
            $order['ProductUnit'] = $currentProdUnit;
            //ajax response
            $this->set('response',json_encode($order));
            $this->render('/Elements/ajax','ajax');
        }
    }

    public function change_options($slug){
        if (!empty($this->request->data)) {
            $vers = $this->request->data['ProductGroup']['version'];
            $size = $this->request->data['ProductGroup']['size'];
            if($this->request->is('ajax')){
                $contain = array('ProductUnit');
                $product = $this->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$slug), 'contain' => $contain));
                $productSizes = $this->ProductGroup->getSizes($product);
                $productVersions = $this->ProductGroup->getVersions($product);
                $currentProdUnit = $this->ProductGroup->getCurrentUnit($product,array('variant'=>$productVersions[$vers],'size'=>$productSizes[$size] ));
                $this->set('response',json_encode($currentProdUnit));
                $this->render('/Elements/ajax','ajax');
            } else {
                $this->redirect("/branded_glassware/{$slug}/vers:{$vers}/size:{$size}");
            }
        }

    }


    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {
        $groups = $this->ProductGroup->find('all', array('conditions' => array('Category.section'=>'unbranded'), 'order'=>'ProductGroup.name ASC'));
        debug($groups);
        $this->set('groups',$groups);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
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
    public function admin_add() {
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
    public function admin_edit($id = null) {
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
    public function admin_delete($id = null) {
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



    public function admin_upload_csv($sheetType = 'product', $groupId = null) {
        $sheetType = $sheetType == 'product' ? 'product' : 'options';
        $importFileName = null;
        if ($this->request->is('post')) {
            $importFileName = $this->request->data['ProductGroup']['csv']['name'];
            $this->ProductGroup->set($this->request->data);
            if($sheetType == 'options' && !$groupId){
                //if options sheet, a group id must be given
                $this->Session->setFlash('Error uploading file, invalid product group');
            } else {
                //validate
                if ($this->ProductGroup->validates()) {
                    // it validated logic
                    $uploaded = $this->uploadFile($this->request->data['ProductGroup']['csv']);
                    if($uploaded){
                        $csvData = $this->parseCSVFile(TMP_FILES . $this->request->data['ProductGroup']['csv']['name']);
                        if($sheetType == 'product'){
                            $this->ProductGroup->importProductCSV($csvData, true);
                        } else {
                            $this->ProductGroup->importOptionCSV($csvData, $groupId, true);
                        }
                    } else {
                        $this->Session->setFlash('Error uploading file');
                    }
                } else {
                    debug($this->ProductGroup->invalidFields());
                }
            }
        }
        if($sheetType == 'options'){
            $group = $this->ProductGroup->find('first', array('conditions' => array('ProductGroup.id'=>$groupId), 'recursive' => -1));
            $this->set('group', $group);
        }
        $this->set('importErrors',$this->ProductGroup->importErrors);
        $this->set('importMessages',$this->ProductGroup->importMessages);
        $this->set('sheetType', ucfirst($sheetType));
        $this->set('groupId', $groupId);
        $this->set('filename', $importFileName);
    }

    public function admin_import_csv($type, $filename = null, $groupId = null) {
        $type = $type == 'product' ? 'product' : 'options';
        if($filename){
            if(file_exists(TMP_FILES . $filename)){
                $csvData = $this->parseCSVFile(TMP_FILES . $filename);
                //import the file to DB
                if($type == 'product'){
                    $this->ProductGroup->importProductCSV($csvData);
                } elseif($type == 'options' && $groupId) {
                    $this->ProductGroup->importOptionCSV($csvData, $groupId);
                } else {
                    $this->Session->setFlash('Cannot find specified file, parameters missing');
                }
                if(empty($this->ProductGroup->importErrors) && empty($this->ProductGroup->saveErrors)){
                    //create an import record
                }
            } else {
                $this->Session->setFlash('Cannot find specified file');
            }
        } else {
            $this->Session->setFlash('Invalid file name');
        }
        //$this->redirect($this->referer());
    }

}
