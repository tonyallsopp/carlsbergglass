<section class="listing">
    <header>
        <div class="col col-1">
            <h2>Custom Glassware</h2>
        </div>
        <div class="col col-2">

        </div>
    </header>
    <ul class="unbranded-types">
        <?php
        foreach ($listings as $cat):?>
            <li>
                <div class="prod-img">
                    <a href="<?php echo $this->Html->url("/custom_glassware/{$cat['Category']['slug']}");?>">
                    <img src="http://placehold.it/150x180">
                    </a>
                </div>
                <?php echo $this->Html->link($cat['Category']['name'], "/custom_glassware/{$cat['Category']['slug']}",array('class'=>'btn-details')); ?>

            </li>
            <?php endforeach; ?>
    </ul>

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
</section>
