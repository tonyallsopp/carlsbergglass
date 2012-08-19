<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Support</h1>
        </div>
    </div>
</header>
<div id="content-inner" class="split">
    <section class="col col-1">
        <?php foreach($sections as $section):?>
            <h3><?php echo h($section['CmsElement']['content']);?></h3>
            <ul>
                <?php foreach($section['ChildElement'] as $faq):?>
                <li><?php echo $this->Html->link($faq['CmsElement']['content'],"/faq/{$faq['CmsElement']['name']}");?></li>
                <?php endforeach;?>
            </ul>
        <?php endforeach;?>
    </section>
    <aside class="col col-2">
        <h3>Support Desk</h3>
        <p><?php //echo $this->element('cms_content',array('name'=>'support_tel','para'=>true));?></p>
        <h3>Telephone support</h3>
        <p><?php echo $this->element('cms_content',array('name'=>'support_tel'));?></p>
    </aside>
</div>
