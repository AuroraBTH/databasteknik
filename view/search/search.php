<?php

namespace Anax\View;


$url = url("product");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <h1>Antal träffar: <?= $data["searchResultCount"] ?></h1>
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0">Namn</th>
                    <th scope="col" class="border-bottom-0 hide-on-mobile">Storlek</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0 hide-on-mobile">Färg</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data["searchResult"] as $item) : ?>
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                        <td><?= $item->productManufacturer ?></td>
                        <td><?= $item->productName ?></td>
                        <td class="hide-on-mobile"><?= $item->productSize ?></td>
                        <td><?= $item->productSellPrize ?></td>
                        <td class="hide-on-mobile"><?= $item->productColor ?></td>
                        <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                    </tr>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
