<div class="product-details branded">
    <header class="page-header">
        <div class="inner">
            <div class="col-1 col">
                <h1>Manage Glassware</h1>
            </div>
            <div class="col-2 col">
            </div>
        </div>
    </header>
    <div id="content-inner">
        <section>
            <h2>All Glassware</h2>
            <p>Upload the master product spreadsheet</p>
            <?php echo $this->Html->link('Upload Master Spreadsheet','/admin/product_groups/upload_csv',array('class'=>'btn-details'));?>
        </section>
        <section>
            <h2>Custom Glassware</h2>
            <p>Upload the custom glassware option sheet</p>
            <?php echo $this->Html->link('Upload Master Spreadsheet','/admin/product_groups/upload_csv',array('class'=>'btn-details'));?>
        </section>
        <section>
            <h2>Custom Glassware</h2>
            <table cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th class="first">Product</th>
                    <th>Variants</th>
                    <th class="last">Actions</th>
                </tr>

                </thead>
                <tbody>
                <?php foreach($groups as $g):?>
                <tr>
                    <td class="first"><?php echo $g['ProductGroup']['name'];?></td>
                    <td><?php echo count($g['ProductUnit']);?></td>
                    <td class="last"><?php echo $this->Html->link('Upload option sheet',"/admin/product_groups/upload_csv/options/{$g['ProductGroup']['id']}");?></td>
                </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </section>


    </div>
</div>







<!--
<div class="productGroups index">
	<h2><?php echo __('Product Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('updated'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($productGroups as $productGroup): ?>
	<tr>
		<td><?php echo h($productGroup['ProductGroup']['id']); ?>&nbsp;</td>
		<td><?php echo h($productGroup['ProductGroup']['created']); ?>&nbsp;</td>
		<td><?php echo h($productGroup['ProductGroup']['updated']); ?>&nbsp;</td>
		<td><?php echo h($productGroup['ProductGroup']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($productGroup['Category']['name'], array('controller' => 'categories', 'action' => 'view', $productGroup['Category']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $productGroup['ProductGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $productGroup['ProductGroup']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $productGroup['ProductGroup']['id']), null, __('Are you sure you want to delete # %s?', $productGroup['ProductGroup']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Product Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>

-->
