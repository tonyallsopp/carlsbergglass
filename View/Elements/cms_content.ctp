<?php
$elem = $this->requestAction("/cms_elements/get/{$name}");
if(isset($elem['CmsElement']['content'])){
    if(isset($para) && $para){
        echo $this->Site->textBlock($elem['CmsElement']['content']);
    } else {
        echo h($elem['CmsElement']['content']);
    }
}
?>