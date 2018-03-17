<?php
namespace Anax\View;


$ordersUrl = url("orders");
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
                    <?php if ($counter % 2) : ?>
                        <tr class="bg-light">
                            <td><?= $item['productName'] ?></td>
                            <td><?= $item['productAmount'][1] ?></td>
                            <td><?= $item['productSellPrize'] ?></td>
                            <td><?= $item['productColor'] ?></td>
                            <td><?= $item['productManufacturer'] ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= $item['productName'] ?></td>
                            <td><?= $item['productAmount'][1] ?></td>
                            <td><?= $item['productSellPrize'] ?></td>
                            <td><?= $item['productColor'] ?></td>
                            <td><?= $item['productManufacturer'] ?></td>
                        </tr>
                    <?php endif; ?>
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
        <a type="button"
           class="btn btn-lg btn-primary m-2 p-2"
           href="<?= $ordersUrl ?>">Tillbaka till beställningar
       </a>
    </div>
</div>
