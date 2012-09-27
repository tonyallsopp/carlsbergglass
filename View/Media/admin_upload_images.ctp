<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Upload Images</h1>
        </div>
        <div class="col-2 col">
        </div>
    </div>
</header>
<div id="content-inner">
<?php echo $this->Form->create('Media',array('type'=>'file')); ?>
	<?php
    echo $this->Uploadify->file('img_file','img_file', '/admin/media/ajax_image_upload');
	?>
<?php echo $this->Form->end(); ?>
<ul id="product_images"></ul>
    <p><?php echo $this->Html->link('< Back', array('action' => 'images')); ?></p>
</div>
