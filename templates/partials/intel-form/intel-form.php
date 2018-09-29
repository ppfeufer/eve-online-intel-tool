<?php
$textareaRows = (isset($textareaRows)) ? $textareaRows : 15;
?>

<form id="new_intel" name="new_intel" method="post" action="/<?php echo \WordPress\Plugins\EveOnlineIntelTool\Libs\PostType::getPosttypeSlug('intel'); ?>/">
    <div class="form-group">
        <textarea class="form-control" rows="<?php echo $textareaRows; ?>" id="eveIntel" name="eveIntel" placeholder="<?php echo \__('Paste here ...', 'eve-online-intel-tool'); ?>"></textarea>
    </div>

    <div class="row form-submit-area">
        <div class="col-sm-2">
            <button type="submit" class="btn btn-default" name="submit-form" disabled><?php echo \__('Submit', 'eve-online-intel-tool'); ?></button>
        </div>
        <div class="col-sm-10">
            <span class="authenticating-form">
                <span class="loaderImage"></span>
                <?php echo \__('Waiting for the system to authenticate the form ...', 'eve-online-intel-tool'); ?>
            </span>
        </div>
    </div>

    <input type="hidden" name="action" value="new_intel" />
    <?php \wp_nonce_field('eve-online-intel-tool-new-intel-form'); ?>
</form>
