<?php
namespace Anax\View;

$product = url("product");
$management = url("management");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
      <h1>Mest Köpta Produkter (Top 10)</h1>
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Produkt</th>
                    <th scope="col" class="border-bottom-0">Pris</th>
                    <th scope="col" class="border-bottom-0">Färg</th>
                    <th scope="col" class="border-bottom-0">Tillverkare</th>
                    <th scope="col" class="border-bottom-0">Antal Köpta</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $item) : ?>
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item['productName'] ?></td>
                            <td><?= $item['productSellPrize'] ?></td>
                            <td><?= $item['productColor'] ?></td>
                            <td><?= $item['productManufacturer'] ?></td>
                            <td><?= $item['total'] ?></td>
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
        <a class="btn btn-block btn-light-blue w-25 mx-auto m-2 p-2 mb-4" href="<?= $management ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1"> Tillbaka till management</span>
        </a>
    </div>
</div>
