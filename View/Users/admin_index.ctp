<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>User Manager</h1>
        </div>
        <div class="col-2 col">
            <div class="col-1 col">
                <?php echo $this->Html->link('New User', array('action' => 'add'),array('class'=>'btn-details')); ?>
            </div>
            <div class="col-2 col">

            </div>
        </div>
    </div>
</header>
<div id="content-inner">
	<table cellpadding="0" cellspacing="0" class="sortable">
        <thead>
	<tr>
			<th><?php echo $this->Paginator->sort('first_name','Name'); ?></th>
			<th><?php echo $this->Paginator->sort('email','Email Address'); ?></th>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th><?php echo $this->Paginator->sort('role','User Level'); ?></th>
            <th><?php echo $this->Paginator->sort('last_login'); ?></th>
			<th class="actions">Action</th>
	</tr>
        </thead>
        <tbody>
	<?php
	foreach ($users as $user): ?>
	<tr>
		<td class="first"><?php echo h($user['User']['full_name']); ?></td>
		<td><a href="mailto:<?php echo h($user['User']['email']); ?>" title="Send email to <?php echo h($user['User']['email']); ?>"><?php echo h($user['User']['email']); ?></a></td>
		<td><?php echo h($user['User']['country']); ?></td>
		<td><?php echo $userRoles[$user['User']['role']]; ?></td>
        <td><?php echo $this->Time->format('d/m/Y H:i',$user['User']['last_login']); ?></td>
		<td class="actions last">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']),array('title'=>"Edit {$user['User']['full_name']}")); ?> |
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('title'=>"Delete {$user['User']['full_name']}"), __('Are you sure you want to permanently delete %s?', $user['User']['full_name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
        </tbody>
	</table>

	<div class="paging">
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}')
            ));
            ?>	</p>
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
