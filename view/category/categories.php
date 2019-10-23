<?php
namespace Anax\View;

$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

$productUrl = url("category");
?>

<div class="d-flex flex-row justify-content-center p-2">
    <div class="home w-75">
        <p class="h2 text-center mt-4">Damkläder</p>
        <div class="row text-center mr-0 ml-0">
            <?php foreach ($data["categoriesFemale"] as $category) : ?>
                <div class="w-50 mt-3 mb-3 col-md-<?php echo $bootstrapColWidth; ?>">
                    <a class="mx-auto w-75 w-100-mobile btn btn-lg btn-primary pt-4 pb-4 btn-block"
                    href="<?= $productUrl ?>/<?= $category->categoryID ?>"><?= $category->categoryName; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="h2 text-center mt-4">Herrkläder</p>
        <div class="row text-center mr-0 ml-0">
            <?php foreach ($data["categoriesMale"] as $category) : ?>
                <div class="w-50 mt-3 mb-3 col-md-<?php echo $bootstrapColWidth; ?>">
                    <a class="mx-auto w-75 w-100-mobile btn btn-lg btn-primary pt-4 pb-4 btn-block"
                    href="<?= $productUrl ?>/<?= $category->categoryID ?>"><?= $category->categoryName; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
    $rowCount++;
    if ($rowCount % $numOfCols == 0) {
        echo '</div><div class="row">';
    }
?>
