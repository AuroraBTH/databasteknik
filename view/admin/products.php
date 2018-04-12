<?php
namespace Anax\View;

$counter = 0;
$admin = url("admin");
$url = url("product");

if (isset($_GET["page"])) {
    $amountPerPage = 50;
    $totalPages = round($data["amountOfProducts"]);
    $start = (htmlentities($_GET["page"]) - 5) > 1 ? htmlentities($_GET["page"]) - 5 : 1;
    $end = (htmlentities($_GET["page"]) + 5) < ($totalPages / $amountPerPage) ? (htmlentities($_GET["page"]) + 5) : ($totalPages / $amountPerPage);
}
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <a class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4"
        href="<?= $admin ?>"><i class="far fa-arrow-alt-circle-left fa-2x"></i>
        <span class="align-text-bottom pl-1">Tillbaka</span></a>
        <a class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4"
        href="<?= $admin ?>/low?page=1"><span class="align-text-bottom pl-1">Produkter med lågt antal</span></a>
        <table class="table border mb-4" id="products">
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
                <?php foreach ($data["products"] as $item) : ?>
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item->productManufacturer ?></td>
                            <td><?= $item->productName ?></td>
                            <td><?= $item->productSize ?></td>
                            <td><?= $item->productSellPrize ?></td>
                            <td><?= $item->productColor ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $item->productID ?>">Mer information</a></th>
                            <td>
                                <a href="<?= $admin ?>/edit/<?= $item->productID ?>"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>
                                <button
                                    class="removeButton"
                                    onclick="removeProduct('<?= $item->productID ?>')"
                                    type="button"
                                    name="button">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["page"])) : ?>
            <?php for ($i = $start; $i <= $end; $i++) : ?>
                <a class="btn btn-lg btn-primary mb-4"
                    href="<?= $admin ?>/products?page=<?=$i?>"><?=$i?></a>
            <?php endfor; ?>
            <p><b>Antal sidor: <?= round($data["amountOfProducts"] / $amountPerPage) ?></b></p>
        <?php endif; ?>
        <a class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4"
        href="<?= $admin ?>"><i class="far fa-arrow-alt-circle-left fa-2x"></i>
        <span class="align-text-bottom pl-1">Tillbaka</span></a>
    </div>
</div>
