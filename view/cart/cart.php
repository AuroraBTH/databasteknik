<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$price = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0">Namn</th>
                    <th scope="col" class="border-bottom-0">Storlek</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0">Färg</th>
                    <th scope="col" class="border-bottom-0">Antal</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $key => $value) : ?>
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?php print_r($value['productManufacturer']); ?></td>
                            <td><?php print_r($value['productName']); ?></td>
                            <td><?php print_r($value['productSize']); ?></td>
                            <td><?php print_r($value['productSellPrize']); ?></td>
                            <td><?php print_r($value['productColor']); ?></td>
                            <td><?php print_r($value['amount']); ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?php print_r($value['productManufacturer']); ?></td>
                            <td><?php print_r($value['productName']); ?></td>
                            <td><?php print_r($value['productSize']); ?></td>
                            <td><?php print_r($value['productSellPrize']); ?></td>
                            <td><?php print_r($value['productColor']); ?></td>
                            <td><?php print_r($value['amount']); ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                    <?php endif; ?>
                    <?php $price += ((int)$value['productSellPrize'] * (int)$value['amount'])?>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Summa: <?php echo $price ?> kr</p>
    </div>
</div>
