<span class="eve-intel-corporation-information-wrapper">
    <span class="eve-intel-corporation-name-wrapper">
        <?php echo $data['corporationName']; ?>
    </span>
    <span class="eve-intel-corporation-links-wrapper">
        <small><a class="eve-intel-information-link" href="https://evemaps.dotlan.net/corp/<?php echo \str_replace(' ', '_', $data['corporationName']); ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/corporation/<?php echo $data['corporationID']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
    </span>
</span>
