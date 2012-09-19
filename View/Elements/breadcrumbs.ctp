<nav id="breadcrumbs">
    <ul>
        <?php
        if(!$admin){
            echo "<li class=\"home\"><span>" . $this->Html->link('Home','/',array('title'=>'Home')) . '</span></li>';
        } else {
            echo "<li class=\"home\"><span>" . $this->Html->link('Admin Home','/admin/',array('title'=>'Home')) . '</span></li>';
        }

        foreach($elements as $label => $url){
            echo "<li><span>" . $this->Html->link($label,$url,array('title'=>$label)) . '</span></li>';
        }
        ?>
    </ul>
</nav>