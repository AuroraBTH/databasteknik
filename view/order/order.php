<?php
namespace Anax\View;


$ordersUrl = url("orders");
$product = url("product");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75 w-100-mobile">
        <h1>Order: <?= $data['orderItems'][0]['orderID'] ?></h1>
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Produkt</th>
                    <th scope="col" class="border-bottom-0">Antal</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0 hide-on-mobile">Färg</th>
                    <th scope="col" class="border-bottom-0 hide-on-mobile">Tillverkare</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['orderItems'] as $item) : ?>
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item['productName'] ?></td>
                            <td><?= $item['productAmount'][1] ?></td>
                            <td><?= $item['productSellPrize'] ?></td>
                            <td class="hide-on-mobile"><?= $item['productColor'] ?></td>
                            <td class="hide-on-mobile"><?= $item['productManufacturer'] ?></td>
                            <th scope="row">
                                <a href="<?= $product ?>/<?= $item['productID'][0] ?>">Mer information</a>
                            </th>
                        </tr>
                    <?php
                        $counter++
                    ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex flex-row flex-column-mobile justify-content-around">
            <table class="table w-25 w-100-mobile border border-top-0">
                <thead>
                    <tr class="text-center font-weight-bold">
                        <th colspan="2">Beställningsinformation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Antal Produkter:</th>
                        <td><?= $data["amountOfItems"] ?></td>
                    </tr>
                    <tr>
                        <th>Total vikt:</th>
                        <td><?= round($data["weight"] / 1000, 1) ?> kg</td>
                    </tr>
                    <tr>
                        <th>Kupong använd:</th>
                        <td><?= isset($coupon) ? "$coupon->couponName ($coupon->couponAmount%)" : "" ?></td>
                    </tr>
                    <tr>
                        <th>Frakt:</th>
                        <td><?= $data["shipping"] ?> kr</td>
                    </tr>
                    <tr>
                        <th>Summa Totalt:</th>
                        <td><?= $data["price"] ?> kr</td>
                    </tr>
                </tbody>
            </table>
            <table class="table w-50 w-100-mobile border border-top-0">
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
        <a class="btn btn-block btn-light-blue w-25 w-75-mobile mx-auto m-2 p-2 mb-4" href="<?= $ordersUrl ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1"> Tillbaka till beställningar</span>
        </a>
    </div>
</div>
