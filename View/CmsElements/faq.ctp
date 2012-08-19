<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Support</h1>
        </div>
    </div>
</header>
<div id="content-inner" class="split">
    <section class="col col-1">
        <?php echo $this->Html->link('&laquo; Back to support home','/support',array('escape'=>false,'class'=>'back'));?>
        <h3><?php echo h($faq['CmsElement']['content']);?></h3>
        <p><?php echo h($faq['ChildElement']['content']);?></p>
    </section>
    <aside class="col col-2">
        <p>Somethign</p>
    </aside>
</div>
