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
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'first_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
            ),
        ),
        'last_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
            ),
        ),
        'telephone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
            ),
        ),
        'company' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
            ),
        ),
        'country' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message'=>'Field is required'
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
                'rule' => array('comparePasswords'),
                'message'=>'Passwords must match'
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
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
		)
	);

    public $virtualFields = array(
        'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );

    public function comparePasswords($check) {
        return $this->data['User']['new_password'] == $this->data['User']['confirm_password'];
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if($this->data['User']['new_password']){
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['new_password']);
        }
        return true;
    }

    public $roles = array(1=>'admin',2=>'logistics admin',3=>'logistics user');

    public $countries = array(
        'UK'=>'UK',
        'Denmark'=>'Denmark',
        'Germany'=>'Germany'
    );
}
