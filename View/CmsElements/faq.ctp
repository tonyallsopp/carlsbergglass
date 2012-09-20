<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Support</h1>
        </div>
    </div>
</header>
<div id="content-inner" class="split">
    <section class="col col-1 faq">
        <?php echo $this->Html->link('&laquo; Back to support home','/support',array('escape'=>false,'class'=>'back'));?>
        <h2><?php echo h($faq['CmsElement']['content']);?></h2>
        <p><?php echo h($faq['ChildElement']['content']);?></p>
    </section>
    <?php echo $this->element('support_sidebar');?>
</div>
