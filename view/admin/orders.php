<?php
namespace Anax\View;


$adminURL = url("admin");
$orders = url("orders");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75 w-100-mobile">
        <div class="table-responsive">
            <table class="table border mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="border-bottom-0">Ordernummer</th>
                        <th scope="col" class="border-bottom-0">Tid</th>
                        <th scope="col" class="border-bottom-0"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data["orders"] as $item) : ?>
                        <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                                <td><?= $item->orderID ?></td>
                                <td><?= $item->purchaseTime ?></td>
                                <th scope="row">
                                    <a href="<?= $adminURL ?>/order/<?= $item->orderID ?>">Mer information</a>
                                </th>
                            </tr>
                        <?php $counter++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a class="btn btn-block btn-light-blue w-25 w-75-mobile mx-auto m-2 p-2 mb-4" href="<?= $adminURL ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1"> Tillbaka</span>
        </a>
    </div>
</div>
