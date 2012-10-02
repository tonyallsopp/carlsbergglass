<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property User $User
 * @property OrderItem $OrderItem
 * @property Address $Address
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
        'quote_requested' => array(
            'match' => array(
                'rule' => array('quoteSampleCheck'),
                'message'=>'Choose an option'
            ),
        ),
        /*'sample_requested' => array(
            'match' => array(
                'rule' => array('quoteSampleCheck'),
                'message'=>'Tick a next action'
            ),
        ),*/
    );

    //custom validation

    public function quoteSampleCheck($check) {
        if(isset($this->data['Order']['quote_requested']) || isset($this->data['Order']['sample_requested'])){
            debug($this->data['Order']);
            return $this->data['Order']['quote_requested'] || $this->data['Order']['sample_requested'];
        }
        return true;
    }

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

    public $hasOne = array(
        'Address'
    );

    public function initQuote($user, $data, $productUnit, $productGroup)
    {
        //find existing order
        $cond = array('Order.user_id' => $user['id'], 'Order.status' => 0);
        if (isset($data['Order']['id'])) {
            $cond['Order.id'] = $data['Order']['id'];
        }
        $contain = array('OrderItem'=>array('OrderItemOption'));
        $order = $this->find('first', array('conditions' => $cond,'order'=>'Order.id DESC','contain'=>$contain));
        if (empty($order)) {
            //no order, create one
            $order = $this->create();
            $order['Order']['user_id'] = $user['id'];
        }
        //merge in other Order options
        $order['Order']['quote_requested'] = $data['Order']['quote_requested'];
        $order['Order']['sample_requested'] = $data['Order']['sample_requested'];
        //add the order item and options (or replace existing)
        $this->OrderItem->quoteItem($order, $data, $productUnit, $productGroup);
        debug($order);
        return $order;
    }

}
