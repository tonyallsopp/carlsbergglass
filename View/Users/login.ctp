<h1>Log In To POS Glassware</h1>
<div id="login-form">
    <?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('User');
    echo $this->Form->input('email',array('label'=>false,'placeholder'=>'EMAIL'));
    echo $this->Form->input('password',array('label'=>false,'placeholder'=>'PASSWORD'));
    ?>
    <div class="form-actions">
        <div class="form-options">
            <?php echo $this->Html->link('Request an account','/users/register'); ?> |
            <?php echo $this->Html->link('Forgot your password?','/users/forgot_password'); ?>
        </div>
    <?php
    echo $this->Form->end('Log in');
    ?>
    </div>

</div>