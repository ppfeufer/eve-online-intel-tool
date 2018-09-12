<div class="eve-intel-copy-to-clipboard copy-permalink-to-clipboard">
    <ul class="nav nav-pills clearfix">
        <li role="presentation">
            <a href="<?php echo \get_post_type_archive_link('intel'); ?>"><span type="button" class="btn btn-default"><?php echo \__('New Scan', 'eve-online-intel-tool'); ?></span></a>
        </li>
        <li role="presentation">
            <span type="button" class="btn btn-default btn-copy-permalink-to-clipboard" data-clipboard-action="copy" data-clipboard-text="<?php echo \get_the_permalink(); ?>"><?php echo \__('Copy Permalink', 'eve-online-intel-tool'); ?></span>
        </li>
    </ul>
</div>
<div class="eve-intel-copy-result"></div>
