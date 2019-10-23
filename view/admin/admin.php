<?php

namespace Anax\View;

$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

$admin = url("admin");
?>

<div class="d-flex flex-row justify-content-center p-2">
    <div class="home w-75 w-100-mobile">
        <p class="h2 text-center mt-4">Kontrollpanel Admin</p>
        <div class="row text-center mr-0 ml-0">
            <div class="w-50 w-100-mobile mt-3 mb-3 col-md-<?= $bootstrapColWidth; ?>">
                <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block" href="<?= $admin ?>/products?page=1">Alla produkter</a>
            </div>
            <div class="w-50 w-100-mobile mt-3 mb-3 col-md-<?= $bootstrapColWidth; ?>">
                <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block" href="<?= $admin ?>/users">Alla användare</a>
            </div>
            <div class="w-50 w-100-mobile mt-3 mb-3 col-md-<?= $bootstrapColWidth; ?>">
                <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block" href="<?= $admin ?>/orders">Alla ordrar</a>
            </div>
            <div class="w-50 w-100-mobile mt-3 mb-3 col-md-<?= $bootstrapColWidth; ?>">
                <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block" href="<?= $admin ?>/buyFemale">Köp in damprodukter</a>
            </div>
            <div class="w-50 w-100-mobile mt-3 mb-3 col-md-<?= $bootstrapColWidth; ?>">
                <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block" href="<?= $admin ?>/buyMale">Köp in herrprodukter</a>
            </div>
            <div class="w-50 w-100-mobile mt-3 mb-3 col-md-<?= $bootstrapColWidth; ?>">
                <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block" href="<?= $admin ?>/coupon/add">Lägg till kupong</a>
            </div>
        </div>
    </div>
</div>

<?php
$rowCount++;
if ($rowCount % $numOfCols == 0) {
    echo '</div><div class="row">';
}
?>
