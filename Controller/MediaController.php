<?php
App::uses('AppController', 'Controller');
/**
 * Media Controller
 *
 * @property Media $Media
 */
class MediaController extends AppController {

    public $helpers = array('Uploadify');

    /**
     * index method
     *
     * @return void
     */
    public function admin_index()
    {
        $manual = $this->Media->find('first', array('conditions' => array('type'=>'manual'), 'recursive' => -1));
        $this->set('manual', $manual);
        $this->set('title_for_layout', 'Manage Media');
    }

    /**
     * manual method
     *
     * @return void
     */
    public function admin_manual()
    {
        $manual = $this->Media->find('first', array('conditions' => array('type'=>'manual'), 'recursive' => -1));
        if(empty($manual)){
            $manual = array('Media'=>array(
                'name'=>'POS Glassware Manual',
                'filename'=>'pos_glassware_manual.pdf',
                'type'=>'manual'
            ));
        }
        if ($this->request->is('post')) {
            debug($this->request->data);
            $this->request->data['Media']['type'] = 'manual';
            $this->Media->set($this->request->data);
            if($this->Media->validates()){
                if($this->uploadFile($this->request->data['Media']['file'],'pos_glassware_manual.pdf', MANUAL_DIR)){
                    $media = $manual;
                    unset($media['Media']['updated']);
                    if($this->Media->save($media)){
                        $this->Session->setFlash(__('Manual uploaded successfully.'));
                    }
                    $this->redirect('/admin/media');
                } else {
                    $this->Session->setFlash(__('Error uploading file.'));
                }
            }
        }
        $this->set('manual', $manual);
        $this->set('title_for_layout', 'POS Glassware Manual');
    }

    /**
     * images method
     *
     * @return void
     */
    public function admin_images()
    {
        $this->paginate = array('conditions'=>array('Media.type'=>'prod_img'));
        $this->Media->recursive = 0;
        $this->set('media', $this->paginate());
    }

    /**
     * images method
     *
     * @return void
     */
    public function admin_upload_images()
    {

    }

    public function admin_ajax_image_upload() {
        if(!empty($_FILES)){
            //$fName = $this->Media->unique_filename($_FILES['Filedata']['name']);
            $fName = $this->Media->safeFilename($_FILES['Filedata']['name']);
            $res = $this->Media->handleImageUpload($_FILES['Filedata'], $fName);
            $res['saved'] = 0;
            $res['id'] = '';
            if($res['success']){
                //uploaded OK, save the record
                //1st delete existing records with same name
                $this->Media->deleteAll(array('Media.type' => 'prod_img','Media.filename'=>$fName));
                //save new
                $rec = $this->Media->create();
                $rec['Media']['filename'] = $fName;
                $rec['Media']['name'] = $_FILES['Filedata']['name'];
                $rec['Media']['type'] = 'prod_img';
                if($this->Media->save($rec)){
                    $res['saved'] = 1;
                    $res['id'] = $this->Media->id;
                }
            }
        } else {
            $res = array();
        }
        $this->set('response',  json_encode($res));
        $this->render('/Elements/ajax','ajax');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null)
    {
        $this->Media->id = $id;
        if (!$this->Media->exists()) {
            throw new NotFoundException(__('Invalid media'));
        }
        $this->set('media', $this->Media->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post')) {
            $this->Media->create();
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('The media has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The media could not be saved. Please, try again.'));
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
    public function admin_edit($id = null)
    {
        $this->Media->id = $id;
        if (!$this->Media->exists()) {
            throw new NotFoundException(__('Invalid media'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Media->save($this->request->data)) {
                $this->Session->setFlash(__('The media has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The media could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Media->read(null, $id);
        }
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null)
    {
        $res = array('success'=>0);
        $media = $this->Media->find('first', array('conditions' => array('id'=>$id), 'recursive' => -1));

        if($this->request->is('ajax') ){
            if ($this->Media->delete($id)) {
                $this->Media->deleteFiles($media['Media']['filename'], $media['Media']['type']);
                $res['success'] = 1;
            }
            $this->set('response',  json_encode($res));
            $this->render('/Elements/ajax','ajax');
        } else{
            if ($this->Media->delete($id)) {
                $this->Media->deleteFiles($media['Media']['filename'], $media['Media']['type']);
                $this->Session->setFlash(__('Media deleted'));
                $this->redirect($this->sessionReferer);
            }
            $this->Session->setFlash(__('Media was not deleted'));
            $this->redirect($this->sessionReferer);
        }

    }
}
