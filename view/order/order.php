<?php
namespace Anax\View;


$ordersUrl = url("orders");
$counter = 0;

// var_dump($data);
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Ordernummer</th>
                    <th scope="col" class="border-bottom-0">Produkt</th>
                    <th scope="col" class="border-bottom-0">Antal</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0">Färg</th>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['orderItems'] as $item) : ?>
                    <!-- <?php var_dump($item['product']) ?> -->
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?= $item['order']->orderID ?></td>
                            <td><?= $item['product']->productName ?></td>
                            <td><?= $item['order']->productAmount ?></td>
                            <td><?= $item['product']->productSellPrize ?></td>
                            <td><?= $item['product']->productColor ?></td>
                            <td><?= $item['product']->productManufacturer ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= $item['order']->orderID ?></td>
                            <td><?= $item['product']->productName ?></td>
                            <td><?= $item['order']->productAmount ?></td>
                            <td><?= $item['product']->productSellPrize ?></td>
                            <td><?= $item['product']->productColor ?></td>
                            <td><?= $item['product']->productManufacturer ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a type="button"
           class="btn btn-lg btn-primary m-2 p-2"
           href="<?= $ordersUrl ?>">Tillbaka till beställningar
       </a>
    </div>
</div>
