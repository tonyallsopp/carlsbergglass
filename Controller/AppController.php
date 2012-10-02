<?php

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Application-wide methods
 *
 * @package       app.Controller
 * @property CakeRequest $request
 */
class AppController extends Controller {

    public $helpers = array('Html', 'Form', 'Session', 'Time','Email','Site');
    public $components = array('Auth', 'Session', 'Security');
    public $sessionReferer;
    public $requestedURL;
    //countries
    public $countries = array(
        'Denmark'=>'Denmark',
        'France'=>'France',
        'Germany'=>'Germany',
        'Spain'=>'Spain',
        'Sweden'=>'Sweden',
        'United Kingdom'=>'United Kingdom',
        );

    public function beforeFilter() {
        parent::beforeFilter();

        //turn off form POST validation (causing problems)
        $this->Security->validatePost = false;
        //only check csrf on live site
        if(Configure::read() > 0) $this->Security->csrfCheck = false;
        //force SSL on admin an checkout pages
        // note that setting core security level to > low MAY cause infinite redirects
        /*if (SERVER_TYPE == 'production' && (isset($this->params['admin']) || ($this->request['action'] == 'checkout') || $this->request['action'] == 'login')) {
            //admin pages + checkout page must be https
            $this->Security->blackHoleCallback = 'forceSSL';
            $this->Security->requireSecure();
        } elseif ($this->request->is('ssl') && !$this->request->requested) {
            //other pages are non-https
            $this->redirect('http://' . env('SERVER_NAME') . $this->here);
        }*/

        //this is needed by uploadify
        if ($this->request['controller'] == 'media' && $this->request['action'] == 'admin_ajax_image_upload' && isset($_REQUEST["session_id"])) {
            $session_id = $_REQUEST["session_id"];
            $this->Session->id($session_id);
        }

        //start auth
        $this->_initAuth();

        //set the admin layout
        /*if (isset($this->request->params['admin'])) {
            $this->layout = 'admin';
        }*/

        //init sessionReferer
        $this->getSessionReferer();

        //load site configs into session
        if(!$this->request->is('requested')) $this->getConfigs();
    }

    public function forceSSL($error) {
        CakeLog::write('error', 'Blackhole: ' . $this->here . ' error: ' . $error);
        switch ($error) {
            case 'secure':
                $this->redirect('https://' . env('SERVER_NAME') . $this->here);
                break;
            case 'login':
                // do something else
                break;
            default:
                // do something else
                break;
        }
    }

    private $_authAllowed = array('/users/register','/users/forgot_password','/users/register_thanks','/users/password_sent','/users/preview_email');

    private function _initAuth() {
        $this->Auth->authenticate = array(
            'Form' => array(
                'scope' => array('User.enabled' => 1),
                'fields' => array('username' => 'email')
            )
        );
        $this->Auth->authError = 'Please log in to proceed';
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        //allow auth for non-admin
        if (isset($this->request->params['admin'])) {
            $this->Auth->deny('*');
        } elseif($this->_isAuthorised() || $this->request->is('requested') || $this->request->is('ajax')) {
            $this->Auth->allow('*');
        } else {
            $this->Auth->deny('*');
        }

        $this->set('_user', $this->Auth->user());
        $this->_user = $this->Auth->user();

        //set the current user id for use in created_by and updated_by fields
        $this->{$this->modelClass}->currentUserId = $this->Auth->user('id');

        //set the admin layout
        $this->set('adminLayout',isset($this->request->params['admin']));

    }

    private function _isAuthorised(){
        $current = array($this->request->params['controller'],$this->request->params['action']);
        //if(isset($this->request->params['pass'][0])) $current[] = $this->request->params['pass'][0];
        foreach($this->_authAllowed as $url){
            if($url == '/' . implode('/',$current)){
                return true;
            }
        }
        return false;
    }

    public function beforeRender() {
        parent::beforeRender();
        $this->set('sessionReferer', $this->sessionReferer);
    }

    public function getConfigs(){
        if(!$this->Session->read('configs')){
            $this->loadModel('CmsElement');
            $cfg = $this->CmsElement->getSiteConfigs();
            $this->Session->write('configs',$cfg);
        } else {
            $cfg = $this->Session->read('configs');
        }
        $this->_configs = $cfg;
    }



    /**
     * get the refering URL, save it to session
     */
    private function getSessionReferer() {
        if($this->request->requested){
            return;
        }
        $noRefer = array('login', 'sign_up', 'checkout_sign_in', '.ico', 'charities/contact','reset_password');
        $this->sessionReferer = $this->Session->read('referer');
        $ref = $this->referer(null, true);
        $url = $this->request->url;
        //set the referer
        $ref = stripos($ref, '/') !== 0 ? '/' . $ref : $ref;
        $page = stripos($url, '/') !== 0 ? '/' . $url : $url;
        $newRef = true;
        foreach ($noRefer as $n) {
            if (stripos($ref, $n) !== false) {
                $newRef = false;
                break;
            }
        }
        if ($page != $ref && $newRef) {
            $this->sessionReferer = $ref;
        } elseif (!$this->sessionReferer) {
            $this->sessionReferer = '/';
        }
        $this->Session->write('referer', $this->sessionReferer);

        //set the requested page
        $newReq = true;
        foreach ($noRefer as $n) {
            if (stripos($page, $n) !== false) {
                $newReq = false;
                break;
            }
        }
        if ($newReq) {
            $this->requestedURL = $page;
        } else {
            $this->requestedURL = $this->Session->read('requrl');
        }
        if (!$this->requestedURL)
            $this->requestedURL = '/';
        $this->Session->write('requrl', $this->requestedURL);
    }

