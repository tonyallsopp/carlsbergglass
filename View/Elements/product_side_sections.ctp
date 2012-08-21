<?php if(isset($custom) && $custom):?>
<section class="price">
    <h2>Estimated Price</h2>
    <p>&euro;<span class="prodinfo-price"><?php echo h($currentUnit['price']); ?></span> / unit</p>
</section>
<section class="order-info">
    <h2>What do you want to do next?</h2>
    <?php
    echo $this->Form->create('Order',array('url'=>'/quote/confirm','type'=>'get'));
    echo $this->Form->input('quote',array('type'=>'checkbox','label'=>'Order a plain sample'));
    echo $this->Form->input('sample',array('type'=>'checkbox','label'=>'Request a formal quote'));
    echo $this->Form->end('Proceed');
    ?>
</section>

<?php else:?>

<section class="price">
    <h2>Price</h2>
    <p>&euro;<span class="prodinfo-price"><?php echo h($currentUnit['price']); ?></span> / unit</p>
</section>
<section class="order-info">
    <h2>To order this product</h2>
    <p>
        This product can be ordered via the Carlsberg POS e-shop. Click the link below to go directly to the ordering page for this product.
    </p>
    <?php echo $this->Html->link('Order from e-shop','https://pos.carlsberggroup.com/sap(bD1kZSZjPTEwMA==)/bc/bsp/sap/zw_shop/cgp_main.do',array('class'=>'btn-details'));?>
</section>

<?php endif;?>