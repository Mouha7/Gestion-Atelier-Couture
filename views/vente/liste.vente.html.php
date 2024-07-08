<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="text-2xl">Liste des Ventes</h1>
</div>
<div class="color-indigo">
    <div class="w-full mb-3">
        <div class="w-full p-4 flex justify-end items-center bg-white shadow rounded">
            <!-- Button to open modal -->
            <button type="button" class="btn background-color-indigo text-white p-2 rounded" onclick="openModal('modal')">
                Nouveau
            </button>
            <!-- Modal -->
            <div id="modal" class="z-10 fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hide">
                <div class="bg-white rounded-lg shadow-lg w-1/3 max-h-[100vh] flex flex-col">
                    <div class="flex justify-between items-center border-b p-4">
                        <h1 class="text-lg font-semibold">Ajouter Vente</h1>
                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal')">&times;</button>
                    </div>
                    <div class="p-4 overflow-y-auto flex-grow">
                        <form method="post" action="<?= WEBROOT ?>">
                            <div class="mb-3">
                                <label for="client" class="block text-sm font-medium color-indigo">Client</label>
                                <select name="idUser" class=" p-2 border rounded w-full" aria-label="Default select example" id="client" required>
                                    <option selected>...</option>
                                    <?php foreach ($client as $value) : ?>
                                        <option <?php
                                                if (Session::get('panier') != false && Session::get('panier')->client == $value['idUser']) {
                                                    echo "selected";
                                                }
                                                ?> value="<?= $value["idUser"] ?>"><?= $value["prenom"] ?> <?= $value["nom"] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="flex justify-between items-center gap-2">
                                <div class="mb-3">
                                    <label for="idArticle" class="block text-sm font-medium color-indigo">Production Article</label>
                                    <select name="idArticle" class="mt-1 p-2 border rounded w-full" aria-label="Default select example" id="idArticle" required>
                                        <option selected>...</option>
                                        <?php foreach ($articles as $value) : ?>
                                            <option value="<?= $value["idArticle"] ?>"><?= $value["libelle"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="qteVente" class="block text-sm font-medium color-indigo">Quantité</label>
                                    <input type="text" id="qteVente" name="qteAppro" class="mt-1 p-2 border rounded w-full" required />
                                </div>
                                <div style="margin-top: 14px;">
                                    <input type="hidden" name="action" value="save-article">
                                    <input type="hidden" name="controller" value="vente">
                                    <button type="submit" class="btn background-color-black text-white p-2 rounded">Ajouter</button>
                                </div>
                            </div>
                            <?php if (Session::get('panier') != false) : ?>
                                <div class="mb-3">
                                    <table class="table-auto w-full bg-white text-indigo rounded">
                                        <thead>
                                            <tr>
                                                <th class="w-1/4 pt-4 pr-1 text-left">Article</th>
                                                <th class="w-1/4 pt-4 pr-1 text-left">Qte</th>
                                                <th class="w-1/4 pt-4 pr-1 text-left">Prix</th>
                                                <nt class="w-1/4 pt-4 pr-1 text-left">Montant</nt>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (Session::get('panier')->data as $value) : ?>
                                                <tr>
                                                    <td class="border-t-2 pt-4 pr-1"><?= $value["libelle"] ?></td>
                                                    <td class="border-t-2 pt-4 pr-1"><?= $value["qteAppro"] ?></td>
                                                    <td class="border-t-2 pt-4 pr-1"><?= $value["prixVente"] ?></td>
                                                    <td class="border-t-2 pt-4 pr-1"><?= $value["montantArticle"] ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-3 w-full flex justify-end items-center">
                                    Total &nbsp;:&nbsp;<span class="color-red text-xl"><?= Session::get('panier')->total ?> Franc CFA</span>
                                </div>
                            <?php endif ?>
                            <div class="mb-3">
                                <label for="observations" class="block text-sm font-medium color-indigo">Observations</label>
                                <textarea id="observations" class="mt-1 p-2 border rounded w-full" name="observations"></textarea>
                            </div>
                        </form>
                        <div class="flex justify-end border-t p-4">
                            <input type="hidden" name="controller" value="rs">
                            <input type="hidden" name="action" value="save-appro">
                            <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modal')">Fermer</button>
                            <a href="<?= WEBROOT ?>?controller=vente&action=save-article-vente" class="btn background-color-black text-white p-2 rounded">Enregistrer</a>
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
                    <th class="w-1/12 py-4 text-left">Montant</th>
                    <th class="w-1/12 py-4 text-left">Observation</th>
                    <th class="w-1/12 py-4 text-left">Client</th>
                    <th class="w-1/12 py-4 text-left">Tel</th>
                    <th class="w-1/12 py-4 text-left">Photo</th>
                    <th class="w-1/12 py-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($array["data"] as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4"><?= $counter ?></td>
                        <td class="border-t-2 py-2"><?= $value["dateVente"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteVente"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["montantVente"] ?></td>
                        <td class="border-t-2 py-2" style="max-width: 30px; overflow: hidden;">
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($value["observations"] == 'null' ? '' : $value["observations"]) ?>">
                                <?= $value["observations"] == 'null' ? '' : $value["observations"] ?>
                            </div>
                        </td>
                        <td class="border-t-2 py-2"><?= $value["prenom"] ?> <?= $value["nom"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["tel"] ?></td>
                        <td class="border-t-2 w-fit py-2 mx-auto">
                            <img class="h-8 w-8 object-cover rounded-full shadow" src="<?= $value["photo"] == 'null' ? '' : WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Client">
                        </td>
                        <td class="border-t-2 py-2">
                            <a href="<?= WEBROOT ?>?controller=vente&action=detail-vente&idVendeur=<?= $value["idVendeur"] ?>&idUser=<?= $value["idUser"] ?>" class="btn background-color-sunglow border-color-sunglow p-2 mr-1 rounded">
                                Voir Plus
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<nav class="absolute bottom-5 left-1/2 transform -translate-x-1/2 bg-white text-indigo inline-flex justify-center items-center space-x-2 rounded-lg shadow py-1 px-2">
    <a href="<?= WEBROOT ?>?controller=vente&action=liste-vente&page=<?= $currentPage == 0 ? $currentPage : ($currentPage - 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&lt;</a>
    <?php for ($i = 0; $i < $array["pages"]; $i++) : ?>
        <a href="<?= WEBROOT ?>?controller=vente&action=liste-vente&page=<?= $i ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100 <?php if ($currentPage == $i) echo 'background-color-honeydew'; ?>"><?php echo $i + 1 ?></a>
    <?php endfor ?>
    <a href="<?= WEBROOT ?>?controller=vente&action=liste-vente&page=<?= $currentPage == ($array["pages"] - 1) ? ($array["pages"] - 1) : ($currentPage + 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&gt;</a>
</nav>
<?php Session::remove("errors"); ?>