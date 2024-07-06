<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="text-2xl">Liste des Production d'Article</h1>
</div>
<div class="color-indigo">
    <div class="w-full mb-3">
        <div class="w-full p-4 flex justify-end items-center bg-white shadow rounded">
            <!-- Button to open modal -->
            <button type="button" class="btn background-color-indigo text-white p-2 rounded" onclick="openModal('modal')">
                Nouveau
            </button>
            <!-- Modal -->
            <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hide">
                <div class="bg-white rounded-lg shadow-lg w-1/3">
                    <div class="flex justify-between items-center border-b p-4">
                        <h1 class="text-lg font-semibold">Ajouter Production Article Vente</h1>
                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal')">&times;</button>
                    </div>
                    <div class="p-4">
                        <form method="post" action="<?= WEBROOT ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="qteProd" class="block text-sm font-medium color-indigo">Qte</label>
                                <input type="number" id="qteProd" name="qteProd" class="mt-1 p-2 border rounded w-full" />
                            </div>
                            <div class="mb-3">
                                <label for="article" class="block text-sm font-medium color-indigo">Article</label>
                                <select name="idArticle" class=" p-2 border rounded w-full" aria-label="Default select example" id="article">
                                    <option selected>...</option>
                                    <?php foreach ($articles as $value) : ?>
                                        <option value="<?= $value["idArticle"] ?>"><?= $value["libelle"] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="observations" class="block text-sm font-medium color-indigo">Observations</label>
                                <textarea id="observations" name="observations" class="mt-1 p-2 border rounded w-full"></textarea>
                            </div>
                            <div class="flex justify-end border-t p-4">
                                <input type="hidden" name="controller" value="rp">
                                <input type="hidden" name="action" value="save-vente">
                                <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modal')">Fermer</button>
                                <button type="submit" class="btn background-color-black text-white p-2 rounded">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-auto w-full bg-white shadow text-indigo rounded">
            <thead>
                <tr>
                    <th class="w-1/12 pl-4 py-4 text-left">ID</th>
                    <th class="w-1/12 py-4 text-left">Date</th>
                    <th class="w-1/12 py-4 text-left">Qte</th>
                    <th class="w-1/12 py-4 text-left">Observation</th>
                    <th class="w-1/12 py-4 text-left">Article</th>
                    <th class="w-1/12 py-4 text-left">Photo</th>
                    <th class="w-1/12 py-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($array as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4"><?= $counter ?></td>
                        <td class="border-t-2 py-2"><?= $value["date"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteProd"] ?></td>
                        <td class="border-t-2 py-2" style="max-width: 30px; overflow: hidden;">
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($value["observations"] == 'null' ? '' : $value["observations"]) ?>">
                                <?= $value["observations"] == 'null' ? '' : $value["observations"] ?>
                            </div>
                        </td>
                        <td class="border-t-2 py-2"><?= $value["libelle"] ?></td>
                        <td class="border-t-2 w-fit py-2 mx-auto">
                            <img class="h-8 w-8 object-cover rounded-full shadow" src="<?= $value["photo"] == 'null' ? '' : WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Client">
                        </td>
                        <td class="border-t-2 py-2">
                            <a href="<?= WEBROOT ?>?controller=rp&action=details-vente&idProd=<?=$value["idProd"]?>" class="btn background-color-sunglow border-color-sunglow p-2 mr-1 rounded">
                                Voir Plus
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
    </div>
</div>
<?php Session::remove("errors"); ?>