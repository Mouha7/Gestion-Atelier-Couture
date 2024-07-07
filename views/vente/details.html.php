<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="flex items-center gap-2">
        <a href="<?=WEBROOT?>?controller=vente&action=liste-vente">
            <img src="<?=WEBROOT?>/icons/arrow-left.svg" alt="Arrow Left">
        </a>
        <span class="text-2xl">Détails Productions Articles Ventes</span>
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
                    <th class="w-1/12 py-4 text-left">Qte Vente</th>
                    <th class="w-1/12 py-4 text-left">Mnt Vente</th>
                    <th class="w-1/12 py-4 text-left">Prix Vente</th>
                    <th class="w-1/12 py-4 text-left">Observation</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($details as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4"><?= $counter ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteVente"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["montantVente"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["prixVente"] ?></td>
                        <td class="border-t-2 py-2" style="max-width: 30px; overflow: hidden;">
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($value["observations"] == 'null' ? '' : $value["observations"]) ?>">
                                <?= $value["observations"] == 'null' ? '' : $value["observations"] ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php Session::remove("errors"); ?>