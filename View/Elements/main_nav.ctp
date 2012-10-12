<nav id="main-nav">
    <ul>
        <?php
        $currentSection = isset($breadcrumbs) && is_array($breadcrumbs) ? strtolower(array_shift(array_keys($breadcrumbs))) : '';
        $currentSection = $currentSection ? $currentSection : 'home';
        ?>
        <li<?php if($currentSection == 'home') echo ' class="current"';?>><?php echo $this->Html->link('Home','/');?></li>
        <li<?php if($currentSection == 'glassware configurator') echo ' class="current"';?>><?php echo $this->Html->link('Glassware Configurator','/custom_glassware');?></li>
        <li<?php if($currentSection == 'glassware by brand') echo ' class="current"';?>><?php echo $this->Html->link('Glassware by Brand','/glassware_brands');?></li>
        <li<?php if($currentSection == 'support') echo ' class="current"';?>><?php echo $this->Html->link('Support','/support');?></li>
        <li<?php if($currentSection == 'contact support') echo ' class="current"';?>><?php echo $this->Html->link('Contact','/contact');?></li>
    </ul>
</nav>