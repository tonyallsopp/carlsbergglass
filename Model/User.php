<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

    public $userRoles = array('Admin','User');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
            ),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Invalid email address',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'An account already exists with this email',
                'on' => 'create'
            ),
		),
        'confirm_email' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Invalid email address'
            ),
            'match' => array(
                'rule' => array('compareFields','email','confirm_email'),
                'message'=>'Email must match'
            ),
        ),
        'first_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
        'last_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
        'telephone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
        'company' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
        'country' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
        'new_password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'confirm_password' => array(
            'match' => array(
                'rule' => array('compareFields','new_password','confirm_password'),
                'message'=>'Passwords must match'
            ),
		),
        'job_title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
		'role' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Invalid role',
			),
		),
        'accept' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required',
                'allowEmpty' => false,
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
		),
        //used for contact form
        'name' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        ),
        'message' => array(
            'notempty' => array(
                'rule' => 'notEmpty',
                'message'=>'Field is required',
                'allowEmpty' => false,
            ),
        )
	);

    public $hasMany = array(
        'Order'
    );

    public $virtualFields = array(
        'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );

    public function compareFields($check, $field1, $field2) {
        return $this->data['User'][$field1] == $this->data['User'][$field2];
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if(isset($this->data['User']['new_password']) && $this->data['User']['new_password']){
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['new_password']);
        }
        return true;
    }

    public $roles = array(0=>'user',1=>'admin');

    public $countries = array(
        'UK'=>'UK',
        'Denmark'=>'Denmark',
        'Germany'=>'Germany'
    );
}
