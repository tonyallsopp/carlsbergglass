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
    <tr>
        <td>Country of Origin</td>
        <td class="prodinfo-origin last"><?php echo h($unit['origin']); ?></td>
    </tr>
    <tr>
        <td>Primary Packaging</td>
        <td class="prodinfo-packaging last"><?php echo h($unit['packaging']); ?></td>
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
        <td>FCA Location</td>
        <td class="prodinfo-fca_location last"><?php echo h($unit['fca_location']); ?></td>
    </tr>
    <tr>
        <td>FCA Unit Price (1 piece in EUR)</td>
        <td class="prodinfo-price last"><?php echo h($unit['price']); ?></td>
    </tr>
    </tbody>
</table>