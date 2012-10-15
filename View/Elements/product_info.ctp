<?php $confirm = isset($confirm) ? $confirm : false;  ?>
<table cellpadding="0" cellspacing="0" class="product-info">
    <thead>
    <tr>
        <th colspan="2" class="first last">Product Information</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Product Description</td>
        <td class="prodinfo-name last"><?php echo h($unit['name']); ?></td>
    </tr>
    <?php if($unit['classification']):?>
    <tr>
        <td>Classification</td>
        <td class="prodinfo-classification last"><?php echo h($unit['classification']); ?></td>
    </tr>
    <?php endif;?>

    <tr>
    <?php if($productGroup['Category']['section'] == 'branded'):?>
        <td>Brand</td>
        <?php else:?>
        <td>Category</td>
        <?php endif;?>
        <td class="last"><?php echo $productGroup['Category']['name'];?></td>
    </tr>
    <tr>
        <td>Capacity</td>
        <td class="prodinfo-capacity last"><?php echo h($unit['capacity']); ?></td>
    </tr>
    <?php if($unit['height']):?>
    <tr>
        <td>Hieght</td>
        <td class="prodinfo-height last"><?php echo h($unit['height']); ?>mm</td>
    </tr>
        <?php endif;?>
    <?php if($unit['max_diameter']):?>
    <tr>
        <td>Maximum Diameter</td>
        <td class="prodinfo-max_diameter last"><?php echo h($unit['max_diameter']); ?>mm</td>
    </tr>
        <?php endif;?>
    <tr>
        <td>Primary Packaging</td>
        <td class="prodinfo-packaging last"><?php echo h($unit['packaging']); ?></td>
    </tr>
    <tr>
        <td>FCA Location</td>
        <td class="prodinfo-fca_location last"><?php echo h($unit['fca_location']); ?></td>
    </tr>
    <tr>
        <td>FCA Unit Price (1 piece in EUR)</td>
        <td class="prodinfo-price last"><?php echo h($unit['price']); ?></td>
    </tr>
    <tr>
        <td>Pallet Unit 90 x 120 x 120 (in pieces)</td>
        <td class="prodinfo-pallet_unit last"><?php echo h($unit['pallet_unit']); ?></td>
    </tr>
    <tr>
        <td>Full Trailer Load 66 Pallet (in pieces)</td>
        <td class="prodinfo-trailer_load last"><?php echo h($unit['trailer_load']); ?></td>
    </tr>
    <tr>
        <td>HS Code</td>
        <td class="prodinfo-hs_code last"><?php echo h($unit['hs_code']); ?></td>
    </tr>
    <tr>
        <td>Country of Origin</td>
        <td class="prodinfo-origin last"><?php echo h($unit['origin']); ?></td>
    </tr>
    <?php if($unit['misc_1_label'] && $unit['misc_1_value']):?>
    <tr>
        <td class="prodinfo-misc_1_label"><?php echo h($unit['misc_1_label']); ?></td>
        <td class="prodinfo-misc_1_value last"><?php echo h($unit['misc_1_value']); ?></td>
    </tr>
        <?php endif;?>
    <?php if($unit['misc_2_label'] && $unit['misc_2_value']):?>
    <tr>
        <td class="prodinfo-misc_2_label"><?php echo h($unit['misc_2_label']); ?></td>
        <td class="prodinfo-misc_2_value last"><?php echo h($unit['misc_2_value']); ?></td>
    </tr>
        <?php endif;?>
    <?php if($unit['misc_3_label'] && $unit['misc_3_value']):?>
    <tr>
        <td class="prodinfo-misc_3_label"><?php echo h($unit['misc_3_label']); ?></td>
        <td class="prodinfo-misc_3_value last"><?php echo h($unit['misc_3_value']); ?></td>
    </tr>
        <?php endif;?>
    </tbody>
</table>