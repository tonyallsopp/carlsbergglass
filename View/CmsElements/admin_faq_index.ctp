<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Site FAQs</h1>
        </div>
        <div class="col-2 col">
            <div class="col-1 col">
                <?php echo $this->Html->link('New FAQ', array('action' => 'add_faq'),array('class'=>'btn-details')); ?>
            </div>
            <div class="col-2 col">

            </div>
        </div>
    </div>
</header>
<div id="content-inner">
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('ParentElement.content','Section'); ?></th>
            <th><?php echo $this->Paginator->sort('content','Question'); ?></th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($cmsElements as $cmsElement): ?>
        <tr>
            <td><?php echo h($cmsElement['ParentElement']['content']); ?></td>
            <td>
                <?php
                if($cmsElement['CmsElement']['content']){
                    echo h(substr($cmsElement['CmsElement']['content'],0,60));
                    if(strlen($cmsElement['CmsElement']['content']) > 60) echo ' ...';
                } else {
                    echo '&nbsp;';
                }
                ?>
            </td>
            <td class="actions last">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit_faq', $cmsElement['CmsElement']['id']),array('title'=>"Edit {$cmsElement['CmsElement']['content']}")); ?> |
                <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $cmsElement['CmsElement']['id']),array('title'=>"Delete {$cmsElement['CmsElement']['content']}"),'Are you sure you want to permanently delete this FAQ?'); ?>
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <?php if($this->Paginator->hasNext() || $this->Paginator->hasPrev()):?>
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
    <?php endif;?>
</div>
