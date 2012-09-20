<header class="page-header">
    <div class="inner">
        <div class="col-1 col">
            <h1>Edit Content</h1>
        </div>
    </div>
</header>
<div id="content-inner">
    <?php echo $this->Form->create('CmsElement'); ?>
    <fieldset>
        <?php
        $fieldType = $this->data['CmsElement']['type'] == 'block' ? 'textarea' : 'text';
        echo $this->Form->hidden('id');
        echo $this->Form->input('content',array('type'=>$fieldType,'label'=>$this->data['CmsElement']['description'],'class'=>'ext'));
        echo $this->Form->hidden('section');
        ?>
    </fieldset>
    <div class="form-actions">
    <?php echo $this->Form->end('Update Content'); ?>
        <?php echo $this->Html->link('Cancel', '/admin/cms_elements/' . $referrer); ?>
    </div>
</div>

