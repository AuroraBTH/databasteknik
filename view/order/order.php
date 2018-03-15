<?php
namespace Anax\View;


$ordersUrl = url("orders");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Ordernummer</th>
                    <th scope="col" class="border-bottom-0">Productnummer</th>
                    <th scope="col" class="border-bottom-0">Antal</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data["orders"] as $item) : ?>
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?= $item->orderID ?></td>
                            <td><?= $item->productID ?></td>
                            <td><?= $item->productAmount ?></td>
                            <!-- <th scope="row"><a href="<?= $url ?>/<?= $item->orderID ?>">Mer information</a></th> -->
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= $item->orderID ?></td>
                            <td><?= $item->productID ?></td>
                            <td><?= $item->productAmount ?></td>
                            <!-- <th scope="row"><a href="<?= $url ?>/<?= $item->orderID ?>">Mer information</a></th> -->
                        </tr>
                    <?php endif; ?>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a type="button" class="btn btn-lg btn-primary m-2 p-2" href="<?= $ordersUrl ?>">Tillbaka till beställningar</a>
    </div>
</div>
