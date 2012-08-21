<div class="home">
    <?php echo $this->element('header_manual');?>
    <div id="content-inner">
        <section>
            <header>
                <h1><?php echo $this->element('cms_content', array('name' => 'welcome_to_title'));?></h1>
            </header>
            <p>
                <?php echo $this->element('cms_content', array('name' => 'welcome_to_intro'));?>
            </p>
        </section>
    </div>
</div>



