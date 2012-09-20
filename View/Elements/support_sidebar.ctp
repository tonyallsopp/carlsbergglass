<aside class="col col-2" id="support-side">
    <h2><?php echo $this->element('cms_content',array('name'=>'support_desk_title'));?></h2>
    <?php echo $this->element('cms_content',array('name'=>'support_desk_text','para'=>true));?>
    <h2><?php echo $this->element('cms_content',array('name'=>'support_phone_title'));?></h2>
    <p id="support-phone"><?php echo $this->element('cms_content',array('name'=>'support_phone_number'));?></p>
</aside>