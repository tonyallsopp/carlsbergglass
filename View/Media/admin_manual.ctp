<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>POS Glassware Manual</h1>
        </div>
        <div class="col-2 col">
            <div class="col-1 col">
                <?php //echo $this->Html->link('New User', array('action' => 'add'),array('class'=>'btn-details')); ?>
            </div>
            <div class="col-2 col">

            </div>
        </div>
    </div>
</header>
<div id="content-inner" class="media">
    <?php echo $this->Form->create('Media',array('type'=>'file'));?>
    <?php echo $this->Form->input('file',array('type'=>'file','label'=>'PDF File'));?>
    <div class="form-actions">
        <?php echo $this->Form->end('Save Manual'); ?>
        <?php echo $this->Html->link('Cancel', '/admin/media'); ?>
    </div>
</div>



