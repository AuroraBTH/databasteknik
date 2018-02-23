<?php
namespace Anax\View;
?>

<div class="home">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tillverkare</th>
                <th scope="col">Namn</th>
                <th scope="col">Ursprungsland</th>
                <th scope="col">Vikt</th>
                <th scope="col">Storlek</th>
                <th scope="col">Pris</th>
                <th scope="col">Färg</th>
                <th scope="col">Antal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <th scope="row"><?php print_r($item->productID); ?></th>
                    <td><?php print_r($item->productManufacturer); ?></td>
                    <td><?php print_r($item->productName); ?></td>
                    <td><?php print_r($item->productOriginCountry); ?></td>
                    <td><?php print_r($item->productWeight); ?></td>
                    <td><?php print_r($item->productSize); ?></td>
                    <td><?php print_r($item->productSellPrize); ?></td>
                    <td><?php print_r($item->productColor); ?></td>
                    <td><?php print_r($item->productAmount); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
