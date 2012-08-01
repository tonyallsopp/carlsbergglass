<nav id="breadcrumbs">
    <ul>
        <?php
        foreach($elements as $label => $url){
            $class = $label == 'Home' ? 'home' : '';
            echo "<li class=\"{$class}\"><span>" . $this->Html->link($label,$url) . '</span></li>';
        }
        ?>
    </ul>
</nav>