<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

Router::connect('/branded_glassware/index', array('controller' => 'product_groups', 'action' => 'index','branded'));
Router::connect('/branded_glassware/*', array('controller' => 'product_groups', 'action' => 'view'));


/**
* ...and connect the rest of 'Pages' controller's urls.
*/
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
* Load all plugin routes.  See the CakePlugin documentation on
* how to customize the loading of plugin routes.
*/
CakePlugin::routes();

/**
* Load the CakePHP default routes. Remove this if you do not want to use
* the built-in default routes.
*/
require CAKE . 'Config' . DS . 'routes.php';
