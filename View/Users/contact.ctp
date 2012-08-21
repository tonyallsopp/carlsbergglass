<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Support</h1>
        </div>
    </div>
</header>
<div id="content-inner" class="split">
    <section class="col col-1">
        <h2>Email Support</h2>
        <?php echo $this->Form->create('User');?>
        <?php echo $this->Form->input('Name');?>
        <?php echo $this->Form->input('Email');?>
        <?php echo $this->Form->input('Telephone');?>
        <?php echo $this->Form->input('Message',array('type'=>'textarea'));?>
        <?php echo $this->Form->end('Send Message');?>

    </section>
    <aside class="col col-2">
        <h3>Support Desk</h3>
        <p><?php //echo $this->element('cms_content',array('name'=>'support_tel','para'=>true));?></p>
        <h3>Telephone support</h3>
        <p><?php echo $this->element('cms_content',array('name'=>'support_tel'));?></p>
    </aside>
</div>