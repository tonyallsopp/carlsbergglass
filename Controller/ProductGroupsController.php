<?php
App::uses('AppController', 'Controller');
/**
 * ProductGroups Controller
 *
 * @property ProductGroup $ProductGroup
 */
class ProductGroupsController extends AppController {

    public function index($section = null){
        $section = !$section ? 'branded' : $section;
        $conditions = array('Category.section'=>$section);
        $contain = array('Category.name');
        $opts = array('ProductGroup'=>array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20));
        $this->paginate = $opts;
        $productGroups = $this->paginate('ProductGroup');
        debug($productGroups);
        $this->set('productGroups', $productGroups);
    }

    public function view($slug) {
        $contain = array('ProductUnit');
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

    public function admin_upload_csv() {
        if ($this->request->is('post')) {
            $this->ProductGroup->set($this->request->data);
            //validate
            if ($this->ProductGroup->validates()) {
                // it validated logic
                $uploaded = $this->uploadFile($this->request->data['ProductGroup']['csv']);
                if($uploaded){
                    $csvData = $this->parseCSVFile(TMP_FILES . $this->request->data['ProductGroup']['csv']['name']);
                    if(!empty($csvData)){
                        $report = $this->_importReport($this->request->data['ProductGroup']['csv']['name'], $csvData);
                    }
                } else {
                    $this->Session->setFlash('Error uploading file');
                }
            } else {
                debug($this->ProductGroup->invalidFields());
            }
        }
    }

    public function admin_import_csv($filename = null) {
        if($filename){
            if(file_exists(TMP_FILES . $filename)){
                $csvData = $this->parseCSVFile(TMP_FILES . $filename);
                //TODO add final validation check
                //import the file to DB
                $this->_importCSV($csvData);
            } else {
                $this->Session->setFlash('Cannot find specified file');
            }
        } else {
            $this->Session->setFlash('Invalid file name');
        }

    }

    private $productCsvFields = array(
        array('name'=>'category', 'type'=>'str','value'=>array('branded','unbranded')),
        array('name'=>'group', 'type'=>'str'),
        array('name'=>'description', 'type'=>'str'),
        array('name'=>'name', 'type'=>'str'),
        array('name'=>'capacity', 'type'=>'str'),
        array('name'=>'variant', 'type'=>'str'),
        array('name'=>'image', 'type'=>'str'),
        array('name'=>'technical drawing', 'type'=>'str'),
        array('name'=>'cutter guide', 'type'=>'str'),
        array('name'=>'origin', 'type'=>'str'),
        array('name'=>'primary packaging', 'type'=>'str'),
        array('name'=>'pallet unit', 'type'=>'str'),
        array('name'=>'trailer load', 'type'=>'str'),
        array('name'=>'hs code', 'type'=>'str'),
        array('name'=>'fca location', 'type'=>'str'),
        array('name'=>'price', 'type'=>'dec'),
        array('name'=>'supplier', 'type'=>'str'),
    );

    private function _importCSV($csvData){
        $fields = $this->productCsvFields;
        $categories = array_flip($this->ProductGroup->Category->find('list'));
        $suppliers = array_flip($this->ProductGroup->ProductUnit->Supplier->find('list'));
        foreach($csvData as $line){
            $currentSection = 'branded'; //default to branded
            $currentCatId = 0;
            $currentGroupId = 0;
            $newUnit = array();
            //debug($line);
            foreach($line as $col =>$val){
                //debug($col . ' => ' . $val);
                if($val == $fields[$col]['name']){
                    //this line is column headers
                    break;
                }
                $val = trim($val);
                switch($col){
                    case 0 : //section
                        if($val == 'unbranded'){
                            $currentSection = 'unbranded';
                        } else {
                            $currentSection = 'branded';
                        }
                        break;
                    case 1 : //category
                        if(!array_key_exists($val, $categories)){
                            //new category to add
                            $newCat = array('Category'=>array('name'=>$val,'section'=>$currentSection));
                            $this->ProductGroup->Category->create();
                            $this->ProductGroup->Category->save($newCat);
                            $categories[$val] = $this->ProductGroup->Category->id;
                        }
                        $currentCatId = $categories[$val];
                        break;
                    case 2 : //name = ProductGroup
                        //does the group exist?
                        $savedGroup = $this->ProductGroup->find('first', array('conditions' => array('category_id'=>$currentCatId, 'name'=>$val), 'recursive' => -1));
                        if(empty($savedGroup)){
                            //doesnt exist, create it
                            $this->ProductGroup->create();
                            $this->ProductGroup->save(array('ProductGroup'=>array('name'=>$val, 'category_id'=>$currentCatId)));
                            $currentGroupId = $this->ProductGroup->id;
                        } else {
                            $currentGroupId = $savedGroup['ProductGroup']['id'];
                        }
                        break;
                    case 3 : //description = ProductUnit
                        //check product doesnt exist
                        $savedProd = $this->ProductGroup->ProductUnit->find('first', array('conditions' => array('product_group_id'=>$currentGroupId, 'name'=>$val), 'recursive' => -1));
                        if(empty($savedProd)){
                            //doesnt exist
                            $newUnit = $this->ProductGroup->ProductUnit->create();
                            $newUnit['ProductUnit']['name'] = $val;
                            $newUnit['ProductUnit']['product_group_id'] = $currentGroupId;
                        }
                        break;
                    case 4 :
                        if(!empty($newUnit)){
                            $newUnit['ProductUnit']['capacity'] = $val;
                            $newUnit['ProductUnit']['capacity_group'] = $this->ProductGroup->ProductUnit->calcCapacityGroup($val);
                        }
                        break;
                    case 5 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['variant'] = $val;
                        break;
                    case 6 :
                        //if(!empty($newUnit)) $newUnit['ProductUnit']['variant'] = $val;
                        break;
                    case 7 :
                        //if(!empty($newUnit)) $newUnit['ProductUnit']['variant'] = $val;
                        break;
                    case 8 :
                        //if(!empty($newUnit)) $newUnit['ProductUnit']['variant'] = $val;
                        break;
                    case 9 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['origin'] = $val;
                        break;
                    case 10 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['packaging'] = $val;
                        break;
                    case 11 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['pallet_unit'] = $val;
                        break;
                    case 12 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['trailer_load'] = $val;
                        break;
                    case 13 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['hs_code'] = $val;
                        break;
                    case 14 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['fca_location'] = $val;
                        break;
                    case 15 :
                        if(!empty($newUnit)) $newUnit['ProductUnit']['price'] = $val;
                        break;
                    case 16 : // supplier
                        if(!array_key_exists($val, $suppliers)){
                            //new supplier to add
                            $newSupplier = array('Supplier'=>array('name'=>$val));
                            $this->ProductGroup->ProductUnit->Supplier->create();
                            $this->ProductGroup->ProductUnit->Supplier->save($newSupplier);
                            $suppliers[$val] = $this->ProductGroup->ProductUnit->Supplier->id;
                        }
                        if(!empty($newUnit)){
                            $newUnit['ProductUnit']['supplier_id'] = $suppliers[$val];
                            //last field to import, if we have a record to save, save it
                            $this->ProductGroup->ProductUnit->create();
                            $saved = $this->ProductGroup->ProductUnit->save($newUnit);
                            if(!$saved){
                                $this->Session->setFlash("Error saving new Product Unit '{$newUnit['ProductUnit']['name']}'");
                                debug($newUnit);
                                return false;
                            }
                        }
                        break;
                }
            }
        }
    }

    private function _importReport($fileName, $csvData){
        $fields = $this->productCsvFields;
        $res = array('filename'=>$fileName, 'errors'=>array(), 'messages'=>array());
        foreach($csvData as $line){
            foreach($line as $col =>$val){
                if($val == $fields[$col]['name']){
                    //this line is column headers
                    $res['messages'][] = 'Column headers detected on 1st line.';
                    break;
                }
            }
        }
        debug($res);
        debug($csvData);
        return $res;
    }
}
