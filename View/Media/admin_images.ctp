<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Images</h1>
        </div>
        <div class="col-2 col">
            <div class="col-1 col">
                <?php //echo $this->Html->link('New User', array('action' => 'add'),array('class'=>'btn-details')); ?>
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
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('updated'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('filename'); ?></th>
            <th><?php echo $this->Paginator->sort('type'); ?></th>
            <th class="actions">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($media as $media): ?>
        <tr>
            <td><?php echo h($media['Media']['id']); ?>&nbsp;</td>
            <td><?php echo h($media['Media']['created']); ?>&nbsp;</td>
            <td><?php echo h($media['Media']['updated']); ?>&nbsp;</td>
            <td><?php echo h($media['Media']['name']); ?>&nbsp;</td>
            <td><?php echo h($media['Media']['filename']); ?>&nbsp;</td>
            <td><?php echo h($media['Media']['type']); ?>&nbsp;</td>
            <td class="actions last">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $media['Media']['id']),array('title'=>"Edit {$media['Media']['name']}")); ?> |
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $media['Media']['id']), array('title'=>"Delete {$media['Media']['name']}"), __('Are you sure you want to permanently delete %s?', $media['Media']['name'])); ?>
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



