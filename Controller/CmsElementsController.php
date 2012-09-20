<?php
App::uses('AppController', 'Controller');
/**
 * CmsElements Controller
 *
 * @property CmsElement $CmsElement
 */
class CmsElementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function get($name = null) {
        $elem = $this->CmsElement->find('first', array('conditions' => array('name'=>$name), 'recursive' => -1));
        //debug($elem);
        if (empty($elem)) {
            throw new NotFoundException(__('Invalid cms element'));
        }
        return $elem;
	}

    public function faqs(){
        $cond = array('CmsElement.section'=>'faq','CmsElement.parent_id'=>0);
        $sections = $this->CmsElement->find('all', array('conditions' => $cond, 'order'=>'CmsElement.display_order ASC','recursive'=>-1));
        foreach($sections as $k => $v){
            $sections[$k]['ChildElement'] = $this->CmsElement->find('all', array('conditions' => array('CmsElement.type'=>'q','CmsElement.parent_id'=>$v['CmsElement']['id']), array('order'=>'ChildElement.display_order ASC'), 'recursive' => -1));
        }
        $this->set('sections',$sections);
        $this->set('title_for_layout', 'Support');
        $this->set('breadcrumbs', array('Support'=>'/support'));
    }

    public function faq($slug){
        $cond = array('CmsElement.name'=>$slug,'CmsElement.type'=>'q');
        $faq = $this->CmsElement->find('first', array('conditions' => $cond, 'contain'=>array('ChildElement')));
        $this->set('faq',$faq);
        $this->set('title_for_layout', $faq['CmsElement']['content']);
        $this->set('breadcrumbs', array('Support'=>'/support',$faq['CmsElement']['content'] => "/support/{$faq['CmsElement']['name']}"));
    }

    /**
     * index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->CmsElement->recursive = 0;
        $this->paginate = array('order'=>'CmsElement.display_order ASC, CmsElement.description ASC','conditions'=>array('CmsElement.section'=>'cms'));
        $this->set('section', 'cms');
        $this->set('breadcrumbs', array('Site Content'=>'/cms_elements'));
        $this->set('cmsElements', $this->paginate());
    }

    /**
     * configs method
     *
     * @return void
     */
    public function admin_configs()
    {
        $this->CmsElement->recursive = 0;
        $this->paginate = array('order'=>'CmsElement.display_order ASC, CmsElement.description ASC','conditions'=>array('CmsElement.section'=>'cfg'));
        $this->set('cmsElements', $this->paginate());
        $this->set('section', 'configs');
        $this->set('breadcrumbs', array('Site Config'=>'/cms_elements/configs'));
        $this->render('admin_index');

    }

    /**
     * faq_index method
     *
     * @return void
     */
    public function admin_faq_index()
    {
        $this->CmsElement->recursive = 0;
        $this->paginate = array('order'=>'ParentElement.display_order ASC, CmsElement.display_order ASC','conditions'=>array('CmsElement.section'=>'faq','CmsElement.type'=>'q'));
        $this->set('cmsElements', $this->paginate());
    }

    /**
     * edit_faq method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit_faq($id = null) {
        $this->CmsElement->id = $id;
        $faq = $this->CmsElement->find('first', array('conditions' => array('CmsElement.id'=>$id),'contain'=>'ChildElement'));
        if (empty($faq)) {
            $this->Session->setFlash(__('Invalid FAQ'));
            $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $faq['CmsElement']['content'] = $this->request->data['CmsElement']['content'];
            $faq['CmsElement']['name'] = $this->CmsElement->sluggify($this->request->data['CmsElement']['content'],'_');
            $faq['ChildElement']['content'] = $this->request->data['ChildElement']['content'];
            $faq['ChildElement']['name'] = $this->CmsElement->sluggify($this->request->data['ChildElement']['content'],'_');
            //debug($faq);exit;
            if ($this->CmsElement->saveAll($faq)) {
                $this->Session->setFlash(__('The FAQ has been saved'));
                $this->redirect(array('action' => 'faq_index'));
            } else {
                $this->Session->setFlash(__('The FAQ could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->CmsElement->read(null, $id);
        }
        $sections = $this->CmsElement->find('list',array('fields'=>array('id','content'),'order'=>'display_order ASC','conditions'=>array('CmsElement.parent_id'=>0,'CmsElement.section'=>'faq')));
        $this->set('sections',$sections);
    }

    /**
     * add_faq method
     *
     * @return void
     */
    public function admin_add_faq() {
        if ($this->request->is('post')) {
            $data = $this->CmsElement->create();
            $data['CmsElement']['section'] = 'faq';
            $data['CmsElement']['display_order'] = $this->CmsElement->nextDisplayOrder($this->request->data['CmsElement']['parent_id']);
            $data['CmsElement']['type'] = 'q';
            $data['CmsElement']['description'] = 'FAQ Question';
            $data['CmsElement']['name'] = $this->CmsElement->sluggify($this->request->data['CmsElement']['content'],'_');
            $data['CmsElement']['content'] = $this->request->data['CmsElement']['content'];
            $data['CmsElement']['parent_id'] = $this->request->data['CmsElement']['parent_id'];
            $data['ChildElement']['name'] = $this->CmsElement->sluggify($this->request->data['ChildElement']['content'],'_');
            $data['ChildElement']['section'] = 'faq';
            $data['ChildElement']['type'] = 'a';
            $data['ChildElement']['description'] = 'FAQ Answer';
            $data['ChildElement']['content'] = $this->request->data['ChildElement']['content'];
            $this->request->data = $data;
            if ($this->CmsElement->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The FAQ has been saved'));
                $this->redirect(array('action' => 'faq_index'));
            } else {
                $this->Session->setFlash(__('The FAQ could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->CmsElement->create();
        }
        $sections = $this->CmsElement->find('list',array('fields'=>array('id','content'),'order'=>'display_order ASC','conditions'=>array('CmsElement.parent_id'=>0,'CmsElement.section'=>'faq')));
        $this->set('sections',$sections);
    }


/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CmsElement->create();
			if ($this->CmsElement->save($this->request->data)) {
				$this->Session->setFlash(__('The cms element has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cms element could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->CmsElement->id = $id;
		if (!$this->CmsElement->exists()) {
			throw new NotFoundException(__('Invalid cms element'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            $redir = $this->request->data['CmsElement']['section'] == 'cfg' ? 'configs' : 'index';
			if ($this->CmsElement->save($this->request->data)) {
				$this->Session->setFlash(__('The cms element has been saved'));
				$this->redirect(array('action' => $redir));
			} else {
				$this->Session->setFlash(__('The cms element could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CmsElement->read(null, $id);
            $redir = $this->request->data['CmsElement']['section'] == 'cfg' ? 'configs' : 'index';
		}
        $this->set('referrer',$redir);
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CmsElement->id = $id;
		if (!$this->CmsElement->exists()) {
			throw new NotFoundException(__('Invalid cms element'));
		}
		if ($this->CmsElement->delete()) {
			$this->Session->setFlash(__('Cms element deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cms element was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
