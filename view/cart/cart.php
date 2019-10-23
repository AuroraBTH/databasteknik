<?php

namespace Anax\View;


$url = url("product");
$counter = 0;
$amountOfItems = 0;
$totalWeight = 0;
$totalShipping = 0;

$checkout = url("cart/checkout");
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75 w-100-mobile">
        <h1 class="text-center">Kundvagn</h1>
        <div id="cartView" class="table-responsive">
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
                    <?php foreach ((array) $cartItems as $key => $value) : ?>
                        <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $value["productManufacturer"] ?></td>
                            <td><?= $value["productName"] ?></td>
                            <td><?= $value["productSize"] ?></td>
                            <td><?= $value["productSellPrize"] ?></td>
                            <td><?= $value["productColor"] ?></td>
                            <td>
                                <button class="cartButtons" onclick="minusProduct('<?= $value["productID"] ?>')" type="button" name="button">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <?= $value['amount'] ?>
                                <button class="cartButtons" onclick="plusProduct('<?= $value["productID"] ?>')" type="button" name="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <th scope="row">
                                <a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a>
                            </th>
                            <td>
                                <button class="removeButton" onclick="removeFromCart('<?= $value["productID"] ?>')" type="button" name="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                            $amountOfItems += ((int) $value['amount']);
                            $counter++;
                            ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($amountOfItems > 0) : ?>
                <button class="btn btn-block btn-danger w-25 w-75-mobile mx-auto mb-4 py-2" onclick=removeAllFromCart() type="button" name="button">Töm kundvagn</button>
                <div class="table-responsive">
                    <table class="table w-50 w-75-mobile border border-top-0 mx-auto">
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
                                <th>Summa:</th>
                                <td><?= $data["price"] ?> kr</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary btn-block w-25 w-75-mobile mx-auto mb-4 py-2" href="<?= $checkout ?>">
                    Gå till kassan
                </a>
            <?php elseif ($amountOfItems < 1) : ?>
                <p>Din kundvagn innehåller för tillfället inga produkter.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
