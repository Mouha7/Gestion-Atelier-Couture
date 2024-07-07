<?php

use Macbook\Core\Session;

$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>

<div class="color-indigo flex justify-between flex-wrap items-center pt-3 pb-2 mb-3 border-b">
    <h1 class="text-2xl">Liste des Responsables de Stock</h1>
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
                        <h1 class="text-lg font-semibold">Ajouter Responsable de Stock</h1>
                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal')">&times;</button>
                    </div>
                    <div class="p-4 overflow-y-auto flex-grow">
                        <form method="post" action="<?= WEBROOT ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="block text-sm font-medium color-indigo">Nom</label>
                                <input type="text" id="name" name="nom" class="mt-1 p-2 border rounded w-full" required/>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="block text-sm font-medium color-indigo">Prénom</label>
                                <input type="text" id="prenom" name="prenom" class="mt-1 p-2 border rounded w-full" required/>
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="block text-sm font-medium color-indigo">Tel</label>
                                <input type="text" id="tel" name="tel" class="mt-1 p-2 border rounded w-full" />
                            </div>
                            <div class="mb-3">
                                <label for="adresse" class="block text-sm font-medium color-indigo">Adresse</label>
                                <input type="text" id="adresse" name="adresse" class="mt-1 p-2 border rounded w-full" />
                            </div>
                            <div class="mb-3">
                                <label for="salaire" class="block text-sm font-medium color-indigo">Salaire</label>
                                <input type="text" id="salaire" name="salaire" class="mt-1 p-2 border rounded w-full" required/>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="block text-sm font-medium color-indigo">Photo</label>
                                <input type="file" id="photo" name="photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                            </div>
                            <div class="flex justify-end border-t p-4">
                                <input type="hidden" name="controller" value="rs">
                                <input type="hidden" name="action" value="save-rs">
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
                    <th class="w-1/12 py-4 text-left">Nom</th>
                    <th class="w-1/12 py-4 text-left">Prénom</th>
                    <th class="w-1/12 py-4 text-left">Tel</th>
                    <th class="w-1/12 py-4 text-left">Adresse</th>
                    <th class="w-1/12 py-4 text-left">Salaire</th>
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
                        <td class="border-t-2 py-2"><?= $value["nom"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["prenom"] ?></td>
                        <td class="border-t-2 py-2"><?= $value["tel"] == 'null' ? '' : $value["tel"] ?></td>
                        <td class="border-t-2 py-2" style="max-width: 30px; overflow: hidden;">
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($value["adresse"] == 'null' ? '' : $value["adresse"]) ?>">
                                <?= $value["adresse"] == 'null' ? '' : $value["adresse"] ?>
                            </div>
                        </td>
                        <td class="border-t-2 py-2"><?= $value["salaire"] ?></td>
                        <td class="border-t-2 w-fit py-2 mx-auto">
                            <img class="h-8 w-8 object-cover rounded-full shadow" src="<?= $value["photo"] == 'null' ? '' : WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Client">
                        </td>
                        <td class="border-t-2 py-2">
                            <!-- Button to open modal -->
                            <button type="button" class="btn background-color-black text-white p-2 rounded" onclick="openModal('modal-<?= $counter ?>')">
                                Modifier
                            </button>
                            <!-- Modal -->
                            <div id="modal-<?= $counter ?>" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hide">
                                <div class="bg-white rounded-lg shadow-lg w-1/3 max-h-[90vh] flex flex-col">
                                    <div class="flex justify-between items-center border-b p-4">
                                        <h1 class="text-lg font-semibold">Modifier Responsable de Stock</h1>
                                        <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modal-<?= $counter ?>')">&times;</button>
                                    </div>
                                    <div class="p-4 overflow-y-auto flex-grow">
                                        <form method="post" action="<?= WEBROOT ?>" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Nom</label>
                                                <input type="text" id="name-<?= $counter ?>" name="nom" value="<?= $value["nom"] ?>" class="mt-1 p-2 border rounded w-full" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Prénom</label>
                                                <input type="text" id="name-<?= $counter ?>" name="prenom" value="<?= $value["prenom"] ?>" class="mt-1 p-2 border rounded w-full" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Tel</label>
                                                <input type="text" id="name-<?= $counter ?>" name="tel" value="<?= $value["tel"] == 'null' ? '' : $value["tel"] ?>" class="mt-1 p-2 border rounded w-full" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Adresse</label>
                                                <input type="text" id="name-<?= $counter ?>" name="adresse" value="<?= $value["adresse"] ?>" class="mt-1 p-2 border rounded w-full" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Salaire</label>
                                                <input type="number" id="name-<?= $counter ?>" name="salaire" value="<?= $value["salaire"] ?>" class="mt-1 p-2 border rounded w-full" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Photo</label>
                                                <?php if ($value["photo"] != 'null') : ?>
                                                    <div class="mb-2">
                                                        <img src="<?= WEBROOT . 'images/' . basename($value["photo"]) ?>" alt="Client" class="h-20 w-20 object-cover rounded-full shadow">
                                                        <input type="hidden" name="photo" value="<?= basename($value['photo']) ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <input type="file" id="name-<?= $counter ?>" name="photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                                            </div>
                                            <div class="flex justify-end border-t p-4">
                                                <input type="hidden" name="idUser" value="<?= $value["idUser"] ?>">
                                                <input type="hidden" name="controller" value="rs">
                                                <input type="hidden" name="action" value="update-rs">
                                                <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modal-<?= $counter ?>')">Fermer</button>
                                                <button type="submit" class="btn background-color-black text-white p-2 rounded">Enregistrer les modifications</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <a href="<?= WEBROOT ?>?controller=rs&action=archive-rs&idUser=<?= $value["idUser"] ?>&isActif=<?= $value["isActif"] ?>" class="btn background-color-sunglow border-color-sunglow p-2 mr-1 rounded">
                                <?= check_state($value["isActif"]) ?>
                            </a>
                            <form method="post" action="<?= WEBROOT ?>" class="inline">
                                <input type="hidden" name="action" value="delete-rs">
                                <input type="hidden" name="controller" value="rs">
                                <button type="submit" class="btn background-color-red p-2 rounded" name="idUser" value="<?= $value["idUser"] ?>">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<nav class="absolute bottom-5 left-1/2 transform -translate-x-1/2 bg-white text-indigo inline-flex justify-center items-center space-x-2 rounded-lg shadow py-1 px-2">
    <a href="<?= WEBROOT ?>?controller=rs&action=liste&page=<?= $currentPage == 0 ? $currentPage : ($currentPage - 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&lt;</a>
    <?php for ($i = 0; $i < $array["pages"]; $i++) : ?>
        <a href="<?= WEBROOT ?>?controller=rs&action=liste&page=<?= $i ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100 <?php if ($currentPage == $i) echo 'background-color-honeydew'; ?>"><?php echo $i + 1 ?></a>
    <?php endfor ?>
    <a href="<?= WEBROOT ?>?controller=rs&action=liste&page=<?= $currentPage == ($array["pages"] - 1) ? ($array["pages"] - 1) : ($currentPage + 1) ?>" class="px-3 py-2 rounded-lg hover:bg-gray-100">&gt;</a>
</nav>
<?php Session::remove("errors"); ?>