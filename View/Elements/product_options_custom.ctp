<section class="options">
    <h2>Configure your glassware</h2>
    <p>
        Please specify your parameters. Production information on your selection will be displayed below.
    </p>
    <?php
    echo $this->Form->input('ProductGroup.size',array('options'=>$productSizes));
    echo $this->Form->input('OrderItem.0.qty',array('default'=>$currentUnit['pallet_unit']));
    echo $this->Form->input('OrderItem.0.colours',array('options'=>$colours, 'label'=>'Number of colours'));
    foreach($productGroup['CustomOption'] as $i=>$opt){
        echo $this->Form->hidden("OrderItemOption.{$i}.name",array('value'=>$opt['name']));

        if($opt['multiplier']){
            $label = "{$opt['name']} (in {$opt['multiplier']})";
            echo $this->Form->input("OrderItemOption.{$i}.value",array('type'=>'text', 'label'=>$label, 'class'=>'custom_option'));
        } else {
            $label = $opt['name'];
            $label .= $opt['info'] ? " ({$opt['info']})" : '';
            echo $this->Form->input("OrderItemOption.{$i}.value",array('type'=>'checkbox', 'label'=>$opt['name'], 'class'=>'custom_option'));
        }

    }
    echo $this->Form->hidden('ProductGroup.slug',array('value'=>$productGroup['ProductGroup']['slug']));
    ?>


</section>
<section>
    <?php echo $this->element('product_info',array('unit'=>$currentUnit));?>
</section>


