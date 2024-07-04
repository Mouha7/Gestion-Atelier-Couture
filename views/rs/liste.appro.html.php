<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
dd($conf);
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="text-2xl">Liste des Approvisionnements</h1>
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
                <div class="bg-white rounded-lg shadow-lg w-1/3 max-h-[90vh] flex flex-col">
                    <div class="flex justify-between items-center border-b p-4">
                        <h1 class="text-lg font-semibold">Ajouter Approvisionnement</h1>
                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal')">&times;</button>
                    </div>
                    <div class="p-4 overflow-y-auto flex-grow">
                        <form method="post" action="<?= WEBROOT ?>">
                            <div class="mb-3">
                                <label for="four" class="block text-sm font-medium color-indigo">Fournisseur</label>
                                <select name="idUser" class=" p-2 border rounded w-full" aria-label="Default select example" id="four">
                                    <option selected>...</option>
                                    <?php foreach ($fours as $value) : ?>
                                        <option value="<?= $value["idUser"] ?>"><?= $value["nom"] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="flex justify-between items-center gap-2">
                                <div class="mb-3">
                                    <label for="idArticle" class="block text-sm font-medium color-indigo">Article</label>
                                    <select name="idArticle" class="mt-1 p-2 border rounded w-full" aria-label="Default select example" id="idArticle">
                                        <option selected>...</option>
                                        <?php foreach ($conf as $value) : ?>
                                            <option value="<?= $value["idArticle"] ?>"><?= $value["libelle"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="qteAppro" class="block text-sm font-medium color-indigo">Quantité</label>
                                    <input type="text" id="qteAppro" name="qteAppro" class="mt-1 p-2 border rounded w-full" required />
                                </div>
                                <div style="margin-top: 14px;">
                                    <button type="submit" class="btn background-color-black text-white p-2 rounded">Ajouter</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <table class="table-auto w-full bg-white text-indigo rounded">
                                    <thead>
                                        <tr>
                                            <th class="w-1/4 pt-4 text-left">Article</th>
                                            <th class="w-1/4 pt-4 text-left">Qte</th>
                                            <th class="w-1/4 pt-4 text-left">Prix</th>
                                            <th class="w-1/4 pt-4 text-left">Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border-t-2 pt-4">test</td>
                                            <td class="border-t-2 pt-4">test</td>
                                            <td class="border-t-2 pt-4">test</td>
                                            <td class="border-t-2 pt-4">test</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-3 w-full flex justify-end items-center">
                                Total &nbsp;:&nbsp;<span class="color-red text-xl">10000 Franc CFA</span>
                            </div>
                        </form>
                        <div class="flex justify-end border-t p-4">
                            <input type="hidden" name="controller" value="rs">
                            <input type="hidden" name="action" value="save-appro">
                            <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modal')">Fermer</button>
                            <button type="submit" class="btn background-color-black text-white p-2 rounded">Enregistrer</button>
                        </div>
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
                    <th class="w-1/12 py-4 text-left">Prix</th>
                    <th class="w-1/12 py-4 text-left">Montant</th>
                    <th class="w-1/12 py-4 text-left">Observation</th>
                    <th class="w-1/12 py-4 text-left">Fournisseur</th>
                    <th class="w-1/12 py-4 text-left">Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($array as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4"><?= $counter ?></td>
                        <td class="border-t-2 py-2"><?= $value["date"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteAppro"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["prixUnitaire"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["montantAppro"] ?></td>
                        <td class="border-t-2 py-2" style="max-width: 30px; overflow: hidden;">
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($value["observation"] == 'null' ? '' : $value["observation"]) ?>">
                                <?= $value["observation"] == 'null' ? '' : $value["observation"] ?>
                            </div>
                        </td>
                        <td class="border-t-2 py-2"><?= $value["nom"] ?></td>
                        <td class="border-t-2 w-fit py-2 mx-auto">
                            <img class="h-8 w-8 object-cover rounded-full shadow" src="<?= $value["photo"] == 'null' ? '' : WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Client">
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php Session::remove("errors"); ?>