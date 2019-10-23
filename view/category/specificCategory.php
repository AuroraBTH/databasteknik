<?php
namespace Anax\View;

$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

$productUrl = url("products");
$gender = $data["title"][0]->gender == 0 ? 'Dam' : 'Herr';
$backUrl = url("category");
?>

<div class="d-flex flex-row justify-content-center p-2">
    <div class="home w-75">
        <p class="h2 text-center mt-4"><?= $data["title"][0]->categoryName ?> (<?= $gender ?>)</p>
        <div class="row text-center mr-0 ml-0">
            <?php foreach ($data["categories"] as $category) : ?>
                <div class="w-50 mt-3 mb-3 col-md-<?php echo $bootstrapColWidth; ?>">
                    <a class="mx-auto w-75 w-100-mobile btn btn-lg btn-primary pt-4 pb-4 btn-block"
                    href="<?= $productUrl ?>/<?= $category->categoryID ?>/<?= $data["title"][0]->gender ?>?page=1">
                    <?= $category->categoryName; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<a class="btn btn-block btn-light-blue w-25 w-75-mobile mx-auto pt-4 pb-4" href="<?= $backUrl ?>">
    <i class="far fa-arrow-alt-circle-left fa-2x"></i>
    <span class="align-text-bottom pl-1">Tillbaka</span>
</a>

<?php
    $rowCount++;
    if ($rowCount % $numOfCols == 0) {
        echo '</div><div class="row">';
    }
?>
