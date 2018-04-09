<?php
namespace Anax\View;

$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

$management = url("management");
?>

<div class="d-flex flex-row justify-content-center p-2">
    <div class="home w-75">
        <p class="h2 text-center mt-4">Kontrollpanel Management</p>
        <div class="row text-center mr-0 ml-0">
                <div class="w-50 mt-3 mb-3 col-md-<?php echo $bootstrapColWidth; ?>">
                    <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block"
                    href="<?= $management ?>/bestselling">Bästsäljande produkter</a>
                </div>
                <div class="w-50 mt-3 mb-3 col-md-<?php echo $bootstrapColWidth; ?>">
                    <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block"
                    href="<?= $management ?>/mostbought">Mest köpta produker</a>
                </div>
                <div class="w-50 mt-3 mb-3 col-md-<?php echo $bootstrapColWidth; ?>">
                    <a class="mx-auto w-75 btn btn-lg btn-primary pt-4 pb-4 btn-block"
                    href="#">Högst vinst</a>
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
