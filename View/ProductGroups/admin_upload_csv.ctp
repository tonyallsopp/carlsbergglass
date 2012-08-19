<div class="product-details branded">
    <header class="page-header">
        <div class="inner">
            <div class="col-1 col">
                <h1>Upload <?php echo $sheetType;?> CSV File</h1>
            </div>
            <div class="col-2 col">
            </div>
        </div>
    </header>
    <div id="content-inner">
        <?php if($sheetType == 'Options'):?>
        <h2>Options sheet for <?php echo $group['ProductGroup']['name'];?></h2>
        <?php else:?>
        <h2>Master product sheet</h2>
        <?php endif;?>

        <?php
        echo $this->Form->create('ProductGroup', array('type' => 'file'));
        if($groupId)  echo $this->Form->hidden('id',array('value'=>$groupId));
        echo $this->Form->file('csv');
        echo $this->Form->end('Upload');
        ?>
        <p>
            <?php if($filename) echo $this->Html->link("Import sheet","/admin/product_groups/import_csv/{$sheetType}/{$filename}/{$groupId}");?>
        </p>

    </div>
</div>
