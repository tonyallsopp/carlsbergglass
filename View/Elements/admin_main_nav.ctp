<nav id="main-nav">
    <ul>
        <li class="back">
            <a href="<?php echo $this->Html->url('/');?>"><span>Back to main site</span></a>
        </li>
        <li><?php echo $this->Html->link('Manage users','/admin/users');?></li>
        <li><?php echo $this->Html->link('Manage glassware','/admin/product_groups');?></li>
        <li><?php echo $this->Html->link('Manage site content','/admin/cms_elements');?></li>
        <li><?php echo $this->Html->link('Manage media','/admin/media');?></li>
        <li><?php echo $this->Html->link('Manage FAQs','/admin/cms_elements/faq_index');?></li>
        <li><?php echo $this->Html->link('Site Config','/admin/cms_elements/configs');?></li>
    </ul>
</nav>