<?php
namespace Anax\View;


$url = url("product");
$counter = 0;
$admin = url("admin");
?>

<div class="d-flex flex-row justify-content-center mt-4">
    <div class="w-75 w-100-mobile">
        <a class="btn btn-block btn-light-blue w-25 w-75-mobile mx-auto pt-2 pb-2 mb-4" href="<?= $admin ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1">Tillbaka</span>
        </a>
        <div class="table-responsive">
            <table class="table border mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="border-bottom-0">Namn</th>
                        <th scope="col" class="border-bottom-0">Email</th>
                        <th scope="col" class="border-bottom-0">Telefonnummer</th>
                        <th scope="col" class="border-bottom-0">Kön</th>
                        <th scope="col" class="border-bottom-0">Användarnivå</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data["users"] as $user) : ?>
                            <tr <?= ($counter % 2) == 0 ? 'class="bg-light"' : "" ?>>
                                <td><?= $user->userFirstName ?> <?= $user->userSurName ?></td>
                                <td><?= $user->userMail ?></td>
                                <td><?= $user->userPhone ?></td>
                                <td><?= $user->userGender == 0 ? "Kvinna" : "Man" ?></td>
                                <?php
                                    switch ($user->userRole) {
                                        case 0:
                                            echo "<td>Kund</td>";
                                            break;
                                        case 1:
                                            echo "<td>Admin</td>";
                                            break;
                                        case 2:
                                            echo "<td>Ledning</td>";
                                            break;
                                    }
                                    ?>
                            </tr>
                        <?php $counter++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a class="btn btn-block btn-light-blue w-25 w-75-mobile mx-auto pt-2 pb-2 mb-4" href="<?= $admin ?>">
            <i class="far fa-arrow-alt-circle-left fa-2x"></i>
            <span class="align-text-bottom pl-1">Tillbaka</span>
        </a>
    </div>
</div>
