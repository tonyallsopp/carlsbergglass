<header class="page-header">
    <div class="inner">
        <section class="manual">
            <div class="col col-1">
                <h1>POS Glassware Manual</h1>

                <p>Please download and read Carlsberg Group POS Glassware Manual before getting started. POSG Manual
                    has been created to help you ensuring the choice of right POS Glassware for Carlsberg Group
                    products, both in the On- and Off-trade.</p>
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