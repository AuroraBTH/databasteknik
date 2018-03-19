<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$genderCounter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <?php foreach($data as $top10) : ?>
            <?= $genderCounter == 0 ? '<h1>Top 10 Dam</h1>' : '<h1>Top 10 Herr</h1>' ?>
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
                    <?php foreach ((array)$top10 as $item) : ?>
                        <?php if ($counter % 2) : ?>
                            <tr class="bg-light">
                                <td><?= $item['productManufacturer'] ?></td>
                                <td><?= $item['productName'] ?></td>
                                <td><?= $item['productSize'] ?></td>
                                <td><?= $item['productSellPrize'] ?></td>
                                <td><?= $item['productColor'] ?></td>
                                <th scope="row"><a href="<?= $url ?>/<?= $item['productID'] ?>">Mer information</a></th>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <td><?= $item['productManufacturer'] ?></td>
                                <td><?= $item['productName'] ?></td>
                                <td><?= $item['productSize'] ?></td>
                                <td><?= $item['productSellPrize'] ?></td>
                                <td><?= $item['productColor'] ?></td>
                                <th scope="row"><a href="<?= $url ?>/<?= $item['productID'] ?>">Mer information</a></th>
                            </tr>
                        <?php endif; ?>
                        <?php $counter++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php $genderCounter++ ?>
        <?php endforeach; ?>
    </div>
</div>
