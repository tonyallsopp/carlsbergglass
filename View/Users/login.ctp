<div id="login-form">
    <?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('User');
    echo $this->Form->input('email',array('label'=>false,'placeholder'=>'EMAIL'));
    echo $this->Form->input('password',array('label'=>false,'placeholder'=>'PASSWORD'));
    ?>
    <div class="form-actions">
        <div class="privacy">
            <?php echo $this->Form->input('agree',array('label'=>false,'type'=>'checkbox'));?>
            <label for="UserAgree">By checking this box you are accepting our new privacy policy and our use of cookies.</label>
        </div>
    <?php
    echo $this->Form->end('>');
    ?>
    </div>
    <div class="form-options">
        <?php echo $this->Html->link('Request an account','/users/register'); ?> |
        <?php echo $this->Html->link('Forgot your password?','/users/forgot_password'); ?>
    </div>
</div>