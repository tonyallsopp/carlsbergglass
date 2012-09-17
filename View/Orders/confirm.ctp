<div class="checkout product-view">

    <div id="content-inner">

        <section class="col col-1">

            <header class="page-header">
                <div class="inner">
                    <?php echo $this->Html->link("&laquo; Back to {$order['OrderItem'][0]['name']}","/custom_glassware/view/{$productGroup['ProductGroup']['slug']}",array('escape'=>false, 'class'=>'back'));?>
                    <h1><?php echo $order['OrderItem'][0]['name'];?></h1>
                    <dl>
                        <dt>Sizes Available:</dt>
                        <dd><?php echo implode(', ', $productSizes)?></dd>
                    </dl>
                </div>
            </header>

            <?php echo $this->Form->create('Order');?>
            <?php if ($order['Order']['quote_requested']): ?>
            <article class="quote">
                <h2>Request a formal quote</h2>
                <?php echo $this->element('cms_content', array('name' => 'checkout_quote_text','para'=>true));?>
                <?php
                echo $this->Form->input('Address.email', array('label' => 'Email Address','default'=>$_user['email']));
                ?>
            </article>
            <?php endif;?>

            <?php if ($order['Order']['sample_requested']): ?>
            <article class="sample">
                <h2>Order a sample</h2>
                <?php echo $this->element('cms_content', array('name' => 'checkout_sample_text','para'=>true));?>

                <?php
                echo $this->Form->input('Address.name', array('label' => 'Contact Name','default'=>$_user['full_name']));
                echo $this->Form->input('Address.telephone', array('label' => 'Telephone','default'=>$_user['telephone']));
                echo $this->Form->input('Address.address_1');
                echo $this->Form->input('Address.address_2');
                echo $this->Form->input('Address.town', array('label' => 'Town / City'));
                echo $this->Form->input('Address.region', array('label' => 'Area / Region'));
                echo $this->Form->input('Address.postcode', array('label' => 'Post code / Zip'));
                echo $this->Form->input('Address.country',array('default'=>$_user['country'],'options'=>$countries, 'empty'=>'-- Select --'));
                ?>

            </article>
            <?php endif;?>
            <div class="form-actions">
            <?php echo $this->Form->end('Proceed');?>
            <?php echo $this->Html->link('Cancel',"/custom_glassware/view/{$productGroup['ProductGroup']['slug']}");?>
            </div>
        </section>

        <aside class="col col-2">
            <div class="prod-img">
                <img src="http://placehold.it/190x230">
            </div>
            <section class="order-info">
                <?php echo $this->element('order_item_info', array('item' => $order['OrderItem'][0]));?>
            </section>
        </aside>
    </div>

</div>