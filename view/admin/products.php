<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$admin = url("admin")
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75">
        <a class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4"
        href="<?= $admin ?>"><i class="far fa-arrow-alt-circle-left fa-2x"></i>
        <span class="align-text-bottom pl-1">Tillbaka</span></a>
        <a class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4"
        href="<?= $admin ?>/low"><span class="align-text-bottom pl-1">Produkter med lågt antal</span></a>
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
                            <td><a href="<?= $admin ?>/edit/<?= $item->productID ?>"><i class="fas fa-edit"></i></a></td>
                            <td><button class="removeButton" onclick="removeProduct('<?= $item->productID ?>')" type="button" name="button"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn btn-block btn-light-blue w-25 mx-auto pt-2 pb-2 mb-4"
        href="<?= $admin ?>"><i class="far fa-arrow-alt-circle-left fa-2x"></i>
        <span class="align-text-bottom pl-1">Tillbaka</span></a>
    </div>
</div>
