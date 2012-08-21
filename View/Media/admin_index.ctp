<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Manage Media</h1>
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
    <section>
        <h2>Images</h2>
        <p>Manage glassware images.</p>
        <?php echo $this->Html->link('Manage Images','/admin/media/images',array('class'=>'btn-details'));?>
    </section>
    <section>
        <h2>POS Glassware Manual</h2>
        <p>Upload POS Glassware Manual. Last changed: <?php echo $this->Time->format('d M Y @H:i',$manual['Media']['updated'])?>.
            <?php if (!empty($manual) && $manual['Media']['filename']) echo $this->Html->link('View Manual',"/files/manual/{$manual['Media']['filename']}",array('target'=>'_blank'));?></p>
        <?php echo $this->Html->link('Upload Manual','/admin/media/manual',array('class'=>'btn-details'));?>
    </section>
</div>



