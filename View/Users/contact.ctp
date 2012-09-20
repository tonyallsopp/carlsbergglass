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
        <?php echo $this->Form->input('name');?>
        <?php echo $this->Form->input('email');?>
        <?php echo $this->Form->input('telephone');?>
        <?php echo $this->Form->input('message',array('type'=>'textarea'));?>
        <?php echo $this->Form->end('Send Message');?>

    </section>
    <?php echo $this->element('support_sidebar');?>
</div>