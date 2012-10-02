<?php
App::uses('AppModel', 'Model');
/**
 * Address Model
 *
 * @property User $User
 * @property Order $Order
 */
class Address extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Required field',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'telephone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
                'message' => 'Required field',
			),
		),
		'address_1' => array(
			'notempty' => array(
				'rule' => array('notempty'),
                'message' => 'Required field',
			),
		),
		'town' => array(
			'notempty' => array(
				'rule' => array('notempty'),
                'message' => 'Required field',
			),
		),
		'region' => array(
			'notempty' => array(
				'rule' => array('notempty'),
                'message' => 'Required field',
			),
		),
		'postcode' => array(
			'notempty' => array(
				'rule' => array('notempty'),
                'message' => 'Required field',
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'order_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
