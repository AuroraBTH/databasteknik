<?php

namespace Anax\View;


$url = url("product");
$counter = 0;

$order = url("cart/order");
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75 w-100-mobile">
        <h1 class="text-center">Kassa</h1>
        <div class="table-responsive">
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
                            <td><?= $value['amount'] ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $value['productID'] ?>">Mer information</a></th>
                        </tr>
                        <?php
                            $counter++;
                            ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($data["amountOfItems"] > 0) : ?>
            <div class="d-flex flex-column-mobile justify-content-around">
                <div class="table-responsive">
                    <table class="table w-50 w-75-mobile border border-top-0 mx-auto-mobile">
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
                                <th>Summa:</th>
                                <td><?= $data["price"] ?> kr</td>
                            </tr>
                            <tr>
                                <th>Frakt:</th>
                                <td><?= $data["shipping"] ?> kr</td>
                            </tr>
                            <tr>
                                <th>Summa totalt:</th>
                                <td><?= $data["price"] + $data["shipping"] ?> kr</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="w-25 w-75-mobile mx-auto-mobile">
                    <form class="" action="<?= $order ?>" method="POST">
                        <div class="form-group">
                            <h4 class="text-center">Kupong</h4>
                            <div class="d-flex">
                                <input name="coupon" type="text" class="form-control w-75-mobile mx-auto-mobile" id="coupon" placeholder="HELG">
                                <i id="check" class="fas fa-check d-none text-success m-auto"></i>
                            </div>
                        </div>
                        <div class="form-group w-75 w-75-mobile mx-auto">
                            <button type="submit" class="form-control btn btn-lg btn-primary">Beställ</button>
                        </div>
                    </form>
                </div>

            </div>
        <?php elseif ($data["amountOfItems"] < 1) : ?>
            <p>Din kundvagn innehåller för tillfället inga produkter.</p>
        <?php endif; ?>
    </div>
</div>
