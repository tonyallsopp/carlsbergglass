<?php
echo $this->Form->create('ProductGroup', array('type' => 'file'));
echo $this->Form->file('csv');
echo $this->Form->end('Upload');
?>