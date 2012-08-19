<html>
    <head>

        <title><?php echo $title; ?></title>

        <meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
        <style type="text/css">
            .list a {color: #cc0000; text-transform: uppercase; font-family: Verdana; font-size: 11px; text-decoration: none;}

        </style>


    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" bgcolor="#c5c5c5" leftmargin="0" style="background-image: url(<?php echo $this->Html->url('/img/email/bg.gif', true); ?>); background-color: #c5c5c5;">

        <table cellspacing="0" border="0" style="background-image: url(<?php echo $this->Html->url('/img/email/bg.gif', true); ?>); background-color: #c5c5c5;" cellpadding="0" width="100%">

            <tr>

                <td valign="top">

                    <table cellspacing="0" border="0" align="center" style="background: #fff; border-right: 1px solid #ccc; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" cellpadding="0" width="600">
                        <tr>
                            <td valign="top">
                                <!-- header -->
                                <table cellspacing="0" border="0" height="100" cellpadding="0" width="600">
                                    <tr>
                                        <td class="main-title" height="100" valign="top" width="600" colspan="2" style="background:#074518">
                                            <img src="<?php echo $this->Html->url('/img/email/email-logo.gif', true); ?>" height="100" alt="Carlsberg Group" style="border: 0;" width="600" />
                                        </td>
                                    </tr>
                                </table>
                                <!-- / header -->
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- content -->
                                <table cellspacing="0" border="0" cellpadding="0" width="600">
                                    <tr>
                                        <td class="article-title" height="45" valign="top" style="padding: 10px 20px 0 20px; font-family: Arial,Helvetica,sans-serif; font-size: 20px; font-weight: bold;" width="600" colspan="2">
                                            <?php echo $title ? $title : 'Email title placeholder'; ?>
                                        </td>
                                    </tr>

                                    <?php echo $content_for_layout; ?>
                                    
                                    <tr>
                                        <td height="20" valign="top" width="600" colspan="2">
                                            <img src="<?php echo $this->Html->url('/img/email/breaker.jpg', true); ?>" height="20" alt="" style="border: 0;" width="600" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-copy" valign="top" style="padding: 0 20px 10px; color: #333; font-size: 14px; font-family: Arial,Helvetica,sans-serif; line-height: 20px;">
                                            This is an automated email, so please don’t reply directly.  If you have any queries please email us at <a href="mailto:service@posglassware.com" style="color: #88BF45; text-decoration: none;">info@posglassware.com</a>
                                        </td>
                                    </tr>

                                </table>
                                <!--  / content -->
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="600">
                                <!-- footer -->
                                <table cellspacing="0" border="0" height="100" cellpadding="0" width="600">
                                    <tr>
                                        <td height="20" valign="top" width="600" colspan="2">
                                            <img src="<?php echo $this->Html->url('/img/email/breaker.jpg', true); ?>" height="20" alt="" style="border: 0;" width="600" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="copyright" height="50" align="center" valign="top" style="padding: 0 20px; color: #999; font-family: Verdana; font-size: 10px; line-height: 20px;" width="600" colspan="2">
                                            Use of posglassware.com is subject to our  <a href="<?php echo $this->Html->url('/terms', true); ?>" style="color: #666666;">Terms and Conditions</a> and <a href="<?php echo $this->Html->url('/privacy_policy', true); ?>" style="color: #666666;">Privacy Policy</a>.<br />
                                            posglassware.com is owned and operated by Carlsberg Group

                                        </td>
                                    </tr>
                                </table>
                                <!-- / end footer -->
                            </td>
                        </tr>
                    </table>

                </td>

            </tr>

        </table>

    </body>
</html>