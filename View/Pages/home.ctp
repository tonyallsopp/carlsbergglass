<div class="home">
    <?php echo $this->element('header_manual');?>
    <div id="content-inner">
        <section class="col col-1">
            <header>
                <h1><?php echo $this->element('cms_content', array('name' => 'welcome_to_title'));?></h1>
            </header>
            <?php echo $this->element('cms_content', array('name' => 'welcome_to_intro','para'=>true));?>
        </section>
        <aside class="col col-2" id="hp-links">
            <?php echo $this->Html->link('Glassware Configurator','/custom_glassware');?>
            <?php echo $this->Html->link('Glassware by Brand','/glassware_brands',array('class'=>'branded'));?>
        </aside>
    </div>
</div>



