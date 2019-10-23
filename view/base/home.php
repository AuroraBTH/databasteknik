<?php

namespace Anax\View;


$url = url("product");
$products = url("products");
$counter = 0;
$genderCounter = 0;
?>

<div class="d-flex flex-column justify-content-center mt-4">
    <?php foreach ($data[0] as $top10) : ?>
        <?php $counter = 0; ?>
        <div class="mx-4">
            <?= $genderCounter == 0 ? '<h1>Top 10 Dam</h1>' : '<h1>Top 10 Herr</h1>' ?>
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
                    <?php foreach ($top10 as $item) : ?>
                        <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item['productManufacturer'] ?></td>
                            <td><?= $item['productName'] ?></td>
                            <td class="hide-on-mobile"><?= $item['productSize'] ?></td>
                            <td><?= $item['productSellPrize'] ?></td>
                            <td class="hide-on-mobile"><?= $item['productColor'] ?></td>
                            <th scope="row" class="text-center">
                                <a href="<?= $url ?>/<?= $item['productID'] ?>">Mer information</a>
                            </th>
                        </tr>
                        <?php $counter++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php $genderCounter++ ?>
        </div>
    <?php endforeach; ?>
    <?php $genderCounter = 0;
    $counter = 0; ?>
    <?php foreach ($data[1] as $under500) : ?>
        <div class="mx-4">
            <?= $genderCounter == 0 ?
                    '<h1>Produkter under 500kr Dam</h1>' : '<h1>Produkter under 500kr Herr</h1>'
                ?>
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
                    <?php foreach ($under500 as $item) : ?>
                        <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item->productManufacturer ?></td>
                            <td><?= $item->productName ?></td>
                            <td class="hide-on-mobile"><?= $item->productSize ?></td>
                            <td><?= $item->productSellPrize ?></td>
                            <td class="hide-on-mobile"><?= $item->productColor ?></td>
                            <th scope="row" class="text-center">
                                <a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a>
                            </th>
                        </tr>
                        <?php $counter++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($genderCounter == 0) : ?>
                <a class="btn btn-block btn-primary w-50 mx-auto m-2 p-2 mb-4" href="<?= $products ?>/under500Female?page=1">Fler produkter</a>
            <?php elseif ($genderCounter == 1) : ?>
                <a class="btn btn-block btn-primary w-50 mx-auto m-2 p-2 mb-4" href="<?= $products ?>/under500Male?page=1">Fler produkter</a>
            <?php endif; ?>
        </div>
        <?php $genderCounter++ ?>
    <?php endforeach; ?>
</div>
