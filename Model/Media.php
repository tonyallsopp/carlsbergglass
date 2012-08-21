<?php
App::uses('AppModel', 'Model');
/**
 * Media Model
 *
 */
class Media extends AppModel {

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
			),
		),
		'filename' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
			),
		),
        'file' => array(
            'validSize' => array(
                'rule' => array('validSize'),
                'message' => 'File is too large (max 10mb)',
            ),
            'hasContents' => array(
                'rule' => array('notZeroBytes'),
                'message' => 'File is empty (zero bytes)',
            ),
            'validType' => array(
                'rule' => array('validFileType'),
                'message' => 'Invalid file type',
            ),
        ),
	);

    public function validSize($check) {
        if(!isset($this->data['Media']['file']['size'])) return false;
        $file =  $this->data['Media']['file'];
        $maxSize = (1024 * 1024) * 10; // 10 meg
        return ($file['size'] <= $maxSize);
    }

    public function notZeroBytes($check) {
        return (isset($this->data['Media']['file']['size']) && $this->data['Media']['file']['size']);
    }

    public function validFileType($check) {
        if(!isset($this->data['Media']['file']['size'])) return false;
        $file =  $this->data['Media']['file'];
        switch($this->data['Media']['type']){
            case 'manual' :
                return stripos($file['type'], 'pdf') !== false;
                break;
        }
        return false;
    }
}
