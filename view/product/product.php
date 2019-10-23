<?php

namespace Anax\View;

$loggedIn = $this->di->get("session")->has("email");
?>

<script type="text/javascript">
    let data = <?php echo (json_encode($data[0])); ?>;
</script>

<div class="d-flex flex-row justify-content-center p-2">
    <div class="home w-75">
        <div class="d-flex flex-row flex-column-mobile space-around">
            <div class="p-2 w-50 w-100-mobile">
                <img class="img-fluid border" src="../img/shirt.png"></div>
            <div class="p-2 w-50 w-100-mobile align-content-center">
                <div class="d-flex flex-column justify-content-between h-100 bg-light border h-25 mh-10">
                    <div class="p-3 mb-2 bg-light border text-center border-right-0 border-left-0 border-top-0">
                        <h2><?= $data[0]->productName ?></h2>
                    </div>
                    <div class="p-3 mb-2 bg-light text-center border-right-0 border-left-0 h-25">
                        <h3>Webblager:</h3>
                        <p>
                            <?php
                            if ($data[0]->productAmount <= 0) {
                                echo ("Ej i lager");
                            } else if ($data[0]->productAmount < 5) {
                                echo ("Endast ett fåtal kvar i lager");
                            } elseif ($data[0]->productAmount > 5) {
                                echo ("I lager: " . $data[0]->productAmount);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="pt-4 p-3 bg-light border text-center border-right-0 border-left-0 border-bottom-0 h-50">
                        <h3>Pris:</h3>
                        <p class="font-weight-bold"><?= ($data[0]->productSellPrize); ?> kr</p>
                        <?php if ($data[0]->productAmount > 0) : ?>
                            <?= $loggedIn === true ?
                                    '<button type="button" onclick="addToCart(data);"
                            class="btn btn-primary w-50">Lägg i kundvagn</button>'
                                    : ' <button type="button" onclick="redirectToLogin();"
                            class="btn btn-primary w-50">Logga in</button>'
                                ?>
                        <?php endif; ?>
                        <p id="addToCartComplete"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2">
            <table class="table border border-top-0">
                <tr>
                    <th scope="col">Produkt ID</th>
                    <td><?= ($data[0]->productID); ?></td>
                </tr>
                <tr>
                    <th scope="col">Namn</th>
                    <td><?= ($data[0]->productName); ?></td>
                </tr>
                <tr>
                    <th scope="col">Tillverkare</th>
                    <td><?= ($data[0]->productManufacturer); ?></td>
                </tr>
                <tr>
                    <th scope="col">Ursprungsland</th>
                    <td><?= ($data[0]->productOriginCountry); ?></td>
                </tr>
                <tr>
                    <th scope="col">Vikt</th>
                    <td><?= ($data[0]->productWeight); ?></td>
                </tr>
                <tr>
                    <th scope="col">Storlek</th>
                    <td><?= ($data[0]->productSize); ?></td>
                </tr>
                <tr>
                    <th scope="col">Färg</th>
                    <td><?= ($data[0]->productColor); ?></td>
                </tr>
                <tr>
                    <th scope="col">Kön</th>
                    <td><?= ($data[0]->productGender == 0 ? "Dam" : "Herr"); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
