<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Images</h1>
        </div>
        <div class="col-2 col">
            <div class="col-1 col">
                <?php echo $this->Html->link('Upload Images', array('action' => 'upload_images'),array('class'=>'btn-details')); ?>
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
            <th>Image</th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('filename'); ?></th>
            <th><?php echo $this->Paginator->sort('updated'); ?></th>
            <th class="actions">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($media as $media): ?>
        <tr>
            <td class="thumb"><?php echo $this->Site->productImageThumb($media['Media']['filename'], '/files/product_images/' . $media['Media']['filename']); ?></td>
            <td><?php echo h($media['Media']['name']); ?></td>
            <td><?php echo h($media['Media']['filename']); ?></td>
            <td><?php echo $this->Time->format('d/m/Y',$media['Media']['updated']); ?></td>
            <td class="actions last">
                <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $media['Media']['id']), array('title'=>"Delete {$media['Media']['filename']}"), 'Are you sure you want to permanently delete this image?'); ?>
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



