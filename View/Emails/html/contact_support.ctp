<?php echo $this->Email->htmlTextBlock("A Carlsberg POS Glassware user has send the following support message via the online form (" . $this->Html->link('support form','/support',false) . ")");?>
<?php echo $this->Email->htmlTextBlock("Name: {$User['name']}");?>
<?php echo $this->Email->htmlTextBlock("Email: {$User['email']}");?>
<?php echo $this->Email->htmlTextBlock("Telephone: {$User['telephone']}");?>
<?php echo $this->Email->htmlTextBlock("Message: {$User['message']}");?>




