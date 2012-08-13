<div class="product-details branded">
    <header class="page-header">
        <div class="inner">
            <div class="col-1 col">
            <span class="back"><?php echo $this->Html->link('Back to bla bla','/branded_glassware');?></span>
            <h1><?php  echo h($productGroup['ProductGroup']['name']); ?></h1>
                <dl>
                    <dt>Sizes Available:</dt>
                    <dd><?php echo implode(', ', $productSizes)?></dd>
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
        <?php
        echo $this->Form->create('ProductGroup',array('url'=>"/product_groups/change_options/{$productGroup['ProductGroup']['slug']}"));
        echo $this->Form->input('version',array('options'=>$productVersions,'value'=>$selectedVersion));
        echo $this->Form->input('size',array('options'=>$productSizes,'value'=>$selectedSize));
        echo $this->Form->hidden('slug',array('value'=>$productGroup['ProductGroup']['slug']));
        echo $this->Form->end('Update');
        ?>

        <table cellpadding="0" cellspacing="0" class="product-info">
            <tr>
                <th colspan="2">Product Information</th>
            </tr>
            <tr>
                <td>Product Description</td>
                <td class="prodinfo-name"><?php echo h($currentUnit['name']); ?></td>
            </tr>
            <tr>
                <td>Country of Origin</td>
                <td class="prodinfo-origin"><?php echo h($currentUnit['origin']); ?></td>
            </tr>
            <tr>
                <td>Primary Packaging</td>
                <td class="prodinfo-packaging"><?php echo h($currentUnit['packaging']); ?></td>
            </tr>
            <tr>
                <td>Pallet Unit 90 x 120 x 120 (in pieces)</td>
                <td class="prodinfo-pallet_unit"><?php echo h($currentUnit['pallet_unit']); ?></td>
            </tr>
            <tr>
                <td>Full Trailer Load 66 Pallet (in pieces)</td>
                <td class="prodinfo-trailer_load"><?php echo h($currentUnit['trailer_load']); ?></td>
            </tr>
            <tr>
                <td>FCA Location</td>
                <td class="prodinfo-fca_location"><?php echo h($currentUnit['fca_location']); ?></td>
            </tr>
            <tr>
                <td>FCA Unit Price (1 piece in EUR)</td>
                <td class="prodinfo-price"><?php echo h($currentUnit['price']); ?></td>
            </tr>
        </table>

    </div>
</div>



