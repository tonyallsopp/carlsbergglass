<h2>Your specification</h2>
<ul class="item-info">
    <li><span>Product:</span> <?php echo $item['name'];?></li>
    <li><span>Size:</span> <?php echo $item['capacity'];?></li>
    <li><span>Quantity:</span> <?php echo $item['qty'];?></li>
    <?php foreach($item['OrderItemOption'] as $option):
    if($option['multiplier']){
        $optionVal = round($option['value'],2) . ' ' . $option['multiplier'];
    } else {
        $optionVal = $option['value'] ? 'Yes' : 'No';
    }
    ?>
    <li><span><?php echo $option['name'];?>:</span> <?php echo $optionVal;?></li>
    <?php endforeach;?>
    <li><span>Cost per unit (FCA Supplier Location, excluding VAT):</span> &euro;<?php echo $item['unit_price'];?></li>
</ul>