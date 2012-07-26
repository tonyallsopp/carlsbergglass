<div class="productUnits view">
<h2><?php  echo __('Product Unit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Capacity'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['capacity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Capacity Group'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['capacity_group']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Variant'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['variant']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo $this->Html->link($productUnit['Image']['id'], array('controller' => 'images', 'action' => 'view', $productUnit['Image']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Origin'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['origin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hs Code'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['hs_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fs Location'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['fs_location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($productUnit['ProductUnit']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Supplier'); ?></dt>
		<dd>
			<?php echo $this->Html->link($productUnit['Supplier']['name'], array('controller' => 'suppliers', 'action' => 'view', $productUnit['Supplier']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product'); ?></dt>
		<dd>
			<?php echo $this->Html->link($productUnit['Product']['name'], array('controller' => 'products', 'action' => 'view', $productUnit['Product']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product Unit'), array('action' => 'edit', $productUnit['ProductUnit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product Unit'), array('action' => 'delete', $productUnit['ProductUnit']['id']), null, __('Are you sure you want to delete # %s?', $productUnit['ProductUnit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Units'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Unit'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Suppliers'), array('controller' => 'suppliers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
