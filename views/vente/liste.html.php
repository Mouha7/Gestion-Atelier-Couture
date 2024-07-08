<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="text-2xl">Liste des Articles de Vente</h1>
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
                <div class="bg-white rounded-lg shadow-lg w-1/3 max-h-[90vh] flex flex-col">
                    <div class="flex justify-between items-center border-b p-4">
                        <h1 class="text-lg font-semibold">Ajouter Article de Vente</h1>
                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal')">&times;</button>
                    </div>
                    <div class="p-4 overflow-y-auto flex-grow">
                        <form method="post" action="<?= WEBROOT ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="libelle" class="block text-sm font-medium color-indigo">Libelle</label>
                                <input type="text" id="libelle" name="libelle" class="mt-1 p-2 border rounded w-full" required/>
                            </div>
                            <div class="mb-3">
                                <label for="prixVente" class="block text-sm font-medium color-indigo">Prix Vente</label>
                                <input type="number" id="prixVente" name="prixVente" class="mt-1 p-2 border rounded w-full" required/>
                            </div>
                            <div class="mb-3">
                                <label for="qteStock" class="block text-sm font-medium color-indigo">Quantité Stock</label>
                                <input type="number" id="qteStock" name="qteStock" class="mt-1 p-2 border rounded w-full" required/>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="block text-sm font-medium color-indigo">Photo</label>
                                <input type="file" id="photo" name="photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                            </div>
                            <div class="flex justify-end border-t p-4">
                                <input type="hidden" name="controller" value="vente">
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
                    <th class="w-1/12 py-4 text-left">Libelle</th>
                    <th class="w-1/12 py-4 text-left">Prix Vente</th>
                    <th class="w-1/12 py-4 text-left">Qte Stock</th>
                    <th class="w-1/12 py-4 text-left">Mnt Vente</th>
                    <th class="w-1/12 py-4 text-left">Photo</th>
                    <th class="w-3/12 py-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($array["data"] as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4"><?= $counter ?></td>
                        <td class="border-t-2 py-2" style="max-width: 30px; overflow: hidden;">
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($value["libelle"]) ?>">
                                <?= $value["libelle"] ?>
                            </div>
                        </td>
                        <td class="border-t-2 py-2"><?= $value["prixVente"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["qteStock"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["montantVente"] ?></td>
                        <td class="border-t-2 w-fit py-2 mx-auto">
                            <img class="h-8 w-8 object-cover rounded-full shadow" src="<?= $value["photo"] == 'null' ? '' : WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Client">
                        </td>
                        <td class="border-t-2 py-2">
                            <!-- Button to open modal -->
                            <button type="button" class="btn background-color-black text-white p-2 rounded" onclick="openModal('modal-<?= $counter ?>')">
                                Modifier
                            </button>
                            <!-- Modal -->
                            <div id="modal-<?= $counter ?>" class="z-10 fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hide">
                                <div class="bg-white rounded-lg shadow-lg w-1/3 max-h-[90vh] flex flex-col">
                                    <div class="flex justify-between items-center border-b p-4">
                                        <h1 class="text-lg font-semibold">Modifier Article de Vente</h1>
                                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal-<?= $counter ?>')">&times;</button>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-grow">
                                        <form method="post" action="<?= WEBROOT ?>" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Libelle</label>
                                                <input type="text" id="name-<?= $counter ?>" name="libelle" value="<?= $value["libelle"] ?>" class="mt-1 p-2 border rounded w-full" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Prix Vente</label>
                                                <input type="number" id="name-<?= $counter ?>" name="prixVente" value="<?= $value["prixVente"] ?>" class="mt-1 p-2 border rounded w-full" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Quantité Stock</label>
                                                <input type="number" id="name-<?= $counter ?>" name="qteStock" value="<?= $value["qteStock"] ?>" class="mt-1 p-2 border rounded w-full" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Photo</label>
                                                <?php if ($value["photo"] != 'null') : ?>
                                                    <div class="mb-2">
                                                        <img src="<?= WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Vente" class="h-20 w-20 object-cover rounded-full shadow">
                                                        <input type="hidden" name="photo" value="<?= basename($value['photo']) ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <input type="file" id="name-<?= $counter ?>" name="photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                                            </div>
                                            <div class="flex justify-end border-t p-4">
                                                <input type="hidden" name="idArticle" value="<?= $value["idArticle"] ?>">
                                                <input type="hidden" name="controller" value="vente">
                                                <input type="hidden" name="action" value="update-vente">
                                                <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modal-<?= $counter ?>')">Fermer</button>
                                                <button type="submit" class="btn background-color-black text-white p-2 rounded">Enregistrer les modifications</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <a href="<?= WEBROOT ?>?controller=vente&action=archive-vente&idArticle=<?= $value["idArticle"] ?>&isActif=<?= $value["isActif"] ?>" class="btn background-color-sunglow border-color-sunglow p-2 mr-1 rounded">
                                <?= check_state($value["isActif"]) ?>
                            </a>
                            <form method="post" action="<?= WEBROOT ?>" class="inline">
                                <input type="hidden" name="action" value="delete-vente">
                                <input type="hidden" name="controller" value="vente">
                                <button type="submit" class="btn background-color-red p-2 rounded" name="idArticle" value="<?= $value["idArticle"] ?>">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<nav class="absolute bottom-5 left-1/2 transform -translate-x-1/2 bg-white text-indigo inline-flex justify-center items-center space-x-2 rounded-lg shadow py-1 px-2">
    <a href="<?= WEBROOT ?>?controller=vente&action=liste&page=<?= $currentPage == 0 ? $currentPage : ($currentPage - 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&lt;</a>
    <?php for ($i = 0; $i < $array["pages"]; $i++) : ?>
        <a href="<?= WEBROOT ?>?controller=vente&action=liste&page=<?= $i ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100 <?php if ($currentPage == $i) echo 'background-color-honeydew'; ?>"><?php echo $i + 1 ?></a>
    <?php endfor ?>
    <a href="<?= WEBROOT ?>?controller=vente&action=liste&page=<?= $currentPage == ($array["pages"] - 1) ? ($array["pages"] - 1) : ($currentPage + 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&gt;</a>
</nav>
<?php Session::remove("errors"); ?>