<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="text-2xl">Liste des Catégories d'Article</h1>
</div>
<div class="color-indigo">
    <div class="w-full mb-3">
        <div class="w-full p-4 flex justify-between items-center bg-white shadow rounded">
            <form method="post" action="<?= WEBROOT ?>" class="w-full flex gap-5 items-end h-full">
                <div class="mb-3 w-full">
                    <label for="nomCategorie" class="form-label mr-2">Catégorie</label>
                    <input type="text" class="form-control <?= add_class_invalid('nomCategorie') ?> w-full border p-2 rounded" name="nomCategorie" id="nomCategorie" />
                    <div id="validationServerUsernameFeedback" class="invalid-feedback ml-2">
                        <?= $errors["nomCategorie"] ?? "" ?>
                    </div>
                </div>
                <div class="mb-3 w-full">
                    <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Type</label>
                    <select name="typeId" class=" p-2 border rounded w-full" aria-label="Default select example" id="name-<?= $counter ?>">
                        <option selected>...</option>
                        <?php foreach ($type_array as $type) : ?>
                            <option value="<?= $type["idType"] ?>"><?= $type["nomType"] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <input type="hidden" name="action" value="save-categorie">
                <input type="hidden" name="controller" value="categorie">
                <button type="submit" value="btnSave" class="btn color-honeydew background-color-indigo mb-3 p-2 rounded">Créer</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-auto w-full bg-white shadow text-indigo rounded">
            <thead>
                <tr>
                    <th class="w-1/12 pl-4 py-4 text-left">ID</th>
                    <th class="w-3/12 py-4 text-left">Nom</th>
                    <th class="w-3/12 py-4 text-left">Type</th>
                    <th class="w-3/12 py-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($categorie_array["data"] as $value) : ?>
                    <?php $counter++ ?>
                    <tr>
                        <td class="border-t-2 pl-4 py-2"><?= $counter ?></td>
                        <td class="border-t-2 py-2"><?= $value["nomCategorie"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["nomType"] ?></td>
                        <td class="border-t-2 py-2">
                            <!-- Button to open modal -->
                            <button type="button" class="btn background-color-black text-white p-2 rounded" onclick="openModal('modal-<?= $counter ?>')">
                                Modifier
                            </button>
                            <!-- Modal -->
                            <div id="modal-<?= $counter ?>" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hide">
                                <div class="bg-white rounded-lg shadow-lg w-1/3">
                                    <div class="flex justify-between items-center border-b p-4">
                                        <h1 class="text-lg font-semibold">Modifier catégorie</h1>
                                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal-<?= $counter ?>')">&times;</button>
                                    </div>
                                    <div class="p-4">
                                        <form method="post" action="<?= WEBROOT ?>">
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Nom Catégorie</label>
                                                <input type="hidden" name="idCategorie" value="<?= $value["idCategorie"] ?>">
                                                <input type="text" id="name-<?= $counter ?>" name="nomCategorie" value="<?= $value["nomCategorie"] ?>" class="mt-1 p-2 border rounded w-full" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Type</label>
                                                <select name="typeId" class="mt-1 p-2 border rounded w-full" aria-label="Default select example" id="type">
                                                    <?php foreach ($type_array as $type) : ?>
                                                        <?php if ($type["idType"] == $value["typeId"]) : ?>
                                                            <option selected value="<?= $type["idType"] ?>"><?= $type["nomType"] ?></option>
                                                        <?php else : ?>
                                                            <option value="<?= $type["idType"] ?>"><?= $type["nomType"] ?></option>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="flex justify-end border-t p-4">
                                                <input type="hidden" name="controller" value="categorie">
                                                <input type="hidden" name="action" value="update-categorie">
                                                <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modal-<?= $counter ?>')">Fermer</button>
                                                <button type="submit" class="btn background-color-black text-white p-2 rounded">Enregistrer les modifications</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <a href="<?= WEBROOT ?>?controller=categorie&action=archive-categorie&idCategorie=<?= $value["idCategorie"] ?>&isActif=<?= $value["isActif"] ?>" class="btn background-color-sunglow border-color-sunglow p-2 rounded"><?= check_state($value["isActif"]) ?></a>

                            <form method="post" action="<?= WEBROOT ?>" class="inline">
                                <input type="hidden" name="action" value="delete-categorie">
                                <input type="hidden" name="controller" value="categorie">
                                <button type="submit" class="btn background-color-red p-2 rounded" name="idCategorie" value="<?= $value["idCategorie"] ?>">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<nav class="absolute bottom-5 left-1/2 transform -translate-x-1/2 bg-white text-indigo inline-flex justify-center items-center space-x-2 rounded-lg shadow py-1 px-2">
    <a href="<?= WEBROOT ?>?controller=categorie&action=liste&page=<?= $currentPage == 0 ? $currentPage : ($currentPage - 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&lt;</a>
    <?php for ($i = 0; $i < $categorie_array["pages"]; $i++) : ?>
        <a href="<?= WEBROOT ?>?controller=categorie&action=liste&page=<?= $i ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100 <?php if ($currentPage == $i) echo 'background-color-honeydew'; ?>"><?php echo $i + 1 ?></a>
    <?php endfor ?>
    <a href="<?= WEBROOT ?>?controller=categorie&action=liste&page=<?= $currentPage == ($categorie_array["pages"] - 1) ? ($categorie_array["pages"] - 1) : ($currentPage + 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&gt;</a>
</nav>
<?php Session::remove("errors"); ?>