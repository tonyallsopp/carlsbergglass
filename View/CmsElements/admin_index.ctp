<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Site <?php echo $section == 'cms' ? 'Content' : 'Configs';?></h1>
        </div>
    </div>
</header>
<div id="content-inner">
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('description','Element'); ?></th>
            <th><?php echo $this->Paginator->sort('content'); ?></th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($cmsElements as $cmsElement): ?>
        <tr>
            <td><?php echo h($cmsElement['CmsElement']['description']); ?></td>
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
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cmsElement['CmsElement']['id']),array('title'=>"Edit {$cmsElement['CmsElement']['description']}")); ?>
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
