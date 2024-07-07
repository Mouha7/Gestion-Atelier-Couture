<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="flex items-center gap-2">
        <a href="<?=WEBROOT?>?controller=rp&action=liste-vente">
            <img src="<?=WEBROOT?>/icons/arrow-left.svg" alt="Arrow Left">
        </a>
        <span class="text-2xl">Détails Production Article Vente</span>
    </h1>
</div>
<div class="color-indigo">
    <div class="w-full mb-3 bg-white shadow text-indigo rounded p-4">
        <div class="flex justify-between items-center">
            <div class="w-full flex flex-col gap-3">
                <div class="w-full">
                    <h2>Libelle: <span class="text-xl capitalize font-semibold"><?= $value["libelle"] ?></span></h2>
                </div>
                <div class="w-full">
                    <h2>Date: <span class="text-xl capitalize font-semibold"><?= $value["date"] ?></span></h2>
                </div>
                <div class="w-full">
                    <h2>Qte Production: <span class="text-xl capitalize font-semibold"><?= $value["qteProd"] ?></span></h2>
                </div>
                <div class="w-full">
                    <h2>Observations: <span class="text-xl capitalize font-semibold"><?= $value["observations"] ?></span></h2>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <?php if ($value["photo"] != 'null') : ?>
                    <div class="mb-2">
                        <img src="<?= WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="value" class="h-40 w-40 object-cover rounded shadow">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php Session::remove("errors"); ?>