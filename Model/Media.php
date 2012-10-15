<?php
App::uses('AppModel', 'Model');
/**
 * Media Model
 *
 */
class Media extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
			),
		),
		'filename' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
			),
		),
        'file' => array(
            'validSize' => array(
                'rule' => array('validSize'),
                'message' => 'File is too large (max 10mb)',
            ),
            'hasContents' => array(
                'rule' => array('notZeroBytes'),
                'message' => 'File is empty (zero bytes)',
            ),
            'validType' => array(
                'rule' => array('validFileType'),
                'message' => 'Invalid file type',
            ),
        ),
	);

    public $imageExtensions = array('jpg','jpeg','png','gif','bmp');

    public $validateFile = array(
        //'size' => 4194304, // 4meg
        'size' => 10485760, // 10meg
        'type' => 'jpg,jpeg,pjpeg,x-png,png,gif'
    );
    public $imageDir = '';

    public $mediaTypes = array(
        'manual'=>array('name'=>'Manual','plural'=>'Manuals','dir'=>'manual','type'=>'manual','filetypes'=>array('pdf')),
        'tech'=>array('name'=>'Technical Document','plural'=>'Technical Documents','dir'=>'technical','type'=>'tech','filetypes'=>array('pdf','jpg','jpeg','png'),
            'sizes'=> array(
                'small' => array('w'=>150,'h'=>180,'suffix'=>'_s'),
            )
        ),
        'prod_img'=>array('name'=>'Product Image','plural'=>'Product Images','dir'=>'product_images','type'=>'prod_img',
            'sizes'=> array(
                'small' => array('w'=>150,'h'=>180,'suffix'=>'_s'),
                'medium' => array('w'=>190,'h'=>230,'suffix'=>'_m'),
            )
        ),
        'logo'=>array('name'=>'Logo','plural'=>'Logos','dir'=>'logo_images','type'=>'logo',
            'sizes'=>array(
                'small' => array('w'=>94,'h'=>50,'suffix'=>'_s'),
            )
        ),
        'cat_img'=>array('name'=>'Category Image','plural'=>'Category Images','dir'=>'category_images','type'=>'cat_img',
            'sizes'=> array(
                'small' => array('w'=>150,'h'=>180,'suffix'=>'_s'),
                'medium' => array('w'=>190,'h'=>230,'suffix'=>'_m'),
            )
        ),
    );

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //default image dir
        $this->setImageDir(PROD_IMG_DIR);
    }

    private function setImageDir($dir){
        $this->imageDir = $dir;
        //create the dir if not exist
        if(!is_dir($this->imageDir)){
            mkdir($this->imageDir);
        }
    }

    public function validSize($check) {
        if(!isset($this->data['Media']['file']['size'])) return false;
        $file =  $this->data['Media']['file'];
        $maxSize = (1024 * 1024) * 10; // 10 meg
        return ($file['size'] <= $maxSize);
    }

    public function notZeroBytes($check) {
        return (isset($this->data['Media']['file']['size']) && $this->data['Media']['file']['size']);
    }

    public function validFileType($check) {
        if(!isset($this->data['Media']['file']['size'])) return false;
        $file =  $this->data['Media']['file'];
        switch($this->data['Media']['type']){
            case 'manual' :
                return stripos($file['type'], 'pdf') !== false;
                break;
        }
        return false;
    }

    public function handleImageUpload($fileData, $fileName, $mediaType = 'prod_img', $resize = true) {
        if($mediaType == 'logo'){
            $this->setImageDir(LOGO_IMG_DIR);
        } elseif($mediaType == 'cat_img') {
            $this->setImageDir(CAT_IMG_DIR);
        }  elseif($mediaType == 'tech') {
            $this->setImageDir(TECH_DOC_DIR);
        } else {
            $this->setImageDir(PROD_IMG_DIR);
        }
        $imgDir = $this->imageDir;
        $res = array('success'=>1,'filename'=>$fileName);
        //Get file type
        $typeArr = explode('/', $fileData['type']);
        $fileParts = explode('.', strtolower($fileData['name']));
        $fileExt = array_pop($fileParts);
        $nameParts = explode('.', $fileName);
        array_pop($nameParts);
        $preName = implode('', $nameParts);
        //If size is provided for validation check with that size. Else compare the size with INI file
        if (($this->validateFile['size'] && $fileData['size'] > $this->validateFile['size']) || $fileData['error'] == UPLOAD_ERR_INI_SIZE) {
            $res = array('success'=>0,'error'=>'File is too large to upload');
        } elseif ($this->validateFile['type'] && (strpos($this->validateFile['type'], $fileExt) === false)) {
            //invalid file type
            $res = array('success'=>0,'error'=>'Invalid file type: (.' . $fileExt . ')');
        } else {
            //ok so far
            if ($fileData['error'] == UPLOAD_ERR_OK) {
                //Oops!! File size is zero. Error!
                if ($fileData['size'] == 0) {
                    $res = array('success'=>0,'error'=>'Zero size file found.');
                } else {
                    if (is_uploaded_file($fileData['tmp_name'])) {
                        //upload the file
                        if (!move_uploaded_file($fileData['tmp_name'], $imgDir . $fileName)) {
                            $res = array('success'=>0,'error'=>'Could not move uploaded file');
                        } else {
                            //generate smaller images?
                            if($resize){
                                $sizeArray = isset($this->mediaTypes[$mediaType]['sizes']) ? $this->mediaTypes[$mediaType]['sizes'] : array();
                                foreach($sizeArray as $k=>$v){
                                    $newName = $preName . $v['suffix'] . '.jpg';
                                    if(!$this->resize($imgDir . $fileName, $imgDir . $newName, $v['w'], $v['h'])){
                                        $res = array('success'=>0,'error'=>'Error resizing file: ' . $newName);
                                        break;
                                    }
                                }
                            }
                            //if the original image was not jpg, delete it. create jpg
                            if($fileExt != 'jpg'){
                                //convert to jpg
                                $fileName = $preName . '.jpg';
                                $gd = $this->createGdImage($imgDir . $fileName);
                                imagejpeg($gd, $imgDir . $fileName, 100);
                                imagedestroy($gd);
                                //delete non-jpg
                                $this->deleteFile($imgDir . $fileName);
                            }
                            $res['filename'] = $fileName;
                        }
                    } else {
                        $res = array('success'=>0,'error'=>'Invalid file upload');
                    }
                }
            }
        }
        return $res;
    }

    /**
     * Deletes a file, if image, delete other image sizes
     * @param $filename
     * @param $fileType
     */
    public function deleteFiles($filename, $mediaType){
        $fileParts = explode('.', $filename);
        if($mediaType == 'logo'){
            $imageDir = LOGO_IMG_DIR;
        } else {
            $imageDir = PROD_IMG_DIR;
        }
        $sizesArray = $this->mediaTypes[$mediaType]['sizes'];
        $this->deleteFile($imageDir . $filename);
        foreach($sizesArray as $k=>$v){
            $this->deleteFile($imageDir . $fileParts[0] . $v['suffix'] . '.' . $fileParts[1]);
        }
    }

    /**
     * Deletes a file from the file system
     * @param $fileName
     * @return bool
     */
    public function deleteFile($fileName) {
        if (!$fileName || !is_file($fileName)) {
            return true;
        }
        if (unlink($fileName)) {
            return true;
        }
        return false;
    }

    public function safeFilename($fileName) {
        $fileName = trim($fileName);
        if(!$fileName){
            return '';
        }
        //remove spaces etc from file name
        $fileParts = explode('.', strtolower($fileName));
        $fileExt = array_pop($fileParts);
        $preName = implode('_', $fileParts);
        $preName = $this->sluggify($preName,'_');
        //png > jpg
        if(in_array($fileExt, $this->imageExtensions)){
            $fileExt = 'jpg';
        }
        $newFileName = "{$preName}.{$fileExt}";
        return $newFileName;
    }

    private function createGdImage($imagePath){
        list( $source_image_width, $source_image_height, $source_image_type ) = getimagesize($imagePath);
        $source_gd_image = false;
        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($imagePath);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($imagePath);
                break;
        }
        if ($source_gd_image === false) {
            return false;
        }
        return $source_gd_image;
    }

    public function resize($source_image_path, $thumbnail_image_path, $width, $height, $quality = 90, $boundryMode = 'max_size') {
        list( $source_image_width, $source_image_height, $source_image_type ) = getimagesize($source_image_path);
        $source_gd_image = $this->createGdImage($source_image_path);
        if ($source_gd_image === false) {
            return false;
        }

        $thumbnail_image_width = $width;
        $thumbnail_image_height = $height;
        $source_aspect_ratio = $source_image_width / $source_image_height; // .339
        $thumbnail_aspect_ratio = $thumbnail_image_width / $thumbnail_image_height; // .83
        if($boundryMode == 'max_size'){
            // max_size will make the new image fit into the boundries either x r y, which ever is smaller
            if ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                //new image size is shorter and wider than source
                $thumbnail_image_height = (int) ( $thumbnail_image_width / $source_aspect_ratio );
            } else {
                $thumbnail_image_width = (int) ( $thumbnail_image_height * $source_aspect_ratio );
            }
        } else {
            if ($source_image_width <= $thumbnail_image_width && $source_image_height <= $thumbnail_image_height) {
                //if the image is smaller or same as new size, dont change size
                $thumbnail_image_width = $source_image_width;
                $thumbnail_image_height = $source_image_height;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                //new image size is shorter and wider than source
                $thumbnail_image_width = (int) ( $thumbnail_image_height * $source_aspect_ratio );
            } else {
                //new image size is taller and less wide than source
                $thumbnail_image_height = (int) ( $thumbnail_image_width / $source_aspect_ratio );
            }
        }
        $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
        imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
        imagejpeg($thumbnail_gd_image, $thumbnail_image_path, $quality);
        imagedestroy($source_gd_image);
        imagedestroy($thumbnail_gd_image);
        return true;
    }
}
