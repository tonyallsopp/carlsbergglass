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



}
