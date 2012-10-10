<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Upload <?php echo $mediaType['plural'];?></h1>
        </div>
        <div class="col-2 col">
        </div>
    </div>
</header>
<div id="content-inner">
    <?php if($mediaType['type'] == 'logo'):?>
    <p>
        Brand logos should be width: 94px x height: 50px. The file name must match the brand category name (e.g. "Carlsberg" logo would be named "carlsberg.jpg").
    </p>
    <?php elseif($mediaType['type'] == 'prod_img'):?>
    <p>
        Product images should be cropped before uploading. Smaller sizes images and thumbnails will be automatically produced.
    </p>
    <?php elseif($mediaType['type'] == 'tech'):?>
    <p>
        Technical files can be images (png, jpeg, gif) or PDF.
    </p>
    <?php elseif($mediaType['type'] == 'cat_img'):?>
    <p>
        Category images should be cropped before uploading. Smaller sizes images and thumbnails will be automatically produced. The file name must match the category name (e.g. "Tumblers" image would be named "tumblers.jpg").
    </p>
    <?php endif;?>
<?php echo $this->Form->create('Media',array('type'=>'file')); ?>
	<?php
    echo $this->Uploadify->file('img_file','img_file', '/admin/media/ajax_image_upload/' . $mediaType['type'], $mediaType['type']);
	?>
<?php echo $this->Form->end(); ?>
<ul id="product_images"></ul>
    <p><?php echo $this->Html->link('< Back', $backLink); ?></p>
</div>
