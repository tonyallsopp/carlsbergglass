<?php $class = $custom ? 'custom' : 'branded';?>
<div class="product-view product-details <?php echo $class;?>">

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
                    <?php echo $this->Html->link('&laquo; Back to ' . $productGroup['Category']['name'],$referrer,array('escape'=>false, 'class'=>'back'));?>
                    <h1><?php  echo h($productGroup['ProductGroup']['name']); ?></h1>
                    <?php if($currentUnit['description']){
                        echo $this->Site->textBlock($currentUnit['description']);
                    } ?>
                    <dl>
                        <?php if($currentUnit['classification']):?>
                        <dt>Classification:</dt>
                        <dd><?php echo $currentUnit['classification'];?></dd>
                        <?php endif;?>

                        <?php if($productGroup['Category']['section'] == 'branded'):?>
                        <dt>Brand:</dt>
                        <?php else:?>
                        <dt>Category:</dt>
                        <?php endif;?>
                        <dd><?php echo $productGroup['Category']['name'];?></dd>

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
            <?php echo $this->Site->productImage($productGroup['ProductGroup']['image'],'m',"/files/product_images/{$productGroup['ProductGroup']['image']}", true);?>

            <?php echo $this->element('product_side_sections');?>

            <section class="downloads">
                <h2>Downloads</h2>
                <ul>
                    <?php if($productGroup['ProductGroup']['drawing']):?>
                    <li>
                        <?php echo $this->Html->link('Download technical drawing',"/files/technical/{$productGroup['ProductGroup']['drawing']}",array('target'=>'_blank'));?>
                    </li>
                    <?php endif;?>
                    <?php if($productGroup['ProductGroup']['image']):?>
                    <li>
                        <?php echo $this->Html->link('Download hi-res image',"/files/product_images/{$productGroup['ProductGroup']['image']}",array('target'=>'_blank'));?>
                    </li>
                    <?php endif;?>
                    <?php if($productGroup['ProductGroup']['guide']):?>
                    <li>
                        <?php echo $this->Html->link('Download cutter guide',"/files/technical/{$productGroup['ProductGroup']['guide']}",array('target'=>'_blank'));?>
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



