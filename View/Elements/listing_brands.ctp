<section class="listing">
    <header>
        <div class="col col-1">
            <h2>Glassware Brands</h2>
        </div>
        <div class="col col-2">

        </div>
    </header>
    <ul class="brands">
        <?php
        foreach ($listings as $cat):?>
            <li>
                <div class="logo"><img src="http://placehold.it/94x50"></div>
                <h3><?php echo h($cat['Category']['name']); ?>&nbsp;</h3>
                <?php echo $this->Html->link('Details', "/branded_glassware/index/{$cat['Category']['slug']}",array('class'=>'details','title'=>"View {$cat['Category']['name']} glassware")); ?>

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
