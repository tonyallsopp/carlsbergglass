<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property User $User
 * @property OrderItem $OrderItem
 */
class Order extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'OrderItem' => array(
			'className' => 'OrderItem',
			'foreignKey' => 'order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public function initQuote($user, $data){
        $cond = array('Order.user_id'=>$user['id'],'Order.quote_requested'=>0,'Order.sample_requested'=>0);
        if(isset($data['Order']['id'])){
            $cond['Order.id'] = $data['Order']['id'];
        }
        $order = $this->find('all', array('conditions' => $cond));
        if(empty($order)){
            //no order, create one
            $order = $this->create();
            $order['Order']['user_id'] = $user['id'];
        }
        //add the order item (or replace existing)
        $order['OrderItem'][0] = $this->OrderItem->quoteItem($data);
        //debug($order);
    }

}
