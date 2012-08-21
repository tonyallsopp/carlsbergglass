<!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"><!--<![endif]-->
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
        <?php echo $title_for_layout; ?> | POS Glassware | Carlsberg Group
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('style');
		echo $this->fetch('meta');
        $initScript = 'document.getElementsByTagName("html")[0].setAttribute("class", "js-on");var webroot = "' . $this->webroot . '";';
        echo $this->Html->scriptBlock($initScript);
		echo $this->fetch('css');

	?>
    <!--[if lt IE 9]>
    <?php echo $this->Html->script('ie9');?>
    <![endif]-->
</head>
<body class="main">
<span id="group-logo">Carlsberg Group</span>
	<div id="container">
        <section id="content">
            <header><h1>POS Glassware</h1></header>
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>

            <footer id="main-footer">
                <p>
                    We are making changes to our privacy policy. Our new privacy policy explains how cookies are used on this website.<br/>
                    Click here to view our new <?php echo $this->Html->link('privacy policy','/privacy_policy');?>.
                </p>
            </footer>
        </section>


	</div>
	<?php echo $this->element('sql_dump'); ?>
    <?php echo $this->Html->script(array('jquery-1.7.2.min','jquery.validate.min','app'));?>
</body>
</html>
