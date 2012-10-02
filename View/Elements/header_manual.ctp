<header class="page-header">
    <div class="inner">
        <section class="manual">
            <div class="col col-1">
                <h1><?php echo $this->element('cms_content', array('name' => 'manual_title'));?></h1>

                <?php echo $this->element('cms_content', array('name' => 'manual_text','para'=>true));?>
            </div>
            <div class="col col-2">
                <?php
                $fileSize = file_exists(MANUAL_DIR . 'pos_glassware_manual.pdf') ? filesize(MANUAL_DIR . 'pos_glassware_manual.pdf') / 1024 : 0;
                $suffix = 'kb';
                if ($fileSize > 100) {
                    $fileSize = $fileSize / 1024;
                    $suffix = 'mb';
                }
                echo $this->Html->link('Download Manual<br/><span>(' . round($fileSize, 1) . $suffix . ')</span>', '/files/manual/pos_glassware_manual.pdf', array('escape' => false, 'target' => '_blank', 'title' => 'Download the POS Glassware Manual (PDF)', 'class' => 'download-manual'));?>
            </div>

        </section>
    </div>
</header>