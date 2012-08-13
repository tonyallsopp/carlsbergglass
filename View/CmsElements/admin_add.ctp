<div class="cmsElements form">
<?php echo $this->Form->create('CmsElement'); ?>
	<fieldset>
		<legend><?php echo __('Add Cms Element'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('content');
		echo $this->Form->input('type');
		echo $this->Form->input('display_order');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cms Elements'), array('action' => 'index')); ?></li>
	</ul>
</div>
