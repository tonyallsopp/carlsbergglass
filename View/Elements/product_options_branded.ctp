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