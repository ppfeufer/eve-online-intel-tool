<div class="dscan-result row">
    <div class="clearfix">
        <div class="col-sm-6 col-md-4 col-lg-3 clearfix">
            <header class="eve-intel-section-header">
                <h3><?php echo \__('Interesting On Grid', 'eve-online-intel-tool'); ?></h3>
            </header>
        </div>
    </div>
    <!--
    // Upwell Structures
    -->
    <div class="col-sm-6 col-md-4 col-lg-3">
        <?php
        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/structures-on-grid',[
            'title' => \__('Upwell Structures', 'eve-online-intel-tool'),
            'structures' => $intelData['dscanUpwellStructures'],
            'pluginSettings' => $pluginSettings
        ]);
        ?>
    </div>

    <!--
    // Deployables
    -->
    <div class="col-sm-6 col-md-4 col-lg-3">
        <?php
        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/structures-on-grid',[
            'title' => \__('Deployables', 'eve-online-intel-tool'),
            'structures' => $intelData['dscanDeployables'],
            'pluginSettings' => $pluginSettings
        ]);
        ?>
    </div>

    <!--
    // Starbases / Starbase Modules
    -->
    <div class="col-md-4 col-sm-6 col-lg-3">
        <?php
        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/structures-on-grid',[
            'title' => \__('POS / POS Modules', 'eve-online-intel-tool'),
            'structures' => $intelData['dscanStarbaseModules'],
            'pluginSettings' => $pluginSettings
        ]);
        ?>
    </div>

    <!--
    // Loot / Salvage
    -->
    <div class="col-md-4 col-sm-6 col-lg-3">
        <?php
//        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/structures-on-grid',[
//            'title' => \__('Loot / Salvage', 'eve-online-intel-tool'),
//            'structures' => $intelData['dscanLootsalvage'],
//            'pluginSettings' => $pluginSettings
//        ]);
        ?>
    </div>
</div>
