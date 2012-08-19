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
}
