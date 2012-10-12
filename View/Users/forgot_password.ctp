<div>
    <?php
    $register = isset($register) ? $register : false;
    ?>
    <?php echo $this->Form->create('User'); ?>
        <?php
        echo $this->Form->input('email',array('label'=>false,'placeholder'=>'EMAIL ADDRESS'));
        ?>
    <div class="form-actions">
        <?php echo $this->Form->end('Send new password'); ?>
    </div>

</div>