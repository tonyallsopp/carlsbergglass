<div class="productUnits form">
<?php echo $this->Form->create('ProductUnit'); ?>
	<fieldset>
		<legend><?php echo __('Edit Product Unit'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('capacity');
		echo $this->Form->input('capacity_group');
		echo $this->Form->input('variant');
		echo $this->Form->input('image_id');
		echo $this->Form->input('origin');
		echo $this->Form->input('hs_code');
		echo $this->Form->input('fs_location');
		echo $this->Form->input('price');
		echo $this->Form->input('supplier_id');
		echo $this->Form->input('product_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProductUnit.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ProductUnit.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Product Units'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Suppliers'), array('controller' => 'suppliers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
