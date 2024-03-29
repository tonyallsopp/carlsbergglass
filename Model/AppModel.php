<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public $actsAs = array('Containable');

    public $currentUserId = NULL;

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        //add created_by and updated_by
        if($this->hasField('created_by') || $this->hasField('updated_by')){
            App::import('CakeSession');
            $this->currentUserId = CakeSession::read('Auth.User.id');
            if($this->currentUserId){
                if(!$this->data[$this->name]['id']) $this->data[$this->name]['created_by'] = $this->currentUserId;
                $this->data[$this->name]['updated_by'] = $this->currentUserId;
            }
        }
        // slug field
        if($this->hasField('slug') && $this->hasField('name')){
            if($this->data[$this->name]['name']){
                $this->data[$this->name]['slug'] = $this->sluggify($this->data[$this->name]['name'],'_');
            }
        }
        return true;
    }

    /**
     * Converts a string to a URL slug
     * @param string $string
     * @param string $seperator
     * @return string
     */
    public function sluggify($string, $seperator = '-'){
        $slug = strtolower(preg_replace('/[^\w]/', $seperator, substr(trim($string),0,80) ));
        $slug = str_replace(' ', $seperator, $slug);
        $slug = explode($seperator, $slug);
        $slug = array_filter($slug);
        $slug = implode($seperator, $slug);
        return $slug;
    }

    /**
     * Returns true if file is uploaded, used with validation
     * @param $params
     * @return bool
     */
    public function isUploadedFile($params) {
        $val = array_shift($params);
        if ((isset($val['error']) && $val['error'] == 0) ||
            (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')
        ) {
            return is_uploaded_file($val['tmp_name']);
        }
        return false;
    }

    /**
     * checks file properties against given validation params
     * @param $params
     * @param $validation
     * @return bool
     */
    public function isValidFile($params, $validation){
        $val = array_shift($params);
        if ((isset($val['error']) && $val['error'] == 0)) {
            if(in_array(substr($val['name'],strripos($val['name'],'.') +1),$validation['ext']) && $val['size'] <= $validation['max_size']){
                return true;
            }
        }
        return false;
    }
}
