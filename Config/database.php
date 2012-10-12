<?php

class DATABASE_CONFIG {

    //DEV
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'carlsberg_glass',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
    //STAGING
    /*public $default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'posdevdb',
        'password' => 'charlie54',
        'database' => 'posglassdev',
        'prefix' => '',
        //'encoding' => 'utf8',
    );*/
    //LIVE
    /*public $default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'posdb',
        'password' => 'charlie54',
        'database' => 'posglass',
        'prefix' => '',
        //'encoding' => 'utf8',
    );*/
}
