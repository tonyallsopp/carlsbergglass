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
        $opts = array('Category' => array('conditions' => $conditions, 'contain' => $contain, 'limit' => 20, 'order' => 'Category.name ASC'));
        $this->paginate = $opts;
        $categories = $this->paginate('Category');
        debug($categories);
        $this->set('listings', $categories);
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
    }


}
