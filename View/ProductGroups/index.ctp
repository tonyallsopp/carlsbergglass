<div id="content-inner">
    <ul class="branded-products">


        <?php
        foreach ($productGroups as $productGroup): ?>
            <li>
                <div class="prod-img"><img src="http://placehold.it/140x180"></div>
                <h3><?php echo h($productGroup['ProductGroup']['name']); ?>&nbsp;</h3>

                <p>
                    <?php echo $this->Html->link($productGroup['ProductGroup']['name'], "/branded_glassware/{$productGroup['ProductGroup']['slug']}"); ?>
                </p>
            </li>
            <?php endforeach; ?>
    </ul>

    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>    </p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>
