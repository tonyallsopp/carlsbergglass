<?php
App::uses('AppModel', 'Model');
/**
 * OrderItem Model
 *
 * @property ProductUnit $ProductUnit
 * @property Order $Order
 * @property OrderItemOption $OrderItemOption
 */
class OrderItem extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'product_unit_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'order_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be a numeric value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'qty' => array(
			'numeric' => array(
				'rule' => array('numeric'),
                'message' => 'Must be a numeric value',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'colours' => array(
			'numeric' => array(
				'rule' => array('numeric'),
                'message' => 'Must be a numeric value',
				'allowEmpty' => true,
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
		'ProductUnit' => array(
			'className' => 'ProductUnit',
			'foreignKey' => 'product_unit_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'OrderItemOption' => array(
			'className' => 'OrderItemOption',
			'foreignKey' => 'order_item_id',
			'dependent' => true,
		)
	);

    public function quoteItem(array &$order, array $data, $productUnit, $productGroup){
        //debug($productGroup);exit;
        $order['OrderItem'][0]['qty'] = $data['OrderItem'][0]['qty'];
        $order['OrderItem'][0]['capacity'] = $productUnit['capacity'];
        $order['OrderItem'][0]['name'] = $productGroup['ProductGroup']['name'];
        $qty = $order['OrderItem'][0]['qty'];
        $order['OrderItem'][0]['colours'] = $data['OrderItem'][0]['colours'];
        //delete any existing options
        if(isset($order['OrderItem'][0]['id']) && $order['OrderItem'][0]['id']){
            $this->OrderItemOption->deleteAll(array('OrderItemOption.order_item_id' => $order['OrderItem'][0]['id']));
            unset($order['OrderItem'][0]['OrderItemOption']);
        }
        $i = 0;
        $totalPrice = $productUnit['price'];
        $optionAdditionalColours = 0;
        $baseColours = $order['OrderItem'][0]['colours'];
        //large / small group
        $capacityGroup = $productUnit['capacity_group'];
        foreach($data['OrderItemOption'] as $o){
            if($o['value']){
                $order['OrderItem'][0]['OrderItemOption'][$i] = $o;
                //get the price for this option
                foreach($productUnit['CustomOption'] as $cOpt){
                    if($cOpt['CustomOption']['name'] == $o['name']){
                        $unitPrice = $cOpt['CustomOption']["{$capacityGroup}_price"];
                        //if we have a multiplier, use it
                        if($cOpt['CustomOption']['multiplier']){
                            $order['OrderItem'][0]['OrderItemOption'][$i]['multiplier'] = $cOpt['CustomOption']['multiplier'];
                            $unitPrice = $unitPrice * $o['value'];
                        }
                        //if the option counts as an additional colour
                        if($cOpt['CustomOption']['is_colour']){
                            $optionAdditionalColours += 1;
                        }
                        //add the unit price
                        $order['OrderItem'][0]['OrderItemOption'][$i]['price'] = $unitPrice;
                        $totalPrice += $unitPrice;
                        break;
                    }
                }
                $i++;
            }
        }
        //add up number of colours and apply price
        $colourPriceAdjust = 0;
        $totalColours = $baseColours + $optionAdditionalColours;
        if($totalColours){
            switch($totalColours){
                case 1:
                case 2:
                    $sizeCat = "{$capacityGroup}_1_2";
                    break;
                case 3:
                case 4:
                    $sizeCat = "{$capacityGroup}_3_4";
                    break;
                default :
                    $sizeCat = "{$capacityGroup}_5_6";
                    break;
            }
            foreach($productUnit['ColourPrice'] as $cp){
                //find the right qty grouping
                if($qty >= $cp['ColourPrice']['qty_from'] && $qty <= $cp['ColourPrice']['qty_to'] ){
                    $colourPriceAdjust = $cp['ColourPrice'][$sizeCat];
                }
            }
        }
        //total unit price
        $order['OrderItem'][0]['unit_price'] = $totalPrice + $colourPriceAdjust;
        //get the product unit id
        $order['OrderItem'][0]['product_unit_id'] = $productUnit['id'];
        debug($order['OrderItem'][0]);
    }

}
