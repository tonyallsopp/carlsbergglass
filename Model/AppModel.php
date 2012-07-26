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
        return true;
    }

    /**
     * Converts a string to a URL slug
     * @param string $string
     * @param string $seperator
     * @return string
     */
    public function sluggify($string, $seperator = '-'){
        $slug = strtolower(preg_replace('/[^\w]/', $seperator, trim($string)));
        $slug = str_replace(' ', $seperator, $slug);
        $slug = explode($seperator, $slug);
        $slug = array_filter($slug);
        $slug = implode($seperator, $slug);
        return $slug;
    }
}
