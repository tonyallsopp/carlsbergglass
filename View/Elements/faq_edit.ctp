<?php echo $this->Form->create('CmsElement'); ?>
<fieldset>
    <?php
    echo $this->Form->hidden('id');
    echo $this->Form->hidden('display_order');
    echo $this->Form->input('parent_id',array('options'=>$sections,'label'=>'Section'));
    echo $this->Form->input('content',array('type'=>'text','label'=>'Question','class'=>'ext'));
    echo $this->Form->input('ChildElement.content',array('type'=>'textarea','label'=>'Answer','class'=>'ext'));
    ?>
</fieldset>
<div class="form-actions">
    <?php
    $btnLabel = isset($this->data['CmsElement']['id']) ? 'Update FAQ' : 'Create FAQ';
    echo $this->Form->end($btnLabel);
    ?>
    <?php echo $this->Html->link('Cancel', '/admin/cms_elements/faq_index'); ?>
</div>