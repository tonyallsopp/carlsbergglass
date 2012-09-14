<section class="listing">
    <header>
        <div class="col col-1">
            <h2>Glassware: <?php echo $currentBrand;?></h2>
        </div>
        <div class="col col-2">

        </div>
    </header>
    <ul class="branded-products">
        <?php
        foreach ($listings as $productGroup):?>
            <li>
                <div class="prod-img"><img src="http://placehold.it/150x180"></div>
                <h3><?php echo h($productGroup['ProductGroup']['name']); ?>&nbsp;</h3>

                <p>
                    From &euro;<?php echo h($productGroup['ProductGroup']['base_price']); ?> /unit
                </p>
                <?php echo $this->Html->link('Details', "/branded_glassware/{$productGroup['ProductGroup']['slug']}", array('class' => 'btn-details')); ?>

            </li>
            <?php endforeach; ?>
    </ul>
    <?php /*
    <div class="paging">
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}')
            ));
            ?>    </p>
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
    */?>
</section>
