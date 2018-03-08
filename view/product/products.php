<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Färg</th>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0">Namn</th>
                    <th scope="col" class="border-bottom-0">Storlek</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $item) : ?>
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?php print_r($item->productManufacturer); ?></td>
                            <td><?php print_r($item->productName); ?></td>
                            <td><?php print_r($item->productSize); ?></td>
                            <td><?php print_r($item->productSellPrize); ?></td>
                            <td><?php print_r($item->productColor); ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?php print_r($item->productManufacturer); ?></td>
                            <td><?php print_r($item->productName); ?></td>
                            <td><?php print_r($item->productSize); ?></td>
                            <td><?php print_r($item->productSellPrize); ?></td>
                            <td><?php print_r($item->productColor); ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                        </tr>
                    <?php endif; ?>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
