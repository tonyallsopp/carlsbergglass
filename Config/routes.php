<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'display','home'));
Router::connect('/admin', array('controller' => 'users', 'action' => 'index','admin'=>true));

Router::connect('/account', array('controller' => 'users', 'action' => 'account'));
Router::connect('/contact', array('controller' => 'users', 'action' => 'contact'));
Router::connect('/contact_thanks', array('controller' => 'users', 'action' => 'contact_thanks'));
Router::connect('/support', array('controller' => 'cms_elements', 'action' => 'faqs'));
Router::connect('/faq/*', array('controller' => 'cms_elements', 'action' => 'faq'));

Router::connect('/branded_glassware/index/*', array('controller' => 'product_groups', 'action' => 'index'));
Router::connect('/branded_glassware/*', array('controller' => 'product_groups', 'action' => 'view'));
Router::connect('/glassware_brands/*', array('controller' => 'categories', 'action' => 'brands'));
Router::connect('/custom_glassware', array('controller' => 'categories', 'action' => 'custom'));
Router::connect('/custom_glassware/view/*', array('controller' => 'product_groups', 'action' => 'view_custom'));
Router::connect('/custom_glassware/*', array('controller' => 'product_groups', 'action' => 'custom_index'));




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
