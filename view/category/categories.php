<?php
namespace Anax\View;

$categoryUrl = url("category");

?>

<div class="home">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Kategori</th>
                <th scope="col">Kön</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["categories"] as $category) : ?>
                <tr>
                     <td><a href="<?= $categoryUrl ?>/<?= $category->categoryID ?>">
                         <?= $category->categoryName; ?></a></td>
                     <td><?= $category->gender === 0 ? "Kvinna" : "Man"; ?> </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
