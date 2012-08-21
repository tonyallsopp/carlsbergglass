<?php
App::uses('AppModel', 'Model');
/**
 * ProductGroup Model
 *
 * @property Category $Category
 * @property ProductUnit $ProductUnit
 * @property CustomOption $CustomOption
 * @property ColourPrice $ColourPrice
 */
class ProductGroup extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'csv' => array(
            'uploaded' => array(
                'rule' => array('isUploadedFile'),
                'message' => 'Must be a file upload'
            ),
            'valid_file' => array(
                'rule' => array('isValidFile',array('max_size'=>10000,'ext'=>array('csv'))),
                'message' => 'File is too large or invalid file type'
            )
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ProductUnit' => array(
            'className' => 'ProductUnit',
            'foreignKey' => 'product_group_id',
            'dependent' => false,
        ),
        'CustomOption' => array(
            'className' => 'CustomOption',
            'foreignKey' => 'product_group_id',
            'dependent' => false,
        ),
        'ColourPrice' => array(
            'className' => 'ColourPrice',
            'foreignKey' => 'product_group_id',
            'dependent' => false,
        )
    );

    public $colours = array(1=>1, 2=>2, 3=>3, 4=>5, 5=>5, 6=>6);

    public function getVersions($productGroup){
        $res = array();
        foreach($productGroup['ProductUnit'] as $p){
            if(in_array($p['variant'], $res)) continue;
            $res[] = $p['variant'];
        }
        return $res;
    }

    public function getSizes($productGroup){
        $res = array();
        foreach($productGroup['ProductUnit'] as $p){
            if(in_array($p['capacity'], $res)) continue;
            $res[] = $p['capacity'];
        }
        return $res;
    }

    public function getCurrentUnit($prodGroup,$options){
        foreach($prodGroup['ProductUnit'] as $p){
            if($p['capacity'] == $options['size'] && $p['variant'] == $options['variant']){
                return $p;
            }
        }
        return array();
    }

    public function getBasePrice(array &$productGroups){
        foreach($productGroups as $k => $p){
            $productGroups[$k]['ProductGroup']['base_price'] = 999;
            foreach($p['ProductUnit'] as $unit){
                if($unit['price'] < $productGroups[$k]['ProductGroup']['base_price']){
                    $productGroups[$k]['ProductGroup']['base_price'] = $unit['price'];
                }
            }
        }
    }

    public function getCustomOptions(array &$productGroup){
        $opts = $this->CustomOption->find('all',array('conditions'=>array('product_group_id'=>$productGroup['ProductGroup']['id']),'recursive'=>-1));
        $groupOpts = array();
        $includedOptions = array();
        foreach($opts as $o){
            if(!in_array($o['CustomOption']['name'],$includedOptions )){
                $includedOptions[] = $o['CustomOption']['name'];
                $groupOpts[] = $o['CustomOption'];
            }
        }
        $productGroup['CustomOption'] = $groupOpts;
    }

    // IMPORT FUNCTIONS ==============

    public $importErrors = array();
    public $importMessages = array();
    public $saveErrors = array();

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

    private $optionCsvFields = array(
        array('name'=>'name', 'type'=>'str'),
        array('name'=>'supplier', 'type'=>'str'),
        array('name'=>'type', 'type'=>'str','value'=>array('colours','option')),
        array('name'=>'qty from', 'type'=>'int'),
        array('name'=>'qty to', 'type'=>'int'),
        array('name'=>'small 1 - 2 colours', 'type'=>'dec'),
        array('name'=>'small 3 - 4 colours', 'type'=>'dec'),
        array('name'=>'small 5 - 6 colours', 'type'=>'dec'),
        array('name'=>'large 1 - 2 colours', 'type'=>'dec'),
        array('name'=>'large 3 - 4 colours', 'type'=>'dec'),
        array('name'=>'large 5 - 6 colours', 'type'=>'dec'),
        array('name'=>'option name', 'type'=>'str'),
        array('name'=>'option small price', 'type'=>'dec'),
        array('name'=>'option large price', 'type'=>'dec'),
        array('name'=>'additional colour', 'type'=>'bool'),
        array('name'=>'option info', 'type'=>'str'),
        array('name'=>'multiplier', 'type'=>'str'),
    );

    public function importProductCSV($csvData, $parseOnly = false){
        $this->importErrors = array();
        $this->importMessages = array();
        $fields = $this->productCsvFields;
        $categories = array_flip($this->ProductGroup->Category->find('list'));
        $suppliers = array_flip($this->ProductGroup->ProductUnit->Supplier->find('list'));
        foreach($csvData as $lineNo => $line){
            $currentSection = 'branded'; //default to branded
            $currentCatId = 0;
            $currentGroupId = 0;
            $newUnit = array();
            //debug($line);
            foreach($line as $col =>$val){
                //debug($col . ' => ' . $val);
                if($val == $fields[$col]['name']){
                    //this line is column headers
                    $this->importMessages[] = "Column headers found on line {$lineNo}";
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

    public function importOptionCSV($csvData, $groupId, $parseOnly = false){
        $this->importErrors = array();
        $this->importMessages = array();
        //find the correct product group
        $group = $this->find('first', array('conditions' => array('ProductGroup.id'=>$groupId), 'recursive' => -1));
        if(empty($group)){
            $this->importErrors[] = 'Product group does not exist';
            if(!$parseOnly) return false;
        }
        $fields = $this->optionCsvFields;
        $suppliers = array_flip($this->ProductUnit->Supplier->find('list'));
        $supplierId = 0;
        $recordType = 'colours';
        $currentQty = 0;
        $lastSupplierId = 0;
        $newRecords = array('colours'=>array(),'option'=>array());
        foreach($csvData as $lineNo=>$line){
            //check for column headers
            if($line[0] == $fields[0]['name']){
                //this line is column headers
                $this->importMessages[] = "Column headers found on line {$lineNo}";
                continue;
            }
            //get record type
            if(!in_array($line[2],$fields[2]['value'])){
                $this->importErrors[] = "Incorrect record type: {$line[2]}";
                if(!$parseOnly) return false;
            }
            $recordType = $line[2];
            $record = array();
            //debug($line);
            foreach($line as $col =>$val){
                $val = trim($val);
                //check for 0 or empty
                if($col >= 0 && $col <= 2 && (!$val)){
                    $this->importErrors[] = "Zero or empty value for: {$fields[$col]['name']} line {$lineNo}";
                    if(!$parseOnly) return false;
                }
                //some fields are specific to colour pricing, others to options
                if($recordType == 'colours'){
                    if($col >= 5 && $col <= 10){
                        if(!is_numeric($val)){
                            $this->importErrors[] = "Incorrect data format for: {$fields[$col]['name']} line {$lineNo}";
                            if(!$parseOnly) return false;
                        }
                        //check for 0 or empty
                        if($val <= 0 || !$val){
                            $this->importErrors[] = "Zero or empty value for: {$fields[$col]['name']} line {$lineNo}";
                            if(!$parseOnly) return false;
                        }
                    } elseif($col >= 11){
                        continue;
                    }
                } elseif($recordType == 'option'){
                    if($col >= 3 && $col <= 10){
                        continue;
                    }
                }
                //debug($col . ' => ' . $val);
                switch($col){
                    case 0 : //name of group, must match id
                        if($group['ProductGroup']['name'] != $val){
                            $this->importErrors[] = 'Product name does not match';
                            if(!$parseOnly) return false;
                        }
                        $record['product_group_id'] = $groupId;
                        break;
                    case 1 : //supplier
                        if(!array_key_exists($val, $suppliers)){
                            //no supplier found
                            $this->importErrors[] = "Supplier: \"{$val}\" could not be found in database";
                            if(!$parseOnly) return false;
                        }
                        $supplierId = $suppliers[$val];
                        //reset the qty if weve changed supplier
                        if($lastSupplierId != $supplierId) $currentQty = 0;
                        $lastSupplierId = $supplierId;
                        $record['supplier_id'] = $supplierId;
                        break;
                    /*case 2 : //record type = option/colours
                        if(!in_array($val,$fields[$col]['value'])){
                            $this->importErrors[] = "Incorrect record type: $val";
                            return false;
                        }
                        $recordType = $val;
                        break;*/
                    case 3 : //qty from
                        if(!ctype_digit($val)){
                            $this->importErrors[] = "Incorrect field format for: \"{$fields[$col]['name']}\" line {$lineNo}";
                            if(!$parseOnly) return false;
                        }
                        if($val <= $currentQty){
                            $this->importErrors[] = "Value conflict for: \"{$fields[$col]['name']}\" line {$lineNo}";
                            if(!$parseOnly) return false;
                        }
                        $currentQty = $val;
                        $record['qty_from'] = $val;
                        break;
                    case 4 : //qty to
                        if(!ctype_digit($val)){
                            //not an integer
                            if(strlen($val) == 0){
                                //no value, use 99999999999
                                $val = 99999999999;
                            } else {
                                $this->importErrors[] = "Incorrect field format for: \"{$fields[$col]['name']}\" line {$lineNo}";
                                if(!$parseOnly) return false;
                            }
                        }
                        if($val <= $currentQty){
                            $this->importErrors[] = "Value conflict for: \"{$fields[$col]['name']}\" line {$lineNo}";
                            if(!$parseOnly) return false;
                        }
                        $currentQty = $val;
                        $record['qty_to'] = $val;
                        break;
                    case 5 : // small 1-2 colours
                        $record['small_1_2'] = $val;
                        break;
                    case 6 : // small 3-4 colours
                        $record['small_3_4'] = $val;
                        break;
                    case 7 : // small 5-6 colours
                        $record['small_5_6'] = $val;
                        break;
                    case 8 : // large 1-2 colours
                        $record['large_1_2'] = $val ? $val : $record['small_1_2'];
                        break;
                    case 9 : // large 3-4 colours
                        $record['large_3_4'] = $val ? $val : $record['small_3_4'];
                        break;
                    case 10 : // large 5-6 colours
                        $record['large_5_6'] = $val ? $val : $record['small_5_6'];
                        break;
                    case 11 : // option name
                        $record['name'] = $val;
                        break;
                    case 12 : // option small price
                        $record['small_price'] = $val ? $val : 0;
                        break;
                    case 13 : // option large price
                        $record['large_price'] = $val ? $val : $record['small_price'];
                        break;
                    case 14 : // counts as additional colour?
                        $record['is_colour'] = (strtolower($val) == 'yes' || $val === '1') ? 1 : 0;;
                        break;
                    case 15 : // option info
                        $record['info'] = $val;
                        break;
                    case 16 : // multiplier
                        $record['multiplier'] = $val;
                        break;
                }
            }
            $newRecords[$recordType][] = $record;
        }
        if(empty($this->importErrors) && !empty($newRecords)){
            $this->saveErrors = array();
            //first remove existing records for this product group
            $this->CustomOption->deleteAll(array('CustomOption.product_group_id'=>$groupId));
            $this->ColourPrice->deleteAll(array('ColourPrice.product_group_id'=>$groupId));
            //save the new records
            foreach($newRecords['colours'] as $c){
                $this->ColourPrice->create();
                if(!$this->ColourPrice->save(array('ColourPrice'=>$c))){
                    $this->saveErrors[] = 'Error saving colour pricing records';
                }
            }
            foreach($newRecords['option'] as $o){
                $this->CustomOption->create();
                if(!$this->CustomOption->save(array('CustomOption'=>$o))){
                    $this->saveErrors[] = 'Error saving custom options records';
                }
            }
        }
    }

}
