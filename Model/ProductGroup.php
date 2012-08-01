<?php
App::uses('AppModel', 'Model');
/**
 * ProductGroup Model
 *
 * @property Category $Category
 * @property ProductUnit $ProductUnit
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

}
