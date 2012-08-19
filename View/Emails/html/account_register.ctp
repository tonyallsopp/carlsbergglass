<?php echo $this->Email->htmlTextBlock("A customer has requested a new account on POSGlassware.com");?>
<?php echo $this->Email->htmlTextBlock("Their email is: {$user['email']}");?>
<?php echo $this->Email->htmlTextBlock("#a=/admin/users/edit/{$user['id']}::Click here=# to view their account. Click 'approve account' to activate this account and send the confirmation email.");?>


