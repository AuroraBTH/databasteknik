<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$parentID = $data['categoryParent'][0]->parentID;
$parentUrl = url("category/$parentID");
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <a type="button" class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4" href="<?= $parentUrl ?>"><i class="far fa-arrow-alt-circle-left fa-2x"></i> <span class="align-text-bottom pl-1">Tillbaka</span></a>
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0">Namn</th>
                    <th scope="col" class="border-bottom-0">Storlek</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0">Färg</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data["products"] as $item) : ?>
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?= $item->productManufacturer ?></td>
                            <td><?= $item->productName ?></td>
                            <td><?= $item->productSize ?></td>
                            <td><?= $item->productSellPrize ?></td>
                            <td><?= $item->productColor ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= $item->productManufacturer ?></td>
                            <td><?= $item->productName ?></td>
                            <td><?= $item->productSize ?></td>
                            <td><?= $item->productSellPrize ?></td>
                            <td><?= $item->productColor ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                        </tr>
                    <?php endif; ?>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a type="button" class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4" href="<?= $parentUrl ?>"><i class="far fa-arrow-alt-circle-left fa-2x"></i> <span class="align-text-bottom pl-1">Tillbaka</span></a>
    </div>
</div>
