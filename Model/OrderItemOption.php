<?php
App::uses('AppModel', 'Model');
/**
 * OrderItemOption Model
 *
 * @property OrderItem $OrderItem
 */
class OrderItemOption extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'order_item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
        'value' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Must be a numeric value',
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
		'OrderItem' => array(
			'className' => 'OrderItem',
			'foreignKey' => 'order_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
