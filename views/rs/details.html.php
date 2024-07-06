<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="flex items-center gap-2">
        <a href="<?=WEBROOT?>?controller=rs&action=liste-appro">
            <img src="<?=WEBROOT?>/icons/arrow-left.svg" alt="Arrow Left">
        </a>
        <span class="text-2xl">Détails Approvisionnements</span>
    </h1>
</div>
<div class="color-indigo">
    <div class="w-full mb-3 bg-white shadow text-indigo rounded p-4">
        <div class="flex justify-between items-center">
            <div class="w-full flex flex-col gap-3">
                <div class="w-full">
                    <h2>Nom: <span class="text-xl capitalize font-semibold"><?= $user["nom"] ?></span></h2>
                </div>
                <div class="w-full">
                    <h2>Prénom: <span class="text-xl capitalize font-semibold"><?= $user["prenom"] ?></span></h2>
                </div>
                <div class="w-full">
                    <h2>Téléphone: <span class="text-xl capitalize font-semibold"><?= $user["tel"] ?></span></h2>
                </div>
                <div class="w-full">
                    <h2>Adresse: <span class="text-xl capitalize font-semibold"><?= $user["adresse"] ?></span></h2>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <?php if ($user["photo"] != 'null') : ?>
                    <div class="mb-2">
                        <img src="<?= WEBROOT . 'images/' . basename($user["photo"]) ?>" alt="User" class="h-40 w-40 object-cover rounded shadow">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-auto w-full bg-white shadow text-indigo rounded">
            <thead>
                <tr>
                    <th class="w-1/12 pl-4 py-4 text-left">ID</th>
                    <th class="w-1/12 py-4 text-left">Qte Appro</th>
                    <th class="w-1/12 py-4 text-left">Mnt Appro</th>
                    <th class="w-1/12 py-4 text-left">Prix Achat</th>
                    <th class="w-1/12 py-4 text-left">Qte Achat</th>
                    <th class="w-1/12 py-4 text-left">Qte Stock</th>
                    <th class="w-1/12 py-4 text-left">Mnt Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($details as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4"><?= $counter ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteAppro"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["montant"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["prixAchat"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteAchat"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteStock"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["montantStock"] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php Session::remove("errors"); ?>