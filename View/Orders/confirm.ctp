<div class="product-details">

    <header class="page-header">
        <div class="inner">
            <div class="col-1 col">
                <h1>Glassware Configurator</h1>
            </div>
        </div>
    </header>
    <div id="content-inner" class="split">
        <section class="col col-1">
            <h2>Your order</h2>

            <?php echo $this->element('product_info', array('unit' => $order['OrderItem'][0]['ProductUnit'],'confirm'=>true));?>
        </section>
        <aside class="col col-2">
            <section class="order-info">
                <?php
                echo $this->Html->link('Send Request', '/orders/send_request/' . $order['Order']['id'], array('class' => 'btn-details'));

                ?>
            </section>
        </aside>
    </div>

</div>