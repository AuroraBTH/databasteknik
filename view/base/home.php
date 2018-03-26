<?php
namespace Anax\View;


$url = url("product");
$products = url("products");
$counter = 0;
$genderCounter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="d-flex flex-column w-100">
        <div class="d-flex w-100 justify-content-around">
            <?php foreach ($data[0] as $top10) : ?>
                <div class="mx-4 w-50">
                    <?= $genderCounter == 1 ? '<h1>Top 10 Dam</h1>' : '<h1>Top 10 Herr</h1>' ?>
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
                            <?php foreach ($top10 as $item): ?>
                                <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                                    <td><?= $item['productManufacturer'] ?></td>
                                    <td><?= $item['productName'] ?></td>
                                    <td><?= $item['productSize'] ?></td>
                                    <td><?= $item['productSellPrize'] ?></td>
                                    <td><?= $item['productColor'] ?></td>
                                    <th scope="row">
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
        </div>
        <div class="d-flex w-100 justify-content-around">
            <?php $genderCounter = 0; $counter = 0; ?>
            <?php foreach ($data[1] as $under500) : ?>
                <div class="mx-4 w-50">
                    <?= $genderCounter == 1 ?
                        '<h1>Produkter under 500kr Dam</h1>' :
                        '<h1>Produkter under 500kr Herr</h1>'
                    ?>
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
                            <?php foreach ($under500 as $item) : ?>
                                <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                                    <td><?= $item->productManufacturer ?></td>
                                    <td><?= $item->productName ?></td>
                                    <td><?= $item->productSize ?></td>
                                    <td><?= $item->productSellPrize ?></td>
                                    <td><?= $item->productColor ?></td>
                                    <th scope="row">
                                        <a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a>
                                    </th>
                                </tr>
                            <?php $counter++ ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a class="btn btn-block btn-primary w-50 mx-auto m-2 p-2 mb-4"
                    href="<?= $products ?>/under500">Fler produkter</a>
                </div>
                <?php $genderCounter++ ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
