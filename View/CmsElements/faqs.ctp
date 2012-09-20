<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Support</h1>
        </div>
    </div>
</header>
<div id="content-inner" class="split">
    <section class="col col-1 faqs">
        <?php foreach($sections as $i=>$section):
        $headerClass = $i == 0 ? 'first' : '';
        ?>
            <h2 class="<?php echo $headerClass;?>"><?php echo h($section['CmsElement']['content']);?></h2>
            <ul>
                <?php foreach($section['ChildElement'] as $faq):?>
                <li><?php echo $this->Html->link($faq['CmsElement']['content'],"/faq/{$faq['CmsElement']['name']}");?></li>
                <?php endforeach;?>
            </ul>
        <?php endforeach;?>
    </section>
    <?php echo $this->element('support_sidebar');?>
</div>
