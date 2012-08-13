<!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en" xmlns:fb="http://ogp.me/ns/fb#"><!--<![endif]-->
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
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
<body<?php if($adminLayout) echo ' class="admin"'?>>
	<div id="container">
		<header id="main-header">
			<h1>Carlsberg Group</h1>
            <p class="current-user">Welcome<br/><?php echo $_user['full_name']?></p>
            <?php if(!$adminLayout) echo $this->Element('main_nav');?>
            <?php if($adminLayout) echo $this->Element('admin_main_nav');?>
            <?php if(!$adminLayout)echo $this->Element('admin_subnav');?>
		</header>
        <section id="content">
            <header>
                <?php echo $this->Element('breadcrumbs',array('elements'=>array('Home'=>'/','Something'=>'/product_groups')));?>
            </header>
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>

        </section>


	</div>
	<?php echo $this->element('sql_dump'); ?>
    <?php echo $this->Html->script(array('jquery-1.7.2.min','jquery.validate.min','app'));?>
</body>
</html>
