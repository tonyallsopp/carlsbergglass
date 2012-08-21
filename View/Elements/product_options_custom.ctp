<div class="options">
    <h2>Configure your glassware</h2>
    <p>
        Please specify your parameters. Production information on your selection will be displayed below.
    </p>
    <?php
    echo $this->Form->create('ProductGroup');
    echo $this->Form->input('size',array('options'=>$productSizes,'value'=>$selectedSize));
    echo $this->Form->input('OrderItem.qty',array());
    echo $this->Form->input('OrderItem.colours',array('options'=>$colours));
    foreach($productGroup['CustomOption'] as $i=>$opt){
        echo $this->Form->hidden("OrderItemOption.{$i}.name",array('value'=>$opt['name']));

        if($opt['multiplier']){
            $label = "{$opt['name']} (in {$opt['multiplier']})";
            echo $this->Form->input("OrderItemOption.{$i}.value",array('type'=>'text', 'label'=>$label));
        } else {
            $label = $opt['name'];
            $label .= $opt['info'] ? " ({$opt['info']})" : '';
            echo $this->Form->input("OrderItemOption.{$i}.value",array('type'=>'checkbox', 'label'=>$opt['name']));
        }

    }
    echo $this->Form->hidden('slug',array('value'=>$productGroup['ProductGroup']['slug']));
    echo $this->Form->end('Update');
    ?>
</div>