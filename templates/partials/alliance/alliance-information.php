<span class="eve-intel-alliance-information-wrapper">
    <span class="eve-intel-alliance-name-wrapper">
        <?php echo $data['allianceName']; ?>
    </span>
    <?php
    if($data['allianceID'] !== 0) {
        ?>
        <span class="eve-intel-alliance-links-wrapper">
            <small><a class="eve-intel-information-link" href="https://evemaps.dotlan.net/alliance/<?php echo \str_replace(' ', '_', $data['allianceName']); ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/alliance/<?php echo $data['allianceID']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
        </span>
        <?php
    }
    ?>
</span>
