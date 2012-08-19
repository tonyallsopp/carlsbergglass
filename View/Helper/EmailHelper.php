<?php
App::uses('AppHelper', 'View/Helper');


class EmailHelper extends AppHelper {

    public $helpers = array('Html');

    public function htmlTextBlock($content,$styles = '') {
        $baseStyles = 'padding: 0 20px 10px; color: #333; font-size: 14px; font-family: Arial,Helvetica,sans-serif; line-height: 20px;';
        $baseStyles .= $styles;
        $res = '<tr><td class="content-copy" valign="top" style="' . $baseStyles . '">';
        $res .= $this->formatLinks($content);
        $res .= '</td></tr>';
        return $res;
    }

    public function formatLinks($content){
        // link format = #a=link/url::Link Text=#
        $linkCount = substr_count($content, '#a=');
        $link = 1;
        $pos = 0;
        while ($link <= $linkCount) {
            $start = stripos($content,'#a=',$pos) +3;
            $end = stripos($content,'=#',$pos);
            //format the link
            $linkArray = explode('::',substr($content,$start,$end - $start));
            $htmlLink = $this->Html->link($linkArray[1],$this->Html->url($linkArray[0], true),array('style'=>"color: #88BF45; text-decoration: none;"));
            $content = substr_replace ( $content , $htmlLink , $start -3, ($end +2) - ($start -3) );
            $pos = $end +2;
            $link++;
        }
        return $content;
    }

}
