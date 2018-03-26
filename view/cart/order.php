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
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $value["productManufacturer"] ?></td>
                            <td><?= $value["productName"] ?></td>
                            <td><?= $value["productSize"] ?></td>
                            <td><?= $value["productSellPrize"] ?></td>
                            <td><?= $value["productColor"] ?></td>
                            <td><?= $value['amount'] ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
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
            <div class="d-flex flex-row justify-content-around">
                <table class="table w-25 border border-top-0">
                    <thead>
                        <tr class="text-center font-weight-bold">
                            <th colspan="2">Beställningsinformation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Antal Produkter:</th>
                            <td><?= $amountOfItems ?></td>
                        </tr>
                        <tr>
                            <th>Total vikt:</th>
                            <td><?= round($totalWeight / 1000, 1) ?> kg</td>
                        </tr>
                        <tr>
                            <th>Summa:</th>
                            <td><?= $price ?> kr</td>
                        </tr>
                        <tr>
                            <th>Frakt:</th>
                            <td><?= $totalShipping ?> kr</td>
                        </tr>
                        <tr>
                            <th>Summa totalt:</th>
                            <td><?= $price + $totalShipping ?> kr</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table w-50 border border-top-0">
                    <thead>
                        <tr class="text-center font-weight-bold">
                            <th colspan="2">Kundinformation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Namn:</th>
                            <td><?= $userInfo->userFirstName . " " . $userInfo->userSurName ?></td>
                        </tr>
                        <tr>
                            <th>Adress:</th>
                            <td><?= $userInfo->userAddress . " " . $userInfo->userPostcode . " " . $userInfo->userCity; ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= $userInfo->userMail ?></td>
                        </tr>
                        <tr>
                            <th>Telefonnummer:</th>
                            <td><?= $userInfo->userPhone ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php elseif ($amountOfItems < 1) : ?>
            <p>Din kundvagn innehåller för tillfället inga produkter.</p>
        <?php endif; ?>
    </div>
</div>
