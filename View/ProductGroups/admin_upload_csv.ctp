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
        <?php if ($sheetType == 'Options'): ?>
        <h2>Options sheet for <?php echo $group['ProductGroup']['name'];?></h2>
        <?php else: ?>
        <h2>Master product sheet</h2>
        <?php endif;?>

        <?php
        if (!$filename):
            echo $this->Form->create('ProductGroup', array('type' => 'file'));
            if ($groupId) echo $this->Form->hidden('id', array('value' => $groupId));
            echo $this->Form->input('csv',array('div'=>'input file', 'type'=>'file', 'label'=>'CSV file'));?>
            <div class="form-actions">
                <?php  echo $this->Form->end('Upload');
                echo  $this->Html->link('Cancel','/admin/product_groups');?>
            </div>
            <?php endif;?>
        <?php if ($filename): ?>
        <h3>Import report for <?php echo $filename;?></h3>
        <ul class="import-report">
            <?php foreach ($importMessages as $m): ?>
            <li><?php echo $m;?></li>
            <?php endforeach;?>
        </ul>
        <?php if (!empty($importErrors)): ?>
            <h3>Import errors</h3>
            <ul class="import-report error">
                <?php foreach ($importErrors as $e): ?>
                <li><?php echo $e;?></li>
                <?php endforeach;?>
            </ul>
            <?php endif; ?>

        <?php endif;?>


        <?php  if (empty($importErrors) && $filename && !empty($importMessages)): ?>
        <div class="form-actions">
            <?php
            echo $this->Html->link("Import data", "/admin/product_groups/import_csv/{$sheetType}/{$filename}",array('class'=>'btn-details'),'Are you sure you want to import the data?\nAll current product records will be overwritten.');
            echo  $this->Html->link('Cancel','/admin/product_groups');
            ?>
        </div>
        <?php endif;?>


    </div>
</div>
