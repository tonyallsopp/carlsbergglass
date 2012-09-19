<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {


    public function brands()
    {
        $conditions = array('Category.section' => 'branded');
        $contain = array('ProductGroup');
        $opts = array('Category' => array('conditions' => $conditions, 'contain' => $contain, 'limit' => 100, 'order' => 'Category.name ASC'));
        $this->paginate = $opts;
        $categories = $this->paginate('Category');
        $categoryList = array();
        foreach($categories as $cat){
            $categoryList[$cat['Category']['slug']] = $cat['Category']['name'];
        }
        $this->set('categoryList', $categoryList);
        $this->set('listings', $categories);
        $this->set('breadcrumbs', array('Glassware by Brand'=>'/glassware_brands'));
    }

    public function custom()
    {
        $conditions = array('Category.section' => 'unbranded');
        $contain = array('ProductGroup');
        $opts = array('Category' => array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20, 'order' => 'Category.name ASC'));
        $this->paginate = $opts;
        $categories = $this->paginate('Category');
        debug($categories);
        $this->set('listings', $categories);
        $this->set('breadcrumbs', array('Glassware Configurator'=>'/custom_glassware'));
    }


}
