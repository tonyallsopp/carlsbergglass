<div class="categories view">
<h2><?php  echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($category['Category']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($category['Category']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Groups'), array('controller' => 'product_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Group'), array('controller' => 'product_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Product Groups'); ?></h3>
	<?php if (!empty($category['ProductGroup'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($category['ProductGroup'] as $productGroup): ?>
		<tr>
			<td><?php echo $productGroup['id']; ?></td>
			<td><?php echo $productGroup['created']; ?></td>
			<td><?php echo $productGroup['updated']; ?></td>
			<td><?php echo $productGroup['name']; ?></td>
			<td><?php echo $productGroup['category_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'product_groups', 'action' => 'view', $productGroup['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'product_groups', 'action' => 'edit', $productGroup['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'product_groups', 'action' => 'delete', $productGroup['id']), null, __('Are you sure you want to delete # %s?', $productGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Product Group'), array('controller' => 'product_groups', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
