<?php
namespace Anax\View;


$ordersUrl = url("orders");
$product = url("product");
$counter = 0;
$price = 0;
$amountOfItems = 0;
$totalWeight = 0;
$totalShipping = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <h1>Order: <?= $data['orderItems'][0]['orderID'] ?></h1>
        <table class="table border mb-4">
            <thead>
                <tr>
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
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item['productName'] ?></td>
                            <td><?= $item['productAmount'][1] ?></td>
                            <td><?= $item['productSellPrize'] ?></td>
                            <td><?= $item['productColor'] ?></td>
                            <td><?= $item['productManufacturer'] ?></td>
                            <th scope="row">
                                <a href="<?= $product ?>/<?= $item['productID'][0] ?>">Mer information</a>
                            </th>
                        </tr>
                    <?php
                        $price += ((int)$item['productSellPrize'] * (int)$item['productAmount'][1]);
                        $totalWeight += (int)$item['productWeight'] * (int)$item['productAmount'][1];
                        $amountOfItems += ((int)$item['productAmount'][1]);
                        $totalShipping = ($totalWeight / 1000) < 1 ? 50 : 50 + (20 * round($totalWeight / 1000));
                        $counter++
                    ?>
                <?php endforeach; ?>
            </tbody>
        </table>
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
        <a class="btn btn-block btn-light-blue w-25 mx-auto m-2 p-2 mb-4" href="<?= $ordersUrl ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1"> Tillbaka till beställningar</span>
        </a>
    </div>
</div>