    /**
     * Generate a random string
     * @return string
     */
    public function uniqueKey() {
        return md5(date('YmdHis') . rand(1, 9999999));
    }

    public function randomPassword() {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= 6) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    /**
     * Applied fitler from POST data to create set of named params and redirects
     * @param array $filters
     */
    public function applyFilters($filters) {
        $res = array();
        foreach ($filters as $k => $v) {
            if (is_array($v)) {
                $model = $k;
                foreach ($v as $param => $filter) {
                    if (is_array($filter)) {
                        $filterVal = array();
                        foreach ($filter as $x) {
                            if ($x)
                                $filterVal[] = $x;
                        }
                        if (count($filterVal))
                            $res[] = "{$model}.{$param}:" . implode(',', $filterVal);
                    } elseif (strlen($filter)) {
                        $res[] = "{$model}.{$param}:{$filter}";
                    }
                }
            } elseif (strlen($v)) {
                $res[] = $this->modelClass . ".{$k}:{$v}";
            }
        }
        if (!empty($res)) {
            $passed = !empty($this->request->params['pass']) ? '/' . implode('/', $this->request->params['pass']) : '';
            $uri = $this->request->params['prefix'] == 'admin' ? '/admin' : '';
            $uri .= '/' . $this->request->controller . '/' . str_replace('admin_', '', $this->request->action) . $passed . '/' . implode('/', $res);
            $this->redirect($uri);
        }
    }

    /**
     * merges named filter parameters into paginate conditions to filter results
     */
    public function namedFilters() {
        $removeParams = array('page', 'sort', 'direction');
        if (!empty($this->request->named)) {
            $named['conditions'] = $this->request->named;
            if (array_key_exists('page', $named['conditions'])) {
                unset($named['conditions']['page']);
            }
            foreach ($named['conditions'] as $param => $v) {
                if (in_array($param, $removeParams)) {
                    unset($named['conditions'][$param]);
                }
                if (stripos($param, '_like') !== false) {
                    unset($named['conditions'][$param]);
                    $p = str_replace('_like', ' LIKE', $param);
                    $named['conditions'][$p] = "%{$v}%";
                }
            }
            $this->paginate = array_replace_recursive($this->paginate, $named);
        }
    }


    /**
     * Sends customer email
     * @param string $mailType
     * @param array $userData
     * @return boolean
     */
    public function sendEmail($mailType, $emailTo, array $otherData = array()) {
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();
        $email->emailFormat('html')
            ->to($emailTo)
            ->from('noreply@posglassware.com')
            ->sender('noreply@posglassware.com', 'POS Glassware');
        switch ($mailType) {
            case 'account_register' :
                $email->subject('User registration on POSGlassware.com');
                $email->template('account_register');
                break;
            case 'account_approved' :
                $email->subject('Your POSGlassware.com account has been approved');
                $email->template('account_approved');
                break;
            case 'new_password' :
                $email->subject('New password for POSGlassware.com');
                $email->template('new_password');
                break;
            case 'contact_support' :
                $email->subject('Support email from POSGlassware.com');
                $email->template('contact_support');
                break;
            case 'order' :
                $email->subject('Quote/sample request from POSGlassware.com');
                $email->template('order');
                break;
            case 'order_thanks' :
                $email->subject('Your POS Glassware Request');
                $email->template('order_thanks');
                break;
        }
        //Set view variables
        $viewVars = array_merge(array('title' => $email->subject()), $otherData);
        $email->viewVars($viewVars);
        $email->helpers(array('Html','Email'));
        if (Configure::read('debug') < 2) {
            return $email->send();
        } else {
            $this->redirect('/users/preview_email/' . $mailType);
        }
        return true;
    }

    /**
     * returns parse csv text file as array
     * @param $filepath
     * @return array
     */
    public function parseCSVFile($filepath){
        foreach( str_getcsv ( file_get_contents( $filepath ), $line = "\n" ) as $row ) {
            $csv[] = str_getcsv( $row, $delim = ',', $enc = '"' );
        }
        return $csv;
    }

    public function uploadFile($tmpFile, $newName = null, $destDir = null){
        if(!$destDir) $destDir = TMP_FILES;
        if($destDir === TMP_FILES && !is_dir($destDir)){
            mkdir($destDir);
        }
        $destName = $newName ? $newName : strtolower($tmpFile['name']);
        return move_uploaded_file($tmpFile['tmp_name'], $destDir . $destName);
    }

}
