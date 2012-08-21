<?php $class = $custom ? 'custom' : 'branded';?>
<div class="product-details <?php echo $class;?>">
    <header class="page-header">
        <div class="inner">
            <div class="col-1 col">
            <?php echo $this->Html->link('&laquo; Back to glassware',$referrer,array('escape'=>false, 'class'=>'back'));?>
            <h1><?php  echo h($productGroup['ProductGroup']['name']); ?></h1>
                <dl>
                    <dt>Sizes Available:</dt>
                    <dd><?php echo implode(', ', $productSizes)?></dd>
                </dl>
            </div>
            <div class="col-2 col prod-img">
                <img src="http://placehold.it/220x230">
            </div>
        </div>
    </header>
    <div id="content-inner">
        <div class="col col-1">
            <?php
            if($custom){
                echo $this->element('product_options_custom');
            } else {
                echo $this->element('product_options_branded');
            }
            ?>

            <?php echo $this->element('product_info');?>
        </div>
        <div class="col col-2">
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
    </div>
</div>



