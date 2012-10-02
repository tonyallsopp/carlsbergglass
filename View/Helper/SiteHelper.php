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

    public function productImage($filename, $size = 's', $link = null, $lightbox = false){
        $fName = $size ? str_replace('.jpg', "_{$size}.jpg",$filename) : $filename;
        $html = '<div class="prod-img">';
        if($link){
            $class = $lightbox ? 'lightbox' : '';
            $html .= '<a style="display:block;width:100%;height:100%;background:url(' . $this->Html->url('/files/product_images/' . $fName) . ') center center no-repeat" href="' . $this->Html->url($link) . '" class="' . $class . '"></a>';
        } else {
            $html .= '<div style="width:100%;height:100%;background:url(' . $this->Html->url('/files/product_images/' . $fName) . ') center center no-repeat"></div>';
        }
        $html .= '</div>';
        return $html;
    }

    public function productImageThumb($filename, $link = null){
        $fName = str_replace('.jpg', "_s.jpg",$filename);
        $html = '';
        if($link){
            $html .= '<a href="' . $this->Html->url($link) . '">';
        }
        $html .= $this->Html->image('/files/product_images/' . $fName);
        $html .= '</a>';
        return $html;
    }



}
