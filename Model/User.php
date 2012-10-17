<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

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
    public $hasOne = array(
        'Address'
    );


    public $virtualFields = array(
        'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );

    public $countries = array(
        "AT" => "Austria",
        "BE" => "Belgium",
        "BG" => "Bulgaria",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "EE" => "Estonia",
        "FI" => "Finland",
        "FR" => "France",
        "DE" => "Germany",
        "GR" => "Greece",
        "HU" => "Hungary",
        "IE" => "Ireland",
        "IT" => "Italy",
        "LV" => "Latvia",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MT" => "Malta",
        "NL" => "Netherlands",
        "PL" => "Poland",
        "PT" => "Portugal",
        "RO" => "Romania",
        "SK" => "Slovakia (Slovak Republic)",
        "SI" => "Slovenia",
        "ES" => "Spain",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "GB" => "United Kingdom"
    );

    public function __construct(){
        parent::__construct();
        $countries = array();
        foreach($this->countries as $c){
            $countries[$c] = $c;
        }
        $this->countries = $countries;
    }

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

    public function updateLastLogin($user){
        $now = date('Y-m-d H:i:s');
        $this->id = $user['id'];
        $this->saveField('last_login', $now);
    }

    public $roles = array(0=>'user',1=>'admin');


}
