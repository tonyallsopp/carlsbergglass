<?php
App::uses('AppHelper', 'View/Helper');


class SiteHelper extends AppHelper {

    public $helpers = array('Html');

    public function textBlock($content) {
        $contentArray = explode('\n\n', trim($content));
        $content = implode('</p><p>',$contentArray);
        $contentArray = explode('\n', $content);
        $content = implode('<br/>',$contentArray);
        return "<p>{$content}</p>";
    }

    public function productImage($filename, $size = 's', $link = null, $lightbox = false, $imageDir = 'product_images'){
        $fName = $size ? str_replace('.jpg', "_{$size}.jpg",$filename) : $filename;
        $html = '<div class="prod-img">';
        if($link){
            $class = $lightbox ? 'lightbox' : '';
            $html .= '<a style="display:block;width:100%;height:100%;background:url(' . $this->Html->url( "/files/{$imageDir}/{$fName}") . ') center center no-repeat" href="' . $this->Html->url($link) . '" class="' . $class . '"></a>';
        } else {
            $html .= '<div style="width:100%;height:100%;background:url(' . $this->Html->url("/files/{$imageDir}/{$fName}") . ') center center no-repeat"></div>';
        }
        $html .= '</div>';
        return $html;
    }

    public function imageThumb($filename, $fileType = 'prod_img', $link = null){
        $fName = str_replace('.jpg', "_s.jpg",$filename);
        $html = '';
        if($link){
            $html .= '<a href="' . $this->Html->url($link) . '">';
        }
        $dir = '/files/product_images/';
        switch($fileType){
            case 'cat_img':
                $dir = '/files/category_images/';
                break;
            case 'logo':
                $dir = '/files/logo_images/';
                break;
            case 'tech':
                $dir = '/files/technical/';
                break;
        }
        $html .= $this->Html->image($dir . $fName);
        $html .= '</a>';
        return $html;
    }



}
