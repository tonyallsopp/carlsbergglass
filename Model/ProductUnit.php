<?php
App::uses('AppModel', 'Model');
/**
 * ProductUnit Model
 *
 * @property Image $Image
 * @property Supplier $Supplier
 * @property ProductGroup $ProductGroup
 * @property OrderItem $OrderItem
 */
class ProductUnit extends AppModel {

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
		'capacity' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'capacity_group' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'origin' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'hs_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'fs_location' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'supplier_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'product_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Supplier' => array(
			'className' => 'Supplier',
			'foreignKey' => 'supplier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'ProductGroup'
	);

    public $hasOne = array(
        'OrderItem'
    );

    public function calcCapacityGroup($capacity){
        $capArray = explode('/',$capacity);
        $cap = preg_replace('/[^0-9.]/','',$capArray[0]) *1;
        if($cap >= 0.44){
            return 'large';
        }
        return 'small';
    }

    public function updateForeignKeys(){
        $recs = $this->find('list', array('fields' => array('id','product_group_slug')));
        $updateIds = array();
        foreach($recs as $id => $slug){
            $updateIds[$slug][] =  $id;
        }
        if(!empty($updateIds)){
            foreach($updateIds as $slug => $ids){
                $group = $this->ProductGroup->find('first', array('conditions' => array('slug'=>$slug), 'recursive' => -1));
                if(!empty($group)){
                    $this->updateAll(array('ProductUnit.product_group_id'=>$group['ProductGroup']['id']), array('ProductUnit.id'=>$ids));
                }
            }
        }
    }
}
