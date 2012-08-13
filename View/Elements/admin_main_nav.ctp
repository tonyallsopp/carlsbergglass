<nav id="main-nav">
    <ul>
        <li class="back">
            <a href="<?php echo $this->Html->url('/');?>"><span>Back to main site</span></a>
        </li>
        <li><?php echo $this->Html->link('Manage users','/admin/users');?></li>
        <li><?php echo $this->Html->link('Manage glassware','/branded_glassware/index');?></li>
        <li><?php echo $this->Html->link('Edit site content','/admin/cms_elements');?></li>
    </ul>
</nav>