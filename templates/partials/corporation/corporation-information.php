<span class="eve-intel-corporation-information-wrapper">
    <span class="eve-intel-corporation-name-wrapper">
        <?php echo $data['corporationName']; ?>
    </span>

    <span class="eve-intel-corporation-links-wrapper">
        <small>
        <?php
            /**
             * See if we have a NPC corp or a player corp
             *
             * @see https://gist.github.com/a-tal/5ff5199fdbeb745b77cb633b7f4400bb
             */
            if((1000000 <= $data['corporationID']) && $data['corporationID'] <= 2000000) {
                echo \__('(NPC Corp)', 'eve-online-intel-tool');
            } else {
                ?>
                <a class="eve-intel-information-link" href="https://evemaps.dotlan.net/corp/<?php echo \str_replace(' ', '_', $data['corporationName']); ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/corporation/<?php echo $data['corporationID']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>
                <?php
            }
            ?>
        </small>
    </span>
</span>
