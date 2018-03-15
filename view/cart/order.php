<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$price = 0;
$amountOfItems = 0;
$totalWeight = 0;
$totalShipping = 0;

$order = url("cart/order");
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <h1>Ordernummer: <?= $orderID ?></h1>
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
                <?php foreach ((array)$cartItems as $key => $value) : ?>
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?= $value["productManufacturer"] ?></td>
                            <td><?= $value["productName"] ?></td>
                            <td><?= $value["productSize"] ?></td>
                            <td><?= $value["productSellPrize"] ?></td>
                            <td><?= $value["productColor"] ?></td>
                            <td><?= $value['amount'] ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= $value["productManufacturer"] ?></td>
                            <td><?= $value["productName"] ?></td>
                            <td><?= $value["productSize"] ?></td>
                            <td><?= $value["productSellPrize"] ?></td>
                            <td><?= $value["productColor"] ?></td>
                            <td><?= $value['amount'] ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                    <?php endif; ?>
                    <?php
                    $price += ((int)$value['productSellPrize'] * (int)$value['amount']);
                    $totalWeight += (int)$value['productWeight'] * (int)$value['amount'];
                    $amountOfItems += ((int)$value['amount']);
                    $totalShipping = ($totalWeight / 1000) < 1 ? 50 : 50 + (20 * round($totalWeight / 1000));
                    $counter++;
                    ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($amountOfItems > 0) : ?>
            <p><b>Antal Produkter: <?= $amountOfItems ?></b></p>
            <p><b>Total vikt: <?= round($totalWeight / 1000, 1) ?> kg</b></p>
            <p><b>Summa: <?= $price ?> kr</b></p>
            <p><b>Frakt: <?= $totalShipping ?> kr</b></p>
            <p><b>Summa totalt: <?= $price + $totalShipping ?> kr</b></p>
            <br>
            <p>Namn: <?= $userInfo->userFirstName . " " . $userInfo->userSurName ?></p>
            <p>Adress: <?= $userInfo->userAddress . " " . $userInfo->userPostcode . " " . $userInfo->userCity; ?></p>
            <p>Email: <?= $userInfo->userMail ?></p>
            <p>Telefonnummer: <?= $userInfo->userPhone ?></p>
        <?php elseif ($amountOfItems < 1) : ?>
            <p>Din kundvagn innehåller för tillfället inga produkter.</p>
        <?php endif; ?>
    </div>
</div>
