<div class="suppliers form">
<?php echo $this->Form->create('Supplier'); ?>
	<fieldset>
		<legend><?php echo __('Add Supplier'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Suppliers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Units'), array('controller' => 'product_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Unit'), array('controller' => 'product_units', 'action' => 'add')); ?> </li>
	</ul>
</div>
