<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Support</h1>
        </div>
    </div>
</header>
<div id="content-inner" class="split">
    <section class="col col-1">
        <h2>Email Support</h2>
        <?php
        if(!isset($mailSent) || !$mailSent){
        echo $this->Form->create('User');
        echo $this->Form->input('name',array('default'=>$_user['full_name']));
        echo $this->Form->input('email',array('default'=>$_user['email']));
        echo $this->Form->input('telephone',array('default'=>$_user['telephone']));
        echo $this->Form->input('message',array('type'=>'textarea'));
        echo $this->Form->end('Send Message');
        }
        ?>
        <?php if(isset($mailSent) && $mailSent):?>
        <p>Thank you for contacting the Carlsberg Group. A member of our team will be in touch soon.</p>
        <?php endif;?>

    </section>
    <?php echo $this->element('support_sidebar');?>
</div>