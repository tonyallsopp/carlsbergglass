<?php
$elem = $this->requestAction("/cms_elements/get/{$name}");
if(isset($elem['CmsElement']['content'])) echo h($elem['CmsElement']['content']);
?>