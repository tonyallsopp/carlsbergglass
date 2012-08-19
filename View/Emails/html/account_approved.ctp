<?php echo $this->Email->htmlTextBlock("Hi {$user['first_name']},");?>
<?php echo $this->Email->htmlTextBlock("Your POSGlassware.com account has been approved and activated.");?>
<?php echo $this->Email->htmlTextBlock("Your password is: {$user['new_password']}");?>
<?php echo $this->Email->htmlTextBlock("You can now use your email address ({$user['email']}) and this password to log into #a=/::POSGlassware.com=#. You can change your account details on your #a=/users/account::account details=# page.");?>
<?php echo $this->Email->htmlTextBlock("Regards,");?>
<?php echo $this->Email->htmlTextBlock("- Carlsberg Group POS Glassware,",'font-weight:bold');?>