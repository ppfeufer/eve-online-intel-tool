<span class="eve-intel-pilot-information-wrapper">
    <span class="eve-intel-pilot-name-wrapper">
        <?php echo $data['characterName']; ?>
    </span>
    <span class="eve-intel-pilot-links-wrapper">
        <small><a class="eve-intel-information-link" href="https://evewho.com/pilot/<?php echo \urlencode($data['characterName']); ?>" target="_blank">evewho <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/character/<?php echo $data['characterID']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
    </span>
</span>
