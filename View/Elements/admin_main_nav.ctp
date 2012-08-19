<nav id="main-nav">
    <ul>
        <li class="back">
            <a href="<?php echo $this->Html->url('/');?>"><span>Back to main site</span></a>
        </li>
        <li><?php echo $this->Html->link('Manage users','/admin/users');?></li>
        <li><?php echo $this->Html->link('Manage glassware','/admin/product_groups');?></li>
        <li><?php echo $this->Html->link('Edit site content','/admin/cms_elements');?></li>
        <li><?php echo $this->Html->link('Edit FAQs','/admin/cms_elements/faq_index');?></li>
    </ul>
</nav>