<?php echo $this->Email->htmlTextBlock("Hi {$user['first_name']},");?>
<?php echo $this->Email->htmlTextBlock("You recently requested a new password from POSGlassware.com.");?>
<?php echo $this->Email->htmlTextBlock("Your new password is: {$user['new_password']}");?>
<?php echo $this->Email->htmlTextBlock('You can now use this password to log into #a=/::POSGlassware.com=#. You can change your password on your #a=/users/account::account details=# page.');?>
<?php echo $this->Email->htmlTextBlock("Regards,");?>
<?php echo $this->Email->htmlTextBlock("- Carlsberg Group POS Glassware,",'font-weight:bold');?>




