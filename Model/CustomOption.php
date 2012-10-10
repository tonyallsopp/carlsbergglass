<?php
App::uses('AppModel', 'Model');
/**
 * CustomOption Model
 *
 * @property Supplier $Supplier
 * @property ProductGroup $ProductGroup
 */
class CustomOption extends AppModel {

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
		'is_colour' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'supplier_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'product_group_id' => array(
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
		'ProductGroup' => array(
			'className' => 'ProductGroup',
			'foreignKey' => 'product_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

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
                    $this->updateAll(array('CustomOption.product_group_id'=>$group['ProductGroup']['id']), array('CustomOption.id'=>$ids));
                }
            }
        }
    }
}
