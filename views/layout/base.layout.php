<?php

use Macbook\Core\Session;

$userConnect = Session::get("userConnect");
$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= WEBROOT ?>images/Royal Tailor - Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= WEBROOT ?>css/output.css">
    <title>Gestion Atelier Couture</title>
    <style>
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .collapse {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mx-auto">
        <div class="flex flex-wrap">
            <!-- Menu à gauche -->
            <nav class="w-full md:w-1/4 lg:w-1/5 sidebar background-color-indigo">
                <div class="flex flex-col justify-between h-full" style="height: 95vh;">
                    <div>
                        <img src="<?= WEBROOT ?>images/Royal Tailor - White.png" alt="Royal Tailor" class="w-full">
                    </div>
                    <ul class="flex flex-col space-y-4">
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=categorie&action=liste">
                                <img src="<?= WEBROOT ?>icons/category.svg" alt="Logo Catégorie">Catégorie
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=fournisseur&action=liste">
                                <img src="<?= WEBROOT ?>icons/truck.svg" alt="Logo Truck">Fournisseur
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=client&action=liste">
                                <img src="<?= WEBROOT ?>icons/customer.svg" alt="Logo Customer">Client
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=rs&action=liste">
                                <img src="<?= WEBROOT ?>icons/stock.svg" alt="Logo Stock">Responsable Stock
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=rp&action=liste">
                                <img src="<?= WEBROOT ?>icons/product.svg" alt="Logo Product">Responsable Production
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=vendeur&action=liste">
                                <img src="<?= WEBROOT ?>icons/carbon-sales.svg" alt="Logo Product">Vendeur
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=confection&action=liste">
                                <img src="<?= WEBROOT ?>icons/article.svg" alt="Logo Craft Article">Article Confection
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('RS') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=rs&action=liste-appro">
                                <img src="<?= WEBROOT ?>icons/article.svg" alt="Logo Craft Article">Approvisionnement Article
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('Admin') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=vente&action=liste">
                                <img src="<?= WEBROOT ?>icons/article-check.svg" alt="Logo Article">Article Vente
                            </a>
                        </li>
                        <li class="<?= add_class_hidden_lien('RP') ?>">
                            <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=vente&action=liste">
                                <img src="<?= WEBROOT ?>icons/article-check.svg" alt="Logo Article">Production Article Vente
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex pl-5 gap-2 items-center color-honeydew" onclick="toggleAccordion('collapseLayoutsProfile')">
                                <img src="<?= WEBROOT ?>icons/setting.svg" alt="Logo Setting">Paramétrage
                                <img class="pl-6" src="<?= WEBROOT ?>icons/arrow-down.svg" alt="Logo Arrow">
                            </a>
                            <div id="collapseLayoutsProfile" class="collapse ml-8">
                                <!-- Button to open modal -->
                                <button type="button" class="block pl-5 py-2 color-honeydew text-white" onclick="openModal('modalProfile')">
                                    Profile
                                </button>
                                <!-- Modal -->
                                <div id="modalProfile" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hide">
                                    <div class="bg-white rounded-lg shadow-lg w-1/3 max-h-[90vh] flex flex-col">
                                        <div class="flex justify-between items-center border-b p-4">
                                            <h2 class="color-indigo text-lg font-semibold">Panneau de configuration</h2>
                                            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('modalProfile')">&times;</button>
                                        </div>
                                        <div class="p-4 overflow-y-auto flex-grow">
                                            <h3 class="color-indigo text-xl font-semibold border-b p-4 mb-3">Mise à jour du mot de passe</h3>
                                            <div class="hidden alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="error-connection">
                                                <?= $errors["password"] ?? "" ?>
                                            </div>
                                            <form action="<?= WEBROOT ?>" class="color-indigo">
                                                <div class="mb-3">
                                                    <label for="login" class="block text-sm font-medium color-indigo">Email</label>
                                                    <input type="text" id="login" name="login" value="<?= $userConnect["login"] ?>" class="mt-1 p-2 border rounded w-full" required disabled />
                                                    <input type="hidden" name="login" value="<?= $userConnect["login"] ?>" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="block text-sm font-medium color-indigo">Nouveau mot de passe</label>
                                                    <input type="password" id="password" name="password" class="mt-1 p-2 border rounded w-full" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="block text-sm font-medium color-indigo">Confirmer le mot de passe</label>
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 p-2 border rounded w-full" required />
                                                </div>
                                                <div class="flex justify-end border-t p-4">
                                                    <input type="hidden" name="controller" value="user">
                                                    <input type="hidden" name="idUser" value="<?= $userConnect["idUser"] ?>">
                                                    <input type="hidden" name="action" value="update-password">
                                                    <button type="submit" class="btn background-color-indigo text-white p-2 rounded">Mettre à jour le mot de passe</button>
                                                </div>
                                            </form>
                                            <h3 class="color-indigo text-xl font-semibold border-b p-4 mb-3">Informations personnelles</h3>
                                            <form method="post" action="<?= WEBROOT ?>" enctype="multipart/form-data" class="color-indigo">
                                                <div class="mb-3">
                                                    <label for="name" class="block text-sm font-medium color-indigo">Nom</label>
                                                    <input type="text" id="name" name="nom" value="<?= $userConnect["nom"] ?>" class="mt-1 p-2 border rounded w-full" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="prenom" class="block text-sm font-medium color-indigo">Prénom</label>
                                                    <input type="text" id="prenom" name="prenom" value="<?= $userConnect["prenom"] ?>" class="mt-1 p-2 border rounded w-full" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tel" class="block text-sm font-medium color-indigo">Tel</label>
                                                    <input type="text" id="tel" name="tel" value="<?= $userConnect["tel"] == 'null' ? '' : $userConnect["tel"] ?>" class="mt-1 p-2 border rounded w-full" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="adresse" class="block text-sm font-medium color-indigo">Adresse</label>
                                                    <input type="text" id="adresse" name="adresse" value="<?= $userConnect["adresse"] == 'null' ? '' : $userConnect["adresse"] ?>" class="mt-1 p-2 border rounded w-full" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="salaire" class="block text-sm font-medium color-indigo">Salaire</label>
                                                    <input type="text" id="salaire" name="salaire" value="<?= $userConnect["salaire"] == 'null' ? '' : $userConnect["salaire"] ?>" class="mt-1 p-2 border rounded w-full" required disabled />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Photo</label>
                                                    <?php if ($userConnect["photo"] != 'null') : ?>
                                                        <div class="mb-2">
                                                            <img src="<?= WEBROOT . 'images/' . basename($userConnect["photo"]) ?>" alt="Client" class="h-20 w-20 object-cover rounded-full shadow">
                                                            <input type="hidden" name="photo" value="<?= basename($userConnect['photo']) ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                    <input type="file" id="name-<?= $counter ?>" name="photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                                                </div>
                                                <div class="flex justify-end border-t p-4">
                                                    <input type="hidden" name="controller" value="user">
                                                    <input type="hidden" name="action" value="save-user">
                                                    <button type="button" class="btn background-color-indigo text-white p-2 rounded mr-2" onclick="closeModal('modalProfile')">Fermer</button>
                                                    <button type="submit" class="btn background-color-black text-white p-2 rounded">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="flex flex-col space-y-4">
                        <a class="flex pl-5 gap-2 items-center color-honeydew" href="<?= WEBROOT ?>?controller=security&action=logout">
                            <img src="<?= WEBROOT ?>icons/logout.svg" alt="Logo Logout">Déconnexion
                        </a>
                        <div class="profile flex items-center pl-5 gap-2 w-full">
                            <img src="<?= WEBROOT ?>images/default.png" alt="Default profile" class="w-8 rounded-full">
                            <p class="color-honeydew ml-2 mb-0"><?= $userConnect["nom"]; ?></p>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Contenu principal -->
            <main class="w-full md:w-3/4 lg:w-4/5 px-4 py-2 background-color-honeydew color-indigo">
                <?= $content_view ?>
            </main>
        </div>
    </div>

    <script>
        function toggleAccordion(id) {
            const element = document.getElementById(id);
            if (element.classList.contains('collapse')) {
                element.classList.remove('collapse');
            } else {
                element.classList.add('collapse');
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hide');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hide');
        }
    </script>
</body>
</html>
<?php Session::remove("errors"); ?>