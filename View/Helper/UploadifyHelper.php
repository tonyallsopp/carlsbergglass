<?php
App::uses('AppHelper', 'View/Helper');

class UploadifyHelper extends AppHelper {

    public $helpers = array('Js', 'Form', 'Html', 'Session');
    public $swfPath = '/flash/uploadify.swf';
    public $cancelImgPath = '/img/layout/cancel.png';
    public $template = '';

    public function __construct($View) {
        parent::__construct($View);
        $this->template = '
            $(document).ready(function() {
              $("#%s").uploadify({
                "uploader"  : "' . $this->Html->url($this->swfPath, true) . '",
                "scriptData": %s,
                "script"    : "%s",
                "cancelImg" : "' . $this->Html->url($this->cancelImgPath) . '",
                "folder"    : "' . $this->Html->url('/files') . '",
                "auto"      : true,
                "queueID"   : "file_upload_queue",
                "removeCompleted": true,
                "multi"          : true,
                "fileExt"        : "%s",
                "fileDesc"       : "%s",
                onComplete  : function(event, queueID, fileObj, response, data) {
                    var res = $.parseJSON(response);
                    console.log(res);
                    if(res.success){
                        addUploadedImage(res.filename, res.id, res.type, res.dir);
                    } else {
                        alert("Upload error: " + response);
                    }                  
                },
                onAllComplete  : function(event,data) {
                  //alert(data.filesUploaded + " files uploaded successfully");
                },
                onError  : function(event,ID,fileObj,errorObj) {
                  alert(errorObj.type + " Error: " + errorObj.info);
                }
              });
            });
          ';

        // load the css
        echo $this->Html->css("uploadify", null, array("inline" => false));
        // load required JS
        echo $this->Html->script(array("swfobject.js","jquery.uploadify.v2.1.4.min.js"), array("inline" => false));
    }
    
    /**
     * Outputs uploadify file uploader
     * @example echo $this->Uploadify->file('picture', '/controller/upload');
     * @param type $fieldId
     * @param type $uploadUrl
     * @param type $options
     * @return type 
     */
    public function file($fieldName, $fieldId, $uploadUrl, $mediaType = 'prod_img') {

        $options['id'] = $fieldId;

        $fileExt = "*.jpg;*.gif;*.png";
        $fileDesc = "Image Files (.JPG, .GIF, .PNG)";
        if($mediaType == 'tech'){
            $fileExt = "*.*";
            $fileDesc = "Image/PDF Files (.JPG, .GIF, .PNG, .PDF)";
        }

        echo $this->Html->scriptBlock(
                sprintf(
                    $this->template,
                    $fieldId,
                    $this->Js->object(array('session_id' => session_id())),
                    $this->Html->url($uploadUrl),
                    $fileExt,
                    $fileDesc
                ), array("inline" => false));
        return $this->Form->file($fieldName, $options) . '<div id="file_upload_queue"></div>';
    }

}