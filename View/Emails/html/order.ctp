<?php
echo $this->Email->htmlTextBlock("{$user['full_name']} ({$user['email']}) has recently placed a request on #a=/::www.posglassware.com=#");
if($order['Order']['sample_requested'] && $order['Order']['quote_requested']){
    echo $this->Email->htmlTextBlock("They have requested a formal quote and a plain sample online.");
} elseif($order['Order']['sample_requested']){
    echo $this->Email->htmlTextBlock("They have requested a plain sample online.");
} else {
    echo $this->Email->htmlTextBlock("They have requested a formal quote online.");
}

echo $this->Email->htmlTextBlock("Their specification:");
echo $this->Email->htmlTextBlock("Product: {$order['OrderItem'][0]['name']}");
echo $this->Email->htmlTextBlock("Size: {$order['OrderItem'][0]['capacity']}");
if($order['Order']['quote_requested']) echo $this->Email->htmlTextBlock("Quantity: {$order['OrderItem'][0]['qty']}");

foreach($order['OrderItem'][0]['OrderItemOption'] as $option):
    if($option['multiplier']){
        $optionVal = round($option['value'],2) . ' ' . $option['multiplier'];
    } else {
        $optionVal = $option['value'] ? 'Yes' : 'No';
    }
    echo $this->Email->htmlTextBlock("{$option['name']}: {$optionVal}");
endforeach;
echo $this->Email->htmlTextBlock("Estimated cost per unit (FCA Supplier Location, excluding VAT): {$order['OrderItem'][0]['unit_price']}");

if($order['Order']['sample_requested']){
    echo $this->Email->htmlTextBlock("Sample delivery address:");
    echo $this->Email->htmlTextBlock("{$address['name']}");
    echo $this->Email->htmlTextBlock("{$address['address_1']}");
    if($address['address_2']) echo $this->Email->htmlTextBlock("{$address['address_2']}");
    if($address['town']) echo $this->Email->htmlTextBlock("{$address['town']}");
    echo $this->Email->htmlTextBlock("{$address['region']}");
    echo $this->Email->htmlTextBlock("{$address['postcode']}");
    echo $this->Email->htmlTextBlock("{$address['country']}");
    echo $this->Email->htmlTextBlock("Telephone: {$address['telephone']}");
}
?>

