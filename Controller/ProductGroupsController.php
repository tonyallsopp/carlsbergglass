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
        $currentBrand = $brand ? $productGroups[0]['Category']['name'] : 'All brands';
        $this->set('currentBrand', $currentBrand);
        $this->set('title_for_layout', 'Branded Glassware');
        $this->set('breadcrumbs', array('Glassware by Brand'=>'/custom_glassware',$currentBrand => "/branded_glassware/index/{$brand}"));
    }

    public function custom_index($subcat = null){
        $section = 'unbranded';
        $conditions = array('Category.section'=>$section);
        if($subcat){
            $conditions['Category.slug'] = $subcat;
        }
        $contain = array('Category.name','ProductUnit'=>array('fields'=>array('ProductUnit.price')));
        $opts = array('ProductGroup'=>array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20));
        $this->paginate = $opts;
        $productGroups = $this->paginate('ProductGroup');
        //debug($productGroups);
        $this->ProductGroup->getBasePrice($productGroups);
        $this->set('listings', $productGroups);
        $subCategory = $subcat ? $productGroups[0]['Category']['name'] : 'All';
        $this->set('subCategory', $subCategory);
        $this->set('title_for_layout', 'Custom Glassware');
        $this->set('breadcrumbs', array('Glassware Configurator'=>'/custom_glassware',$subCategory => "/custom_glassware/{$subcat}"));
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
        $this->set('breadcrumbs', array('Glassware by Brand'=>'/branded_glassware/index',$product['Category']['name'] => $referrer, $product['ProductGroup']['name']=>"/branded_glassware/{$slug}"));

    }

    public function view_custom($slug) {
        $contain = array('ProductUnit','Category','CustomOption');
        $product = $this->ProductGroup->find('first', array('conditions' => array('ProductGroup.slug'=>$slug), 'contain' => $contain));
        //debug($product);
        if(empty($product)){
            $this->Session->setFlash('Could not find product');
            $this->redirect($this->referer());
        }
        //debug($product);
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
            //debug($this->request->data);
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
        $referrer =  '/custom_glassware/' . $product['Category']['slug'];
        $this->set('referrer', $this->sessionReferer);
        $this->set('title_for_layout', $product['ProductGroup']['name']);
        $this->set('custom',true);
        $this->set('breadcrumbs', array('Glassware Configurator'=>'/custom_glassware',$product['Category']['name'] => $referrer, $product['ProductGroup']['name']=>"/custom_glassware/view/{$slug}"));
        $this->render('view');
    }

    public function update_custom_price(){
        // ajax update
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            Configure::write('debug', 0);
            $contain = array('ProductUnit','Category','CustomOption','ColourPrice');
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
        //debug($groups);
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



    public function admin_upload_csv($sheetType = 'product') {
        $sheetType = $sheetType == 'product' ? 'product' : 'options';
        $importFileName = null;
        $replaceAll = false;
        if ($this->request->is('post')) {
            $importFileName = $this->request->data['ProductGroup']['csv']['name'];
            $this->ProductGroup->set($this->request->data);
            //debug($this->request->data);
            //validate
            if ($this->ProductGroup->validates()) {
                // it validated logic
                $uploaded = $this->uploadFile($this->request->data['ProductGroup']['csv']);
                if($uploaded){
                    $csvData = $this->parseCSVFile(TMP_FILES . $this->request->data['ProductGroup']['csv']['name']);
                    //debug($csvData);
                    if(!empty($csvData)){
                        if($sheetType == 'product'){
                            $this->ProductGroup->importProductCSV($csvData, true);
                        } else {
                            $replaceAll = $this->request->data['ProductGroup']['replace'];
                            $this->ProductGroup->importOptionCSV($csvData, true, $replaceAll);
                        }
                    } else {
                        $this->Session->setFlash('No data found in CSV file: ' . $this->request->data['ProductGroup']['csv']['name']);
                        unlink(TMP_FILES . $this->request->data['ProductGroup']['csv']['name']);
                        //$this->redirect($this->referer());
                    }
                } else {
                    $this->Session->setFlash('Error uploading file: ' . $this->request->data['ProductGroup']['csv']['name']);
                    $this->redirect($this->referer());
                }
            } else {
                unlink(TMP_FILES . $this->request->data['ProductGroup']['csv']['name']);
                debug($this->ProductGroup->invalidFields());
            }
        }
        $this->set('importErrors',$this->ProductGroup->importErrors);
        $this->set('importMessages',$this->ProductGroup->importMessages);
        $this->set('sheetType', ucfirst($sheetType));
        $this->set('filename', $importFileName);
        $this->set('replaceAll', $replaceAll);
    }

    public function admin_import_csv($type, $filename = null, $replaceAll = false) {
        $type = strtolower($type) == 'product' ? 'product' : 'options';
        $imported = false;
        if($filename){
            if(file_exists(TMP_FILES . $filename)){
                $csvData = $this->parseCSVFile(TMP_FILES . $filename);
                //import the file to DB
                if($type == 'product'){
                    $imported = $this->ProductGroup->importProductCSV($csvData);
                } elseif($type == 'options') {
                    $imported = $this->ProductGroup->importOptionCSV($csvData, false, $replaceAll);
                } else {
                    $this->Session->setFlash('Cannot find specified file, parameters missing');
                }
                if($imported || !empty($this->ProductGroup->importErrors) || !empty($this->ProductGroup->saveErrors)){
                    debug($this->ProductGroup->saveErrors);
                    debug($this->ProductGroup->importErrors);
                }
            } else {
                $this->Session->setFlash('Cannot find specified file');
            }
        } else {
            $this->Session->setFlash('Invalid file name');
        }
        if($imported){
            $this->Session->setFlash("{$filename} imported successfully");
        } else {
            $this->Session->setFlash("Error importing {$filename}: " . explode(' ,',$this->ProductGroup->saveErrors) . "\n" .  explode(' ,',$this->ProductGroup->importErrors));
        }
        unlink(TMP_FILES . $filename);
        $this->redirect('/admin/product_groups');
    }

}
