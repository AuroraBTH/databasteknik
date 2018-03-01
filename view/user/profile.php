<?php
namespace Anax\View;

$logout = url("user/logout");

$address = $data["content"]->userAddress . " " . $data["content"]->userPostcode . " " . $data["content"]->userCity;
?>

<div class="d-flex justify-content-center p-2">
    <div class="d-flex flex-column w-50 justify-content-center">
        <table class="table my-2 border border-top-0">
            <tr>
                <th>Kund ID</th>
                <td><?= $data["content"]->userID ?></td>
            </tr>
            <tr>
                <th>Namn</th>
                <td><?= $data["content"]->userFirstName . " " . $data["content"]->userSurName ?></td>
            </tr>
            <tr>
                <th>Adress</th>
                <td><?= $address ?></td>
            </tr>
            <tr>
                <th>Telefonnummer</th>
                <td><?= $data["content"]->userPhone ?></td>
            </tr>
            <tr>
                <th>Mail</th>
                <td><?= $data["content"]->userMail ?></td>
            </tr>
            <tr>
                <th>Kön</th>
                <td><?= $data["content"]->userGender == 0 ? 'Kvinna' : 'Man' ?></td>
            </tr>
        </table>
        <a type="button" class="btn btn-lg btn-primary m-2 p-2" href="#">Se ordrar</a>
        <a type="button" class="btn btn-lg btn-primary m-2 p-2" href="#">Redigera profil</a>
        <a type="button" class="btn btn-lg btn-primary m-2 p-2" href="<?= $logout ?>">Logga ut</a>
    </div>
</div>
