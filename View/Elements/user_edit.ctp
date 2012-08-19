<?php
$register = isset($register) ? $register : false;
?>
<?php
if($admin && (!isset($this->data['User']['approved']) || !$this->data['User']['approved'])){
    echo '<p>This account is awaiting approval: ' . $this->Html->link('approve account',"/admin/users/approve/{$this->data['User']['id']}",array('title'=>'Approve this account'),'Are you sure you want to approve this account?')  . '</p>';
}
?>
<?php echo $this->Form->create('User'); ?>
<fieldset>
    <?php
    echo $this->Form->input('id');
    $opts = array('class'=>'required');
    if($register){
        $opts['label'] = false;
        $opts['placeholder'] = 'FIRST NAME';
    }
    echo $this->Form->input('first_name',$opts);
    if($register) $opts['placeholder'] = 'LAST NAME';
    echo $this->Form->input('last_name',$opts);
    if($register) $opts['placeholder'] = 'EMAIL ADDRESS';
    echo $this->Form->input('email',$opts);
    if($register){
        echo $this->Form->input('confirm_email',$opts);
        if($register) $opts['placeholder'] = 'CONFIRM EMAIL';
    }
    if($register) $opts['placeholder'] = 'TELEPHONE';
    echo $this->Form->input('telephone',$opts);
    if($register) $opts['placeholder'] = 'COMPANY';
    echo $this->Form->input('company',$opts);
    if($register) $opts['placeholder'] = 'JOB TITLE';
    echo $this->Form->input('job_title',$opts);
    if($register) $opts['placeholder'] = 'COUNTRY';
    echo $this->Form->input('country',$opts);
    if(!$register){
        echo $this->Form->input('new_password',array('type'=>'password','placeholder'=>'Password','value'=>'',array('class'=>'required')));
        echo $this->Form->input('confirm_password',array('label'=>false,'type'=>'password','class'=>'no-label','placeholder'=>'Confirm new password','value'=>'',array('class'=>'required')));
    }
    if($admin){
        echo $this->Form->input('role',array('options'=>$roles));
        echo $this->Form->input('enabled');
    }
    echo $this->Form->hidden('approved');
    ?>
</fieldset>
<?php
$btnLabel = $admin ? 'Update User' : 'Update Account';
$btnLabel = !isset($this->data['User']['id']) ? 'Add User' : $btnLabel;#
$btnLabel = $register ? 'Register' : $btnLabel;
$cancelLink = $admin ? '/admin' : '/';
?>
<div class="form-actions">
<?php echo $this->Form->end($btnLabel); ?>
<?php if(!$register) echo $this->Html->link('Cancel', $cancelLink); ?>
</div>
