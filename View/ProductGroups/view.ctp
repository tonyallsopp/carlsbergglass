<div class="product-details branded">
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
            <div class="col options">
            <?php
            echo $this->Form->create('ProductGroup',array('url'=>"/product_groups/change_options/{$productGroup['ProductGroup']['slug']}"));
            echo $this->Form->input('version',array('options'=>$productVersions,'value'=>$selectedVersion));
            echo $this->Form->input('size',array('options'=>$productSizes,'value'=>$selectedSize));
            echo $this->Form->hidden('slug',array('value'=>$productGroup['ProductGroup']['slug']));
            echo $this->Form->end('Update');
            ?>
            </div>
            <p class="col options">
                Choose your options to update the product info below
            </p>
            <table cellpadding="0" cellspacing="0" class="product-info">
                <thead>
                <tr>
                    <th colspan="2" class="first last">Product Information</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Product Description</td>
                    <td class="prodinfo-name last"><?php echo h($currentUnit['name']); ?></td>
                </tr>
                <tr>
                    <td>Country of Origin</td>
                    <td class="prodinfo-origin last"><?php echo h($currentUnit['origin']); ?></td>
                </tr>
                <tr>
                    <td>Primary Packaging</td>
                    <td class="prodinfo-packaging last"><?php echo h($currentUnit['packaging']); ?></td>
                </tr>
                <tr>
                    <td>Pallet Unit 90 x 120 x 120 (in pieces)</td>
                    <td class="prodinfo-pallet_unit last"><?php echo h($currentUnit['pallet_unit']); ?></td>
                </tr>
                <tr>
                    <td>Full Trailer Load 66 Pallet (in pieces)</td>
                    <td class="prodinfo-trailer_load last"><?php echo h($currentUnit['trailer_load']); ?></td>
                </tr>
                <tr>
                    <td>FCA Location</td>
                    <td class="prodinfo-fca_location last"><?php echo h($currentUnit['fca_location']); ?></td>
                </tr>
                <tr>
                    <td>FCA Unit Price (1 piece in EUR)</td>
                    <td class="prodinfo-price last"><?php echo h($currentUnit['price']); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col col-2">
            <section class="price">
                <h2>Price</h2>
                <p>&euro;<?php echo h($currentUnit['price']); ?> / unit</p>
            </section>
            <section class="order-info">
                <h2>To order this product</h2>
                <p>
                    This product can be ordered via the Carlsberg POS e-shop. Click the link below to go directly to the ordering page for this product.
                </p>
                <?php echo $this->Html->link('Order from e-shop','https://pos.carlsberggroup.com/sap(bD1kZSZjPTEwMA==)/bc/bsp/sap/zw_shop/cgp_main.do',array('class'=>'btn-details'));?>
            </section>

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
                        <?php echo $this->Html->link('Download POS Glassware manual',"/files/manual/pos_manual.pdf",array('target'=>'_blank'));?>
                    </li>
                </ul>
            </section>



        </div>
    </div>
</div>



