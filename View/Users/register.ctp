<h1>Register</h1>
<div class="register">
    <?php echo $this->Form->create('User'); ?>
        <?php
        echo $this->Form->input('id');
        $opts = array('class'=>'required');
        $opts['label'] = false;
        $opts['placeholder'] = 'FIRST NAME';
        echo $this->Form->input('first_name',$opts);

        $opts['placeholder'] = 'LAST NAME';
        $opts['div'] = 'alt text input ';
        echo $this->Form->input('last_name',$opts);

        $opts['placeholder'] = 'COMPANY';
        $opts['div'] = 'text input ';
        echo $this->Form->input('company',$opts);

        $opts['placeholder'] = 'JOB TITLE';
        $opts['div'] = 'alt text input ';
        echo $this->Form->input('job_title',$opts);

        $opts['placeholder'] = 'EMAIL ADDRESS';
        $opts['div'] = 'text input ';
        echo $this->Form->input('email',$opts);

        $opts['placeholder'] = 'CONFIRM EMAIL';
        $opts['div'] = 'text input alt ';
        echo $this->Form->input('confirm_email',$opts);


        $opts['placeholder'] = 'TELEPHONE';
        $opts['div'] = 'text input ';
        echo $this->Form->input('telephone',$opts);

        $opts['placeholder'] = 'COUNTRY';
        $opts['div'] = 'select input alt ';
        echo $this->Form->input('country',$opts);
        ?>
    <div class="form-actions">
        <?php echo $this->Form->end('Register'); ?>
    </div>

</div>