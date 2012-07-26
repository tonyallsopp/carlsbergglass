<div class="suppliers view">
<h2><?php  echo __('Supplier'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($supplier['Supplier']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($supplier['Supplier']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($supplier['Supplier']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($supplier['Supplier']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Supplier'), array('action' => 'edit', $supplier['Supplier']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Supplier'), array('action' => 'delete', $supplier['Supplier']['id']), null, __('Are you sure you want to delete # %s?', $supplier['Supplier']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Suppliers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplier'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Units'), array('controller' => 'product_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Unit'), array('controller' => 'product_units', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Product Units'); ?></h3>
	<?php if (!empty($supplier['ProductUnit'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Capacity'); ?></th>
		<th><?php echo __('Capacity Group'); ?></th>
		<th><?php echo __('Variant'); ?></th>
		<th><?php echo __('Image Id'); ?></th>
		<th><?php echo __('Origin'); ?></th>
		<th><?php echo __('Hs Code'); ?></th>
		<th><?php echo __('Fs Location'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Supplier Id'); ?></th>
		<th><?php echo __('Product Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($supplier['ProductUnit'] as $productUnit): ?>
		<tr>
			<td><?php echo $productUnit['id']; ?></td>
			<td><?php echo $productUnit['created']; ?></td>
			<td><?php echo $productUnit['updated']; ?></td>
			<td><?php echo $productUnit['name']; ?></td>
			<td><?php echo $productUnit['capacity']; ?></td>
			<td><?php echo $productUnit['capacity_group']; ?></td>
			<td><?php echo $productUnit['variant']; ?></td>
			<td><?php echo $productUnit['image_id']; ?></td>
			<td><?php echo $productUnit['origin']; ?></td>
			<td><?php echo $productUnit['hs_code']; ?></td>
			<td><?php echo $productUnit['fs_location']; ?></td>
			<td><?php echo $productUnit['price']; ?></td>
			<td><?php echo $productUnit['supplier_id']; ?></td>
			<td><?php echo $productUnit['product_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'product_units', 'action' => 'view', $productUnit['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'product_units', 'action' => 'edit', $productUnit['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'product_units', 'action' => 'delete', $productUnit['id']), null, __('Are you sure you want to delete # %s?', $productUnit['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Product Unit'), array('controller' => 'product_units', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
