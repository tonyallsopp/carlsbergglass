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

    public $validateFile = array(
        //'size' => 4194304, // 4meg
        'size' => 10485760, // 10meg
        'type' => 'jpg,jpeg,pjpeg,x-png,png,gif'
    );
    public $imageSizes = array(
        'small' => array('w'=>150,'h'=>180,'suffix'=>'_s'),
        'medium' => array('w'=>190,'h'=>228,'suffix'=>'_m'),
        //'large' => array('w'=>1024,'h'=>768,'suffix'=>'_l'),
    );
    public $imageDir = '';

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //default image dir
        $this->imageDir = PROD_IMG_DIR;
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






    public function handleImageUpload($fileData, $fileName, $resize = true) {
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
                                foreach($this->imageSizes as $k=>$v){
                                    $newName = $preName . $v['suffix'] . '.jpg';
                                    if(!$this->resize($imgDir . $fileName, $imgDir . $newName, $v['w'], $v['h'])){
                                        $res = array('success'=>0,'error'=>'Error resizing file: ' . $newName);
                                        break;
                                    }
                                }
                                //if the original image was not jpg, delete it
                                if($fileExt != 'jpg'){
                                    $this->delete_file($imgDir . $fileName);
                                }
                            }
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
    public function deleteFiles($filename, $fileType){
        $fileParts = explode('.', $filename);
        if($fileType == 'prod_img'){
            $this->deleteFile($this->imageDir . $filename);
            foreach($this->imageSizes as $k=>$v){
                $this->deleteFile($this->imageDir . $fileParts[0] . $v['suffix'] . '.' . $fileParts[1]);
            }
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
        //remove spaces etc from file name
        $fileParts = explode('.', strtolower($fileName));
        $fileExt = array_pop($fileParts);
        $preName = implode('_', $fileParts);
        $preName = $this->sluggify($preName,'_');
        $newFileName = "{$preName}.{$fileExt}";
        return $newFileName;
    }

    public function resize($source_image_path, $thumbnail_image_path, $width, $height, $quality = 90, $boundryMode = 'max_size') {
        list( $source_image_width, $source_image_height, $source_image_type ) = getimagesize($source_image_path);

        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }

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
