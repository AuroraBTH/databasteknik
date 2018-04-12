<?php
namespace Anax\View;


$url = url("product");
$products = url("products");
$counter = 0;
if (isset($_GET["page"])) {
    $amountPerPage = 50;
    $totalPages = round($data["amountOfProducts"]);
    $start = (htmlentities($_GET["page"]) - 5) > 1 ? htmlentities($_GET["page"]) - 5 : 1;
    $end = (htmlentities($_GET["page"]) + 5) < ($totalPages / $amountPerPage) ? (htmlentities($_GET["page"]) + 5) : ($totalPages / $amountPerPage);
}
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="d-flex flex-column w-100">
        <div class="d-flex w-100 justify-content-around">
            <div class="mx-4 w-50">
                <h1 class="text-center">Produkter under 500kr Herr</h1>
                <table class="table border mb-4">
                    <thead>
                        <tr>
                            <th scope="col" class="border-bottom-0">Tillverkare</th>
                            <th scope="col" class="border-bottom-0">Namn</th>
                            <th scope="col" class="border-bottom-0">Storlek</th>
                            <th scope="col" class="border-bottom-0">Pris</th>
                            <th scope="col" class="border-bottom-0">Färg</th>
                            <th scope="col" class="border-bottom-0"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data["under500Male"] as $item) : ?>
                        <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                                <td><?= $item->productManufacturer ?></td>
                                <td><?= $item->productName ?></td>
                                <td><?= $item->productSize ?></td>
                                <td><?= $item->productSellPrize ?></td>
                                <td><?= $item->productColor ?></td>
                                <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                            </tr>
                        <?php $counter++ ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["page"])) : ?>
                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <a class="btn btn-lg btn-primary mb-4"
                            href="<?= $products ?>/under500Male?page=<?=$i?>"><?=$i?></a>
                    <?php endfor; ?>
                    <p><b>Antal sidor: <?= round($data["amountOfProducts"] / $amountPerPage) ?></b></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
