<?php
use Macbook\Core\Session;
$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Création Nouveau Article</h1>
</div>
<div class="w-full d-flex justify-content-center align-items-center mt-4">
    <form action="<?= WEBROOT ?>" method="post" class="w-75">
        <div class="mb-3">
            <label for="libelle" class="form-label">Libelle</label>
            <input type="text" name="libelle" class="form-control <?=add_class_invalid('libelle')?>" id="libelle">
            <div id="validationServerUsernameFeedback" class="invalid-feedback ml-2 my-0">
                <?= $errors["libelle"] ?? "" ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" name="prixAppro" class="form-control" id="prix" placeholder="XXXX">
        </div>
        <div class="mb-3">
            <label for="qte" class="form-label">Quantité en Stock</label>
            <input type="number" name="qteStock" class="form-control" id="qte" placeholder="XXXX">
        </div>
        <div class="mb-3 d-flex mt-3" style="gap: 20px;">
            <div class="d-flex align-items-center" style="gap: 20px;">
                <label for="type" class="form-label mb-0">Type</label>
                <select name="typeId" class="form-control" aria-label="Default select example" id="type">
                    <option selected>...</option>
                    <?php foreach ($type_array as $type) : ?>
                        <option value="<?= $type["idType"] ?>"><?= $type["nomType"] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="d-flex align-items-center" style="gap: 20px;">
                <label for="cat" class="form-label mb-0">Catégorie</label>
                <select name="categorieId" class="form-control" aria-label="Default select example" id="cat">
                    <option selected>...</option>
                    <?php foreach ($categorie_array as $categorie) : ?>
                        <option value="<?= $categorie["idCategorie"] ?>"><?= $categorie["nomCategorie"] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <input type="hidden" name="action" value="save-article">
            <input type="hidden" name="controller" value="article">
            <button type="submit" value="btnSave" class="btn background-color-indigo color-honeydew mb-3">Créer</button>
        </div>
    </form>
</div>
<?php Session::remove("errors"); ?>