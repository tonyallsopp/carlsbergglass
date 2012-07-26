<div class="productUnits index">
	<h2><?php echo __('Product Units'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('updated'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('capacity'); ?></th>
			<th><?php echo $this->Paginator->sort('capacity_group'); ?></th>
			<th><?php echo $this->Paginator->sort('variant'); ?></th>
			<th><?php echo $this->Paginator->sort('image_id'); ?></th>
			<th><?php echo $this->Paginator->sort('origin'); ?></th>
			<th><?php echo $this->Paginator->sort('hs_code'); ?></th>
			<th><?php echo $this->Paginator->sort('fs_location'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('supplier_id'); ?></th>
			<th><?php echo $this->Paginator->sort('product_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($productUnits as $productUnit): ?>
	<tr>
		<td><?php echo h($productUnit['ProductUnit']['id']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['created']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['updated']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['name']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['capacity']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['capacity_group']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['variant']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($productUnit['Image']['id'], array('controller' => 'images', 'action' => 'view', $productUnit['Image']['id'])); ?>
		</td>
		<td><?php echo h($productUnit['ProductUnit']['origin']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['hs_code']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['fs_location']); ?>&nbsp;</td>
		<td><?php echo h($productUnit['ProductUnit']['price']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($productUnit['Supplier']['name'], array('controller' => 'suppliers', 'action' => 'view', $productUnit['Supplier']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($productUnit['Product']['name'], array('controller' => 'products', 'action' => 'view', $productUnit['Product']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $productUnit['ProductUnit']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $productUnit['ProductUnit']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $productUnit['ProductUnit']['id']), null, __('Are you sure you want to delete # %s?', $productUnit['ProductUnit']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Product Unit'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Suppliers'), array('controller' => 'suppliers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
