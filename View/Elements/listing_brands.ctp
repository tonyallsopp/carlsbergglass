<section class="listing">
    <header>
        <div class="col col-1">
            <h2>Glassware Brands</h2>
        </div>
        <div class="col col-2 filter">
            <?php
            echo $this->Form->create('Category',array('class'=>'filter'));
            echo $this->Form->hidden('filter_url',array('value'=>$this->Html->url('/branded_glassware/index/')));
            echo $this->Form->input('filter_slug',array('label'=>'Jump to brand','options'=>$categoryList, 'empty'=>'-- Select --'));
            echo $this->Form->end();
            ?>
        </div>
    </header>
    <ul class="brands">
        <?php
        foreach ($listings as $cat):?>
            <li>
                <div class="logo">
                    <?php echo $this->Site->imageThumb("{$cat['Category']['slug']}.jpg",'logo', "/branded_glassware/index/{$cat['Category']['slug']}"); ?>
                </div>
                <h3><?php echo $this->Html->link($cat['Category']['name'], "/branded_glassware/index/{$cat['Category']['slug']}");?></h3>
                <?php echo $this->Html->link('Details', "/branded_glassware/index/{$cat['Category']['slug']}",array('class'=>'details','title'=>"View {$cat['Category']['name']} glassware")); ?>

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
     */ ?>

</section>
