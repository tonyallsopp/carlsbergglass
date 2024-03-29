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
            ),
        ),
        'csv' => array(
            'uploaded' => array(
                'rule' => array('isUploadedFile'),
                'message' => 'Must be a file upload'
            ),
            'csv_file' => array(
                'rule' => array('isCsvFile'),
                'message' => 'Must be a CSV file'
            )
        )
    );

    public function isCsvFile($inputData) {
        $file = array_values($inputData);
        $file = $file[0];
        if(!isset($file['size'])) return false;
        $validType = $file['type'] == 'text/csv' || $file['type'] == 'text/comma-separated-values' || $file['type'] == 'application/vnd.ms-excel';
        return ( stripos($file['name'], '.csv') !== false && $validType );
    }

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

    public $colours = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6);

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if(isset($this->data['ProductGroup']['name']) && $this->data['ProductGroup']['name']){
            $this->data['ProductGroup']['slug'] = $this->sluggify($this->data['ProductGroup']['name']);
        }
        return true;
    }

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

    public function getCurrentCustomUnit($prodGroup,$options){
        foreach($prodGroup['ProductUnit'] as $p){
            if($p['capacity'] == $options['size']){
                //get the custom options for this product
                $options = $this->CustomOption->find('all',array('conditions'=>array('CustomOption.product_group_id'=>$p['product_group_id'], 'CustomOption.supplier_id'=>$p['supplier_id']), 'recursive'=>-1));
                $p['CustomOption'] = $options;
                //get the colour/price index for this product
                $colours = $this->ColourPrice->find('all',array('conditions'=>array('ColourPrice.product_group_id'=>$p['product_group_id'], 'ColourPrice.supplier_id'=>$p['supplier_id']), 'recursive'=>-1));
                $p['ColourPrice'] = $colours;
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
        array('name'=>'name','field'=>'name', 'type'=>'str'),
        array('name'=>'capacity','field'=>'capacity', 'type'=>'str'),
        array('name'=>'variant','field'=>'variant', 'type'=>'str'),
        array('name'=>'image','field'=>'image_file', 'type'=>'str','default'=>''),
        array('name'=>'technical drawing','field'=>'drawing_file', 'type'=>'str','default'=>''),
        array('name'=>'cutter guide','field'=>'cutter_guide_file', 'type'=>'str','default'=>''),
        array('name'=>'origin','field'=>'origin', 'type'=>'str','default'=>''),
        array('name'=>'primary packaging','field'=>'packaging', 'type'=>'str','default'=>''),
        array('name'=>'pallet unit','field'=>'pallet_unit', 'type'=>'int','default'=>0),
        array('name'=>'trailer load','field'=>'trailer_load', 'type'=>'int','default'=>0),
        array('name'=>'hs code','field'=>'hs_code', 'type'=>'str','default'=>''),
        array('name'=>'fca location','field'=>'fca_location', 'type'=>'str','default'=>''),
        array('name'=>'price','field'=>'price', 'type'=>'dec'),
        array('name'=>'supplier', 'type'=>'str'),
        array('name'=>'description','field'=>'description', 'type'=>'str','default'=>''),
        array('name'=>'classification','field'=>'classification', 'type'=>'str','default'=>''),
        array('name'=>'height','field'=>'height', 'type'=>'dec'),
        array('name'=>'diameter max','field'=>'diameter_max', 'type'=>'dec'),
        array('name'=>'diameter rim','field'=>'diameter_rim', 'type'=>'dec'),
        array('name'=>'misc 1 label','field'=>'misc_1_label', 'type'=>'str','default'=>''),
        array('name'=>'misc 1 value','field'=>'misc_1_value', 'type'=>'str','default'=>''),
        array('name'=>'misc 2 label','field'=>'misc_2_label', 'type'=>'str','default'=>''),
        array('name'=>'misc 2 value','field'=>'misc_2_value', 'type'=>'str','default'=>''),
        array('name'=>'misc 3 label','field'=>'misc_3_label', 'type'=>'str','default'=>''),
        array('name'=>'misc 3 value','field'=>'misc_3_value', 'type'=>'str','default'=>''),
    );

    public function importProductCSV($csvData, $parseOnly = false){
        //debug($csvData);
        //load the Media mdel for use later
        App::uses('Media', 'Model');
        $media = new Media();
        $this->importErrors = array();
        $this->importMessages = array();
        $fields = $this->productCsvFields;
        // if we are importing the data (NOT parsing only), delete current records
        if(!$parseOnly){
            // del product groups
            $this->deleteAll(array('ProductGroup.id >'=>0));
            // del categories
            $this->Category->deleteAll(array('Category.id >'=>0));
            // del product units
            $this->ProductUnit->deleteAll(array('ProductUnit.id >'=>0));
            // del suppliers
            $this->ProductUnit->Supplier->deleteAll(array('Supplier.id >'=>0));
        }

        $categories = array_flip($this->Category->find('list'));
        $suppliers = array_flip($this->ProductUnit->Supplier->find('list',array('fields'=>array('id','slug'))));

        foreach($csvData as $lineNo => $line){
            $currentSection = 'branded'; //default to branded
            $currentCatId = 0;
            $unit = array();
            $newUnit = array();
            $newGroup = array();
            $headers = false;
            $currentGroupName = '';
            $currentGroupSlug = '';
            $currentSupplierId = 0;
            $columnCount = count($line);
            $lastColumn = $columnCount -1;
            if($lastColumn < 14){
                $this->importErrors[] = "Incorrect number of columns found on line {$lineNo} - found {$columnCount} columns";
            }

            //debug($line);
            foreach($line as $col =>$val){
                $val = trim($val);
                if($lineNo == 0 && $val == $fields[$col]['name']){
                    //this line is column headers
                    if(!$headers){
                        $this->importMessages[] = "Column headers found on line {$lineNo}";
                        $headers = true;
                    }
                    break;
                } else { // some basic validation
                    //does the field have a default value if empty
                    if(isset($fields[$col]['default']) && empty($val)){
                        $val = $fields[$col]['default'];
                    }

                    if(isset($fields[$col]['value']) && !in_array($val,$fields[$col]['value'])){
                        $this->importErrors[] = "Invalid value - line {$lineNo}, column {$col} - expecting: " . explode(' | ', $fields[$col]['value']) . " found: {$val}";
                    }
                    if($val && isset($fields[$col]['type']) && $fields[$col]['type'] == 'int' && !ctype_digit($val)){
                        $this->importErrors[] = "Invalid value - line {$lineNo}, column {$col} - expected an integer (whole number) - found \"{$val}\"";
                    }
                    if($val && isset($fields[$col]['type']) && $fields[$col]['type'] == 'dec' && !is_numeric($val)){
                        $this->importErrors[] = "Invalid value - line {$lineNo}, column {$col} - expected a number (decimal) - found \"{$val}\"";
                    }
                }
                if(!empty($this->importErrors)) return false;

                if($col === 0){ //section
                    if($val == 'unbranded'){
                        $currentSection = 'unbranded';
                    } else {
                        $currentSection = 'branded';
                    }
                } elseif($col === 1){ //category
                    //does the cat exist
                    if(array_key_exists($val, $categories)){
                        $msg = "Category record: {$val} will be replaced";
                        $currentCatId = $categories[$val];
                    } else {
                        $msg = "New product category record: {$val}";
                        if(!$parseOnly){
                            //new category to add
                            $this->Category->create();
                            $newCat = array('Category'=>array('name'=>$val,'section'=>$currentSection));
                            $this->Category->save($newCat);
                            $categories[$val] = $this->Category->id;
                        } else {
                            $categories[$val] = 0;
                        }
                        $currentCatId = $categories[$val];
                    }
                    if(!in_array($msg,$this->importMessages )){
                        $this->importMessages[] = $msg;
                    }

                } elseif($col === 2){ //name = ProductGroup
                    $currentGroupName = $val;
                    //does the group exist?
                    $savedGroup = $this->find('first', array('conditions' => array('ProductGroup.slug'=>$this->sluggify($val)), 'recursive' => -1));
                    if(empty($savedGroup)){
                        //doesnt exist, create it
                        $newGroup = array('name'=>$val, 'category_id'=>$currentCatId);
                        $currentGroupSlug = $this->sluggify($val);
                    } else {
                        $currentGroupSlug = $savedGroup['ProductGroup']['slug'];
                    }
                    $msg = "New product group record: {$val}";
                    if(!in_array($msg,$this->importMessages )){
                        $this->importMessages[] = $msg;
                    }
                } elseif($col === 3){ //capacity
                    $unit['capacity'] = $val;
                    $unit['capacity_group'] = $this->ProductUnit->calcCapacityGroup($val);
                } elseif($col === 4){ //variant
                    if(!empty($unit)) $unit['variant'] = $val;
                    //the ProductUnit name is made from name + capacity + variant
                    $unit['name'] = $currentGroupName . ' ' . $unit['capacity'];
                    if($val){
                        $unit['name'] .= ' - ' . $val;
                    }

                    //check product doesnt exist
                    $savedProd = $this->ProductUnit->find('first', array('conditions' => array('ProductUnit.product_group_slug'=>$currentGroupSlug, 'ProductUnit.name'=>$unit['name']), 'recursive' => -1));
                    if(empty($savedProd)){
                        //doesnt exist
                        $newUnit = $this->ProductUnit->create();
                        $newUnit['ProductUnit'] = $unit;
                        $newUnit['ProductUnit']['slug'] = $this->sluggify($unit['name']);
                        $newUnit['ProductUnit']['product_group_slug'] = $currentGroupSlug;
                    } else {
                        $this->importMessages[] = "Product unit: {$unit['name']} will be replaced";
                    }
                } elseif($col >= 5 && $col <= 7){ //media files
                    if(!empty($newUnit)) $newUnit['ProductUnit'][$fields[$col]['field']] = $media->safeFilename($val);
                } elseif( ($col >= 8 && $col <= 14) || ($col >= 16 && $col <= 25)){ //other fields
                    if(!$val){
                       if($fields[$col]['type'] == 'int' || $fields[$col]['type'] == 'dec' ){
                           $val = 0;
                       }
                    }
                    if(!empty($newUnit)) $newUnit['ProductUnit'][$fields[$col]['field']] = $val;
                } elseif($col === 15){ // supplier
                    if(!$val){
                        $this->importErrors[] = "Empty value - line {$lineNo}, column {$col} - expected a supplier name";
                    }
                    $supplierSlug = $this->sluggify($val,'_');
                    if(!array_key_exists($supplierSlug, $suppliers)){
                        //supplier record doesnt exist
                        $msg = "New supplier record: {$val}";
                        if(!$parseOnly){//new supplier to add
                            $newSupplier = array('Supplier'=>array('name'=>$val));
                            $this->ProductUnit->Supplier->create();
                            if(!$this->ProductUnit->Supplier->save($newSupplier)){
                                $this->importErrors[] = "Error importing new supplier: '{$val}'";
                                return false;
                            }
                            $suppliers[$supplierSlug] = $this->ProductUnit->Supplier->id;
                        } else {
                            $suppliers[$supplierSlug] = rand(1,999999);
                        }
                    } else {
                        //supplier record DOES exist
                        $msg = "Supplier: {$val} will be replaced";
                    }
                    if(!in_array($msg,$this->importMessages)){
                        $this->importMessages[] = $msg;
                    }
                    $currentSupplierId = $suppliers[$supplierSlug];
                }
                // if no more columns save the data
                if($col === $lastColumn){ // last column
                    //new group?
                    if(!empty($newGroup)){
                        debug($newGroup);
                        $this->create();
                        if(!$parseOnly){
                            $newGroup['image'] = isset($newUnit['ProductUnit']['image_file']) ? $newUnit['ProductUnit']['image_file'] : '';
                            $newGroup['guide'] = isset($newUnit['ProductUnit']['cutter_guide_file']) ? $newUnit['ProductUnit']['cutter_guide_file'] : '';
                            $newGroup['drawing'] = isset($newUnit['ProductUnit']['drawing_file']) ? $newUnit['ProductUnit']['drawing_file'] : '';
                            if(!$this->save(array('ProductGroup'=>$newGroup),false)){
                                $this->saveErrors[] = "Error saving new Product group: '{$val}'";
                                if($this->invalidFields()) $this->saveErrors[] = explode(', ',$this->invalidFields());
                                return false;
                            }
                        }
                    }
                    //new unit?
                    //debug($newUnit);
                    if(!empty($newUnit)){
                        $newUnit['ProductUnit']['supplier_id'] = $currentSupplierId;
                        //last field to import, if we have a record to save, save it
                        $msg =   "New product unit record: {$newUnit['ProductUnit']['name']}";
                        $this->ProductUnit->create();
                        if(!$parseOnly){
                            debug($newUnit);
                            $saved = $this->ProductUnit->save($newUnit,false);
                            if(!$saved){
                                $this->saveErrors[] = "Error saving new Product Unit '{$newUnit['ProductUnit']['name']}'";
                                if($this->invalidFields()) $this->saveErrors[] = explode(', ',$this->invalidFields());
                                return false;
                            }
                        }
                        $this->importMessages[] = $msg;

                    }
                }
            }
        }
        //update the foreign keys in the units table
        if(!$parseOnly){
            //update the product unit foreign keys
            $this->ProductUnit->updateForeignKeys();
            //update the ColourPrice foreign keys
            $this->ColourPrice->updateForeignKeys();
            //update the CustomOption foreign keys
            $this->CustomOption->updateForeignKeys();
        }
        return true;
    }

    private $optionCsvFields = array(
        array('name'=>'name', 'type'=>'str'),
        array('name'=>'supplier', 'type'=>'str'),
        array('name'=>'type', 'type'=>'str','value'=>array('colours','option')),
        array('name'=>'qty from', 'type'=>'int'),
        array('name'=>'qty to', 'type'=>'int'),
        array('name'=>'small 1 - 2 colours', 'type'=>'dec'),
        array('name'=>'small 3 - 4 colours', 'type'=>'dec'),
        array('name'=>'small 5 - 6 colours', 'type'=>'dec'),
        array('name'=>'large 1 - 2 colours', 'type'=>'dec','default'=>0),
        array('name'=>'large 3 - 4 colours', 'type'=>'dec','default'=>0),
        array('name'=>'large 5 - 6 colours', 'type'=>'dec','default'=>0),
        array('name'=>'option name', 'type'=>'str'),
        array('name'=>'option small price', 'type'=>'dec'),
        array('name'=>'option large price', 'type'=>'dec','default'=>0),
        array('name'=>'additional colour', 'type'=>'bool'),
        array('name'=>'option info', 'type'=>'str'),
        array('name'=>'multiplier', 'type'=>'str'),
    );


    public function importOptionCSV($csvData, $parseOnly = false, $replaceAll = true){
        $this->importErrors = array();
        $this->importMessages = array();
        if($replaceAll){
            $this->importMessages[] = 'ALL OPTIONS RECORDS WILL BE CLEARED AND REPLACED!';
        }
        $fields = $this->optionCsvFields;
        $suppliers = array_flip($this->ProductUnit->Supplier->find('list',array('fields'=>array('id','slug'))));
        $supplierId = 0;
        $recordType = 'colours';
        $currentQty = 0;
        $lastSupplierId = 0;
        $newRecords = array('colours'=>array(),'option'=>array());
        $groupSlug = 'xxxxx';
        $groupIds = array();
        foreach($csvData as $lineNo=>$line){
            $lineNo +=1;
            //check for column headers
            if($line[0] == $fields[0]['name']){
                //this line is column headers
                $this->importMessages[] = "Column headers found on line {$lineNo}";
                continue;
            }
            // if there are no columns, we have reached the end of the document
            if(count($line) <= 1){
                $this->importMessages[] = "End of records line: {$lineNo}";
                return true;
            }
            //get the record type
            $recordType = $line[2];
            //get the product group slug string
            $newGroupSlug = $this->sluggify($line[0]);
            // if changed product group
            if($groupSlug != $newGroupSlug){
                $currentQty = 0;
            }
            //find the correct product group
            $groupSlug = $newGroupSlug;
            //retrieve the group
            $group = $this->find('first', array('conditions' => array('ProductGroup.slug'=>$groupSlug), 'recursive' => -1));
            if(empty($group)){
                $this->importErrors[] = "Product group does not exist: {$line[0]}";
                if(!$parseOnly) return false;
            } else {
                $msg = "Product: {$group['ProductGroup']['name']} options will be updated";
                if(!in_array($msg,$this->importMessages)){
                    $this->importMessages[] = $msg;
                }
            }
            $groupId = $group['ProductGroup']['id'];
            //save the id for later
            if(!in_array($groupId,$groupIds)){
                $groupIds[] = $groupId;
            }

            $msg = "New {$recordType} records for product: {$line[0]}";
            if(!in_array($msg,$this->importMessages)){
                $this->importMessages[] = $msg;
            }
            //get record type
            if(!in_array($line[2],$fields[2]['value'])){
                $this->importErrors[] = "Incorrect record type: {$line[2]}";
                if(!$parseOnly) return false;
            }
            $record = array();
            //debug($line);
            //iterate over lines
            foreach($line as $col =>$val){
                $val = trim($val);
                //check for 0 or empty
                if($col >= 0 && $col <= 2 && (!$val)){
                    $this->importErrors[] = "Zero or empty value for: {$fields[$col]['name']} line {$lineNo}";
                    if(!$parseOnly) return false;
                }
                //some fields are specific to colour pricing, others to options
                if(empty($val) && isset($fields[$col]['default'])){
                    $val = $fields[$col]['default'];
                }
                if($recordType == 'colours'){
                    if($col >= 5 && $col <= 10){
                        if(!is_numeric($val)){
                            $this->importErrors[] = "Incorrect data format for: {$fields[$col]['name']} line {$lineNo}";
                            if(!$parseOnly) return false;
                        }
                        //check for 0 or empty
                        if( ($val <= 0 || !$val) && !isset($fields[$col]['default']) ){
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
                            $this->importErrors[] = "Product name does not match line {$lineNo}: {$val}";
                            if(!$parseOnly) return false;
                        }
                        $record['product_group_id'] = $groupId;
                        break;
                    case 1 : //supplier
                        $supplierSlug = $this->sluggify($val,'_');
                        if(!array_key_exists($supplierSlug, $suppliers)){
                            //no supplier found
                            $this->importErrors[] = "Supplier: \"{$val}\", line {$lineNo} does not exist in the database";
                            if(!$parseOnly) return false;
                        }
                        $supplierId = $suppliers[$supplierSlug];
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
            //add the group slug
            $record['product_group_slug'] = $groupSlug;
            //add to new records
            $newRecords[$recordType][] = $record;
        }
        if(empty($this->importErrors) && !empty($newRecords)){
            $this->saveErrors = array();
            if(!$parseOnly){
                if($replaceAll){
                    //first remove all existing records
                    $this->CustomOption->deleteAll(array('CustomOption.id >'=>0));
                    $this->ColourPrice->deleteAll(array('ColourPrice.id >'=>0));
                } else {
                    //first remove existing records for this product group
                    $this->CustomOption->deleteAll(array('CustomOption.product_group_id'=>$groupIds));
                    $this->ColourPrice->deleteAll(array('ColourPrice.product_group_id'=>$groupIds));
                }
                //save the new records
                foreach($newRecords['colours'] as $c){
                    $this->ColourPrice->create();
                    if(!$this->ColourPrice->save(array('ColourPrice'=>$c))){
                        $this->saveErrors[] = 'Error saving colour pricing records';
                        return false;
                    }
                }
                foreach($newRecords['option'] as $o){
                    $this->CustomOption->create();
                    if(!$this->CustomOption->save(array('CustomOption'=>$o))){
                        $this->saveErrors[] = 'Error saving custom options records';
                        return false;
                    }
                }
            }

        }
        return true;
    }

}
