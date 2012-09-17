<?php $class = $custom ? 'custom' : 'branded';?>
<div class="product-view <?php echo $class;?>">

    <div id="content-inner">

        <?php
        if($custom){
            //we send the data as an Order
            echo $this->Form->create('Order',array('url'=>"/custom_glassware/view/{$productGroup['ProductGroup']['slug']}"));
        } else {
            //we are sending to update options
            echo $this->Form->create('ProductGroup',array('url'=>"/product_groups/change_options/{$productGroup['ProductGroup']['slug']}"));
        }
        ?>
        <div class="col col-1">

            <header class="page-header">
                <div class="inner">
                    <?php echo $this->Html->link('&laquo; Back to glassware',$referrer,array('escape'=>false, 'class'=>'back'));?>
                    <h1><?php  echo h($productGroup['ProductGroup']['name']); ?></h1>
                    <dl>
                        <dt>Sizes Available:</dt>
                        <dd><?php echo implode(', ', $productSizes)?></dd>
                    </dl>

                </div>
            </header>

            <?php
            if($custom){
                echo $this->element('product_options_custom');
            } else {
                echo $this->element('product_options_branded');
            }
            ?>


        </div>
        <div class="col col-2">
            <div class=" prod-img">
                <img src="http://placehold.it/190x230">
            </div>

            <?php echo $this->element('product_side_sections');?>

            <section class="downloads">
                <h2>Downloads</h2>
                <ul>
                    <?php if($productGroup['ProductGroup']['drawing']):?>
                    <li>
                        <?php echo $this->Html->link('Download technical drawing',"/files/drawings/{$productGroup['ProductGroup']['drawing']}",array('target'=>'_blank'));?>
                    </li>
                    <?php endif;?>
                    <?php if($productGroup['ProductGroup']['image']):?>
                    <li>
                        <?php echo $this->Html->link('Download hi-res image',"/files/images/{$productGroup['ProductGroup']['drawing']}",array('target'=>'_blank'));?>
                    </li>
                    <?php endif;?>
                    <?php if($productGroup['ProductGroup']['guide']):?>
                    <li>
                        <?php echo $this->Html->link('Download cutter guide',"/files/guides/{$productGroup['ProductGroup']['guide']}",array('target'=>'_blank'));?>
                    </li>
                    <?php endif;?>
                    <li>
                        <?php echo $this->Html->link('Download POS Glassware manual',"/files/manual/pos_glassware_manual.pdf",array('target'=>'_blank'));?>
                    </li>
                </ul>
            </section>
        </div>
        <?php  echo $this->Form->end(); ?>

    </div>
</div>



