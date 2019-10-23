<?php
namespace Anax\View;


$url = url("order");
$profileUrl = url("user/profile");
$counter = 0;
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75 w-100-mobile">
        <table class="table border mb-4">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom-0">Ordernummer</th>
                    <th scope="col" class="border-bottom-0">Tid</th>
                    <th scope="col" class="border-bottom-0"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data["orders"] as $item) : ?>
                    <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                            <td><?= $item->orderID ?></td>
                            <td><?= $item->purchaseTime ?></td>
                            <th scope="row"><a href="<?= $url ?>/<?= $item->orderID ?>">Mer information</a></th>
                        </tr>
                    <?php $counter++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn btn-block btn-light-blue w-25 w-75-mobile mx-auto m-2 p-2 mb-4" href="<?= $profileUrl ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1"> Tillbaka till profil</span>
        </a>
    </div>
</div>
