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
        <h2>Options sheet</h2>
            <p>
                To clear and replace ALL product options, check the "Replace all options sets" box OR to replace only the options for the products in the CSV file, leave it clear.
            </p>
        <?php else: ?>
        <h2>Master product sheet</h2>
        <?php endif;?>

        <?php
        if (!$filename):
            echo $this->Form->create('ProductGroup', array('type' => 'file'));
            echo $this->Form->input('csv',array('div'=>'input file', 'type'=>'file', 'label'=>'CSV file'));
            if($sheetType == 'Options') echo $this->Form->input('replace',array( 'type'=>'checkbox', 'label'=>'Replace all option sets'));
            ?>
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
            $confirmMsg = 'Are you sure you want to import the product data?\n\nAll current product records will be overwritten.';
            if($sheetType == 'Options'){
                $confirmMsg = 'Are you sure you want to import the options data?';
            }
            echo $this->Html->link("Import data", "/admin/product_groups/import_csv/{$sheetType}/{$filename}/{$replaceAll}",array('class'=>'btn-details'),$confirmMsg);
            echo  $this->Html->link('Cancel','/admin/product_groups');
            ?>
        </div>
        <?php endif;?>


    </div>
</div>
